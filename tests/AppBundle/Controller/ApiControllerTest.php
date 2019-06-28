<?php

/**
 * ApiController Test
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * ApiControllerTest
 */
class ApiControllerTest extends WebTestCase
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
     * Test getUsersAction method of ApiController (Ajax)
     * @access public
     *
     * @return void
     */
    public function testGetUsers(): void
    {
        $this->logIn('admin');

        $this->client->request(
            'GET',
            '/api/users/1',
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $datas = json_decode($this->client->getResponse()->getContent(), true);
        
        $firstUser = $datas[0];

        $this->assertEquals(10, count($datas));

        $this->assertNotEmpty($firstUser['id']);
        $this->assertNotEmpty($firstUser['username']);
        $this->assertNotEmpty($firstUser['email']);
        $this->assertNotEmpty($firstUser['role']);
    }

    /**
     * Test getTasksAction method of ApiController (Ajax) with current param
     * @access public
     *
     * @return void
     */
    public function testGetCurrentTasks(): void
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $manager->getRepository(Task::class)->findOneByTitle('Test ajax');

        $this->logIn('main');

        $this->client->request(
            'GET',
            '/api/tasks/current/1',
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $datas = json_decode($this->client->getResponse()->getContent(), true);
        
        $firstTask = $datas[0];

        $this->assertEquals(10, count($datas));

        $this->assertEquals($task->getId(), $firstTask['id']);
        $this->assertNotEmpty($firstTask['title']);
        $this->assertNotEmpty($firstTask['content']);
    }

    /**
     * Test getTasksAction method of ApiController (Ajax) with finish param
     * @access public
     *
     * @return void
     */
    public function testGetFinishTasks(): void
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $manager->getRepository(Task::class)->findOneByTitle('Test finish ajax');

        $this->logIn('main');

        $this->client->request(
            'GET',
            '/api/tasks/finish/1',
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $datas = json_decode($this->client->getResponse()->getContent(), true);
        
        $firstTask = $datas[0];

        $this->assertEquals(10, count($datas));

        $this->assertEquals($task->getId(), $firstTask['id']);
        $this->assertNotEmpty($firstTask['title']);
        $this->assertNotEmpty($firstTask['content']);
    }

    /**
     * Test user can't access if not admin
     * @access public
     *
     * @return void
     */
    public function testUserCantAccessIfNotAdmin(): void
    {
        $this->logIn('secondary');

        $this->client->request(
            'GET',
            '/api/users/1',
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $statusCode = $this->client->getResponse()->getStatusCode();

        $this->assertEquals(403, $statusCode);
    }

    /**
     * Test user can't access if not auth
     * @access public
     * @dataProvider apiUrlProvider
     *
     * @return void
     */
    public function testUserCantAccessIfNotAuth($url): void
    {
        $this->client->request(
            'GET',
            $url,
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $crawler = $this->client->followRedirect();
        $this->assertSame(' To Do List - Login', $crawler->filter('title')->text());
    }

    /**
     * Api url provider
     * @access public
     * 
     * @return array
     */
    public function apiUrlProvider(): array
    {
        return [
            [
                '/api/users/1',
            ],
            [
                '/api/tasks/current/1'
            ]
        ];
    }

    /**
     * Test url with null request header (Ajax)
     * @access public
     * @dataProvider apiUrlProvider
     *
     * @return void
     */
    public function testUrlWithNullRequestHeader($url): void
    {
        $this->logIn('admin');

        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    /**
     * Test url with a bad request method (Ajax)
     * @access public
     * @dataProvider apiUrlProvider
     *
     * @return void
     */
    public function testUrlWithBadRequestMethod($url): void
    {
        $this->logIn('admin');

        $this->client->request(
            'PATCH',
            $url,
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $this->assertEquals(405, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test getComments with a bad request method (Ajax)
     * @access public
     * @dataProvider apiUrlBadParamProvider
     *
     * @return void
     */
    public function testUrlWithBadUrlParam($url): void
    {
        $this->logIn('admin');

        $this->client->request(
            'GET',
            $url,
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Api url with bad param
     * @access public
     *
     * @return array
     */
    public function apiUrlBadParamProvider(): array
    {
        return [
            [
                '/api/users/test'
            ],
            [
                '/api/tasks/current/test'
            ]
        ];
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