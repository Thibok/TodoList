<?php
declare(strict_types=1);

/**
 * Global functional tests
 */

namespace Tests\AppBundle;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * ApplicationAvailabilityFunctionalTest
 */
class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @var Client
     * @access private
     */
    private $client;
    
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * Test pages where role user required is successful
     * @access public
     * @param string $url
     * @dataProvider userUrlProvider
     * 
     * @return void
     */
    public function testPageNeedToBeUserIsSuccessful($url): void
    {
        $this->logIn('main');

        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Test pages where role admin required is successful
     * @access public
     * @param string $url
     * @dataProvider adminUrlProvider
     * 
     * @return void
     */
    public function testPageNeedToBeAdminIsSuccessful($url): void
    {
        $this->logIn('admin');

        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Url values for testPageNeedToBeUserIsSuccessful
     * @access public
     *
     * @return array
     */
    public function userUrlProvider(): array
    {
        $this->setUp();

        $manager = $this->client->getContainer()->get('doctrine')->getManager();

        $task = $manager->getRepository(Task::class)->findOneByTitle('Task up');
        $editUrl = '/tasks/' .$task->getId(). '/edit';

        return array(
            array('/'),
            array('/tasks/current'),
            array('/tasks/finish'),
            array('/tasks/create'),
            array($editUrl),
        );
    }

    /**
     * Url values for testPageNeedToBeAdminIsSuccessful
     * @access public
     *
     * @return array
     */
    public function adminUrlProvider(): array
    {
        $this->setUp();

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $user = $manager->getRepository(User::class)->findOneByUsername('JeanTest');

        $this->tearDown();

        $editUrl = '/users/' .$user->getId(). '/edit';

        return array(
            array('/users'),
            array('/users/create'),
            array($editUrl),
        );
    }

    /**
     * Test no auth user can't access pages under security
     * @access public
     * @param string $url
     * @dataProvider adminUrlProvider
     * 
     * @return void
     */
    public function testNoAuthUserAccess($url): void
    {
        $this->client->request('GET', $url);
        $crawler = $this->client->followRedirect();

        $this->assertSame(' To Do List - Login', $crawler->filter('title')->text());
    }

    /**
     * Url values for testNoAuthUserAccess
     * @access public
     *
     * @return array
     */
    public function authUrlProvider(): array
    {
        
        return [
            [
                '/'
            ],
            [
                '/tasks/create'
            ],
            [
                '/users/create'
            ]
        ];
    }

    /**
     * Test auth user can't access page for admin
     * @access public
     * @param string $url
     * 
     * @return void
     */
    public function testAuthUserCantAccessPageForAdmin(): void
    {
        $this->logIn('main');

        $this->client->request('GET', '/users/create');

        $response = $this->client->getResponse();

        $this->assertEquals(403, $response->getStatusCode());
    }

    /**
     * Log user
     * @access private
     * @param string $userRole
     *
     * @return void
     */
    private function logIn($userRole): void
    {
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';
        $manager = $this->client->getContainer()->get('doctrine')->getManager();

        if ($userRole == 'main') {
            $user = $manager->getRepository(User::class)->findOneByUsername('BryanTest'); 
        }

        if ($userRole == 'admin') {
            $user = $manager->getRepository(User::class)->findOneByUsername('SuperAdmin'); 
        }

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, $user->getRoles());
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown(): void
    {
        $this->client = null;
    }
}