<?php
declare(strict_types=1);

/**
 * SecurityController Test
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * SecurityControllerTest
 */
class SecurityControllerTest extends WebTestCase
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
     * Test the path to login
     * @access public
     *
     * @return void
     */
    public function testPathToLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $link = $crawler->selectLink('Login')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(' To Do List - Login', $crawler->filter('title')->text());
    }

    /**
     * Test Login method of SecurityController
     * @access public
     *
     * @return void
     */
    public function testLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'BryanTest';
        $form['_password'] = 'goodpassword';

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
        $this->assertEquals(1, $crawler->filter('a:contains("Déconnexion")')->count());
    }

    /**
     * Test login with bad values
     * @access public
     * @param string $username
     * @param string $pass
     * @param string $message
     * @dataProvider valuesLoginForm
     *
     * @return void
     */
    public function testLoginWithBadValues($username, $pass, $message): void
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = $username;
        $form['_password'] = $pass;

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());
        $this->assertSame($message, $crawler->filter('div.alert-danger')->text());
    }

    /**
     * Login values
     * @access public
     *
     * @return array
     */
    public function valuesLoginForm(): array
    {
        return [
            [
                '',
                '',
                'Le nom d\'utilisateur n\'a pas pu être trouvé.'
            ],
            [
                'BryanTest',
                'badpass',
                'Le nom d\'utilisateur ou le mot de passe est incorrect.'
            ]
        ];
    }

    /**
     * Test Logout
     * @access public
     *
     * @return void
     */
    public function testLogout(): void
    {
        $this->logIn('main');
        $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $this->assertEquals(0, $crawler->filter('a:contains("Déconnexion")')->count());
    }

    /**
     * Test path to logout
     * @access public
     *
     * @return void
     */
    public function testPathToLogout(): void
    {
        $this->logIn('main');
        $crawler = $this->client->request('GET', '/');
        $link = $crawler->selectLink('Déconnexion')->link();

        $this->client->click($link);
        $crawler = $this->client->followRedirect();

        $this->assertEquals(0, $crawler->filter('a:contains("Déconnexion")')->count());
        $this->assertSame(' To Do List - Login', $crawler->filter('title')->text());
    }

    /**
     * Test auth user can't access login page
     * @access public
     *
     * @return void
     */
    public function testAuthUserCantAccessLogin(): void
    {
        $this->login('main');

        $this->client->request('GET', '/login');
        $crawler = $this->client->followRedirect();

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