<?php
declare(strict_types=1);

/**
 * UserController tests
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * UserControllerTest
 */
class UserControllerTest extends WebTestCase
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
     * Test addAction method of UserController
     * @access public
     *
     * @return void
     */
    public function testAddUser(): void
    {
        $this->logIn('admin');
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['appbundle_user[username]'] = 'newUser';
        $form['appbundle_user[password][first]'] = 'goodpass985';
        $form['appbundle_user[password][second]'] = 'goodpass985';
        $form['appbundle_user[email]'] = 'newUser@yahoo.com';
        $selectOptions = $form['appbundle_user[role]']->availableOptionValues();
        $form['appbundle_user[role]']->select($selectOptions[0]);

        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $encoder = $this->client->getContainer()->get('security.password_encoder');
        $user = $manager->getRepository(User::class)->findOneByUsername('newUser');

        $username = $user->getUsername();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $role = $user->getRole();

        $this->assertSame('newUser', $username);
        $this->assertTrue($encoder->isPasswordValid($user, 'goodpass985'));
        $this->assertSame('newUser@yahoo.com', $email);
        $this->assertSame('ROLE_USER', $role);
    }

    /**
     * Test path to access add user page
     * @access public
     *
     * @return void
     */
    public function testPathToAddUser(): void
    {
        $this->logIn('admin');

        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(' To Do List - Créer un utilisateur', $crawler->filter('title')->text());
    }

    /**
     * Test editAction method of UserController
     * @access public
     *
     * @return void
     */
    public function testEditUser(): void
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $encoder = $this->client->getContainer()->get('security.password_encoder');
        $userBeforeEdit = $manager->getRepository(User::class)->findOneByUsername('updateUsername');
        $url = '/users/' .$userBeforeEdit->getId(). '/edit';

        $this->logIn('admin');
        $crawler = $this->client->request('GET', $url);

        $form = $crawler->selectButton('Modifier')->form();
        $form['appbundle_user[username]'] = 'usernameUpdated';
        $form['appbundle_user[password][first]'] = 'newUpdatedPass14';
        $form['appbundle_user[password][second]'] = 'newUpdatedPass14';
        $form['appbundle_user[email]'] = 'newUpdatedEmail@yahoo.com';
        $selectOptions = $form['appbundle_user[role]']->availableOptionValues();
        $form['appbundle_user[role]']->select($selectOptions[1]);
        
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $userEdited = $manager->getRepository(User::class)->findOneByUsername('usernameUpdated');

        $username = $userEdited->getUsername();
        $email = $userEdited->getEmail();
        $role = $userEdited->getRole();

        $this->assertSame('usernameUpdated', $username);
        $this->assertTrue($encoder->isPasswordValid($userEdited, 'newUpdatedPass14'));
        $this->assertSame('newUpdatedEmail@yahoo.com', $email);
        $this->assertSame('ROLE_ADMIN', $role);
        $this->assertEquals($userBeforeEdit->getId(), $userEdited->getId());
    }

    /**
     * Test path to access edit user page
     * @access public
     *
     * @return void
     */
    public function testPathToEditUser(): void
    {
        $this->logIn('admin');

        $crawler = $this->client->request('GET', '/users');

        $link = $crawler->filter('.edit-user-link')->eq(0)->link();
        $crawler = $this->client->click($link);

        $this->assertSame(' To Do List - Modifier un utilisateur', $crawler->filter('title')->text());
    }

    /**
     * Test addAction method of UserController with bad values
     * @access public
     * @param string $username
     * @param string $firstPass
     * @param string $secondPass
     * @param string $email
     * @param int $result
     * @dataProvider valuesUserForm
     * 
     * @return void
     */
    public function testAddUserWithBadValues($username, $firstPass, $secondPass, $email, $result): void
    {
        $this->logIn('admin');
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['appbundle_user[username]'] = $username;
        $form['appbundle_user[password][first]'] = $firstPass;
        $form['appbundle_user[password][second]'] = $secondPass;
        $form['appbundle_user[email]'] = $email;
        
        $crawler = $this->client->submit($form);

        $this->assertEquals($result, $crawler->filter('span.form-error-message')->count());
    }

    /**
     * Test editAction method of UserController with bad values
     * @access public
     * @param string $username
     * @param string $firstPass
     * @param string $secondPass
     * @param string $email
     * @param int $result
     * @dataProvider valuesUserForm
     * 
     * @return void
     */
    public function testEditUserWithBadValues($username, $firstPass, $secondPass, $email, $result): void
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $user = $manager->getRepository(User::class)->findOneByUsername('JeanTest');
        $url = '/users/' .$user->getId(). '/edit';

        $this->logIn('admin');
        $crawler = $this->client->request('GET', $url);

        $form = $crawler->selectButton('Modifier')->form();
        $form['appbundle_user[username]'] = $username;
        $form['appbundle_user[password][first]'] = $firstPass;
        $form['appbundle_user[password][second]'] = $secondPass;
        $form['appbundle_user[email]'] = $email;
        
        $crawler = $this->client->submit($form);

        $this->assertEquals($result, $crawler->filter('span.form-error-message')->count());
    }

    /**
     * Form values
     * @access public
     *
     * @return array
     */
    public function valuesUserForm(): array
    {
        return [
            [
                '',
                '',
                '',
                '',
                3
            ],
            [
                'j',
                'f',
                'f',
                'l',
                6
            ],
            [
                'averyveryveryveryverylongusername',
                'averyveryveryveryveryveryveryverylonguepass45861',
                'averyveryveryveryveryveryveryverylonguepass45861',
                'averyveryveryveryveryveryveryveryveryveryverylongemail@gmail.com',
                2
            ],
            [
                'bad@username',
                'badpassss',
                'badpassss',
                'mybademail.com',
                3
            ],
            [
                'bad@username',
                'badpassss',
                'badpasssss',
                'mybademail.com',
                3
            ],
        ];
    }

    /**
     * Test edit with bad url param
     * @access public
     * @param string action
     * 
     * @return void
     */
    public function testEditWithBadUrlParam(): void
    {
        $this->logIn('admin');

        $this->client->request('GET', '/users/fdfd/edit');
        $response = $this->client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Test listAction
     * @access public
     *
     * @return void
     */
    public function testListUsers()
    {
        $this->logIn('admin');
        $crawler = $this->client->request('GET', '/users');

        $nbUser = $crawler->filter('.user-row')->count();
        $firstUserName = $crawler->filter('.td-user-username')->eq(0)->text();
        $firstUserEmail = $crawler->filter('.td-user-email')->eq(0)->text();
        $firstUserRole = $crawler->filter('.td-user-role')->eq(0)->text();

        $this->assertEquals(10, $nbUser);
        $this->assertSame('newUser', $firstUserName);
        $this->assertSame('newUser@yahoo.com', $firstUserEmail);
        $this->assertSame('Utilisateur', $firstUserRole);
    }

    /**
     * Test path to access list users page
     * @access public
     *
     * @return void
     */
    public function testPathToListUsers(): void
    {
        $this->logIn('admin');

        $crawler = $this->client->request('GET', '/users/create');

        $link = $crawler->selectLink('Retour à la liste des utilisateurs')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(' To Do List - Liste des utilisateurs', $crawler->filter('title')->text());

        $crawler = $this->client->request('GET', '/users');
        $linkEdit = $crawler->filter('.edit-user-link')->eq(0)->link();
        $crawler = $this->client->click($linkEdit);

        $linkUsers = $crawler->selectLink('Retour à la liste des utilisateurs')->link();
        $crawler = $this->client->click($linkUsers);

        $this->assertSame(' To Do List - Liste des utilisateurs', $crawler->filter('title')->text());
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