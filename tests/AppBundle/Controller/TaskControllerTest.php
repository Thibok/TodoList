<?php
declare(strict_types=1);

/**
 * TaskController Test
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * TaskControllerTest
 */
class TaskControllerTest extends WebTestCase
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
     * Test addAction method of TaskController
     * @access public
     *
     * @return void
     */
    public function testAddTask(): void
    {
        $this->logIn('main');
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['appbundle_task[title]'] = 'My first task';
        $form['appbundle_task[content]'] = 'A good task';
        
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $manager->getRepository(Task::class)->findOneByTitle('My first task');

        $taskTitle = $task->getTitle();
        $taskContent = $task->getContent();
        $taskUser = $task->getUser();

        $this->assertSame('My first task', $taskTitle);
        $this->assertSame('A good task', $taskContent);
        $this->assertSame('BryanTest', $taskUser->getUsername());
    }

    /**
     * Test editAction method of TaskController
     * @access public
     *
     * @return void
     */
    public function testEditTask(): void
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $taskBeforeEdit = $manager->getRepository(Task::class)->findOneByTitle('Need update');
        $url = '/tasks/' .$taskBeforeEdit->getId(). '/edit';

        $this->logIn('main');
        $crawler = $this->client->request('GET', $url);

        $form = $crawler->selectButton('Modifier')->form();
        $form['appbundle_task[title]'] = 'A simple task';
        $form['appbundle_task[content]'] = 'Simple content';
        
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $taskEdited = $manager->getRepository(Task::class)->findOneByTitle('A simple task');

        $taskTitle = $taskEdited->getTitle();
        $taskContent = $taskEdited->getContent();

        $this->assertSame('A simple task', $taskTitle);
        $this->assertSame('Simple content', $taskContent);
        $this->assertEquals($taskBeforeEdit->getId(), $taskEdited->getId());
    }

    /**
     * Test addAction method of TaskController with bad values
     * @access public
     * @param string $title
     * @param string $content
     * @param int $result
     * @dataProvider valuesTaskForm
     * 
     * @return void
     */
    public function testAddTaskkWithBadValues($title, $content, $result): void
    {
        $this->logIn('main');
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['appbundle_task[title]'] = $title;
        $form['appbundle_task[content]'] = $content;
        
        $crawler = $this->client->submit($form);

        $this->assertEquals($result, $crawler->filter('span.form-error-message')->count());
    }

    /**
     * Test editAction method of TaskController with bad values
     * @access public
     * @param string $title
     * @param string $content
     * @param int $result
     * @dataProvider valuesTaskForm
     * 
     * @return void
     */
    public function testEditTaskWithBadValues($title, $content, $result): void
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $manager->getRepository(Task::class)->findOneByTitle('Best task');
        $url = '/tasks/' .$task->getId(). '/edit';

        $this->logIn('main');
        $crawler = $this->client->request('GET', $url);

        $form = $crawler->selectButton('Modifier')->form();
        $form['appbundle_task[title]'] = $title;
        $form['appbundle_task[content]'] = $content;
        
        $crawler = $this->client->submit($form);

        $this->assertEquals($result, $crawler->filter('span.form-error-message')->count());
    }

    /**
     * Form values
     * @access public
     *
     * @return array
     */
    public function valuesTaskForm(): array
    {
        return [
            [
                '',
                '',
                2
            ],
            [
                'n',
                '<bad content>',
                3
            ],
            [
                'a very very very very very very very very long title',
                'baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                ba',
                2
            ],
            [
                'bad@title.com',
                '<bad content>',
                2
            ]
        ];
    }

    /**
     * Test user can't manage task if he is not the owner
     * @access public
     * @param string action
     * @dataProvider UrlActionValues
     * 
     * @return void
     */
    public function testUserCantManageTaskIfHeIsNotTheOwner($action): void
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $manager->getRepository(Task::class)->findOneByTitle('Best task');

        $url = '/tasks/' .$task->getId(). '/' .$action;
        $this->logIn('secondary');

        $this->client->request('GET', $url);
        $response = $this->client->getResponse();

        $this->assertEquals(403, $response->getStatusCode());
    }

    /**
     * Url action of Tasks
     * @access public
     *
     * @return array
     */
    public function UrlActionValues(): array
    {
        return [
            [
                'edit'
            ],
            [
                'toggle'
            ],
            [
                'delete'
            ]
        ];
    }

    /**
     * Test delete Task
     * @access public
     *
     * @return void
     */
    public function testDeleteTask(): void
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $manager->getRepository(Task::class)->findOneByTitle('Delete me');
        $url = '/tasks/' .$task->getId(). '/delete';

        $this->logIn('main');

        $this->client->request('GET', $url);
        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

        $this->client->request('GET', $url);
        $response = $this->client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Test toggle Task
     * @access public
     *
     * @return void
     */
    public function testToggleTask(): void
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $manager->getRepository(Task::class)->findOneByTitle('Toggle me');
        $url = '/tasks/' .$task->getId(). '/toggle';

        $this->logIn('main');

        $this->client->request('GET', $url);
        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

        $toggleTask = $manager->getRepository(Task::class)->findOneByTitle('Toggle me');

        $this->assertTrue($toggleTask->isDone());
    }

    /**
     * Test task urls with bad url param
     * @access public
     * @param string action
     * @dataProvider UrlActionValues
     * 
     * @return void
     */
    public function testUrlWithBadUrlParam($action): void
    {
        $url = '/tasks/fdfd/' .$action;
        $this->logIn('main');

        $this->client->request('GET', $url);
        $response = $this->client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Test listAction with "current" url param
     * @access public
     *
     * @return void
     */
    public function testListCurrentTasks(): void
    {
        $this->logIn('main');
        $crawler = $this->client->request('GET', '/tasks/current');

        $nbTasks = $crawler->filter('.card')->count();
        $firstTaskName = $crawler->filter('.task-link')->eq(0)->text();
        $firstTaskContent = $crawler->filter('.task-content')->eq(0)->text();

        $this->assertEquals(10, $nbTasks);
        $this->assertSame('My first task', $firstTaskName);
        $this->assertSame('A good task', $firstTaskContent);
    }

    /**
     * Test listAction with "finish" url param
     * @access public
     *
     * @return void
     */
    public function testListFinishTasks(): void
    {
        $this->logIn('main');
        $crawler = $this->client->request('GET', '/tasks/finish');

        $nbTasks = $crawler->filter('.card')->count();
        $firstTaskName = $crawler->filter('.task-link')->eq(0)->text();
        $firstTaskContent = $crawler->filter('.task-content')->eq(0)->text();

        $this->assertEquals(10, $nbTasks);
        $this->assertSame('Im a finish task', $firstTaskName);
        $this->assertSame('Im a finish task', $firstTaskContent);
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
            $user = $manager->getRepository('AppBundle:User')->findOneByUsername('BryanTest'); 
        }

        if ($userRole == 'secondary') {
            $user = $manager->getRepository('AppBundle:User')->findOneByUsername('JeanTest'); 
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
