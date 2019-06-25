<?php
declare(strict_types=1);

/**
 * GlobalController tests
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * GlobalControllerTest
 */
class GlobalControllerTest extends WebTestCase
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
     * Test indexAction
     * @access public
     *
     * @return void
     */
    public function testHomepage(): void
    {
        $this->logIn('main');
        $crawler = $this->client->request('GET', '/');

        $this->assertSame(' To Do List - Accueil', $crawler->filter('title')->text());
    }

    /**
     * Test path to access homepage
     * @access public
     *
     * @return void
     */
    public function testPathToHomepage(): void
    {
        $this->logIn('main');

        $crawler = $this->client->request('GET', '/tasks/create');

        $link = $crawler->selectLink('Accueil')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(' To Do List - Accueil', $crawler->filter('title')->text());
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

        if ($userRole == 'secondary') {
            $user = $manager->getRepository(User::class)->findOneByUsername('JeanTest'); 
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