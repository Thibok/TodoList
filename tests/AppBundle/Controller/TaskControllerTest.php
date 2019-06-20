<?php

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
        $this->logIn();
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

        $this->logIn();
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
        $this->logIn();
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

        $this->logIn();
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
     * Log user
     * @access private
     *
     * @return void
     */
    private function logIn(): void
    {
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';
        $manager = $this->client->getContainer()->get('doctrine')->getManager(); 
        $user = $manager->getRepository('AppBundle:User')->findOneByUsername('BryanTest'); 

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
