<?php
declare(strict_types=1);

/**
 * Task Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Task;
use AppBundle\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * TaskFixtures
 */
class TaskFixtures extends Fixture implements DependentFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     * @access private
     */
    private $container;

    /**
     * Load fixtures
     * @access public
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $env = $this->container->get('kernel')->getEnvironment();

        if ($env == 'test') {
            $taskForUpdate = new Task;
            $taskForUpdate->setTitle('Need update');
            $taskForUpdate->setContent('Bad content');
            $taskForUpdate->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskBadValues = new Task;
            $taskBadValues->setTitle('Best task');
            $taskBadValues->setContent('Best content');
            $taskBadValues->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskForToggle = new Task;
            $taskForToggle->setTitle('Toggle me');
            $taskForToggle->setContent('Toggle');
            $taskForToggle->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskForDelete = new Task;
            $taskForDelete->setTitle('Delete me');
            $taskForDelete->setContent('Delete');
            $taskForDelete->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskForTestUp = new Task;
            $taskForTestUp->setTitle('Task up');
            $taskForTestUp->setContent('Task up');
            $taskForTestUp->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskCurrent1 = new Task;
            $taskCurrent1->setTitle('Im a current task');
            $taskCurrent1->setContent('Im a current task');
            $taskCurrent1->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskCurrent2 = new Task;
            $taskCurrent2->setTitle('Im a current task');
            $taskCurrent2->setContent('Im a current task');
            $taskCurrent2->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskCurrent3 = new Task;
            $taskCurrent3->setTitle('Im a current task');
            $taskCurrent3->setContent('Im a current task');
            $taskCurrent3->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskCurrent4 = new Task;
            $taskCurrent4->setTitle('Im a current task');
            $taskCurrent4->setContent('Im a current task');
            $taskCurrent4->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskCurrent5 = new Task;
            $taskCurrent5->setTitle('Im a current task');
            $taskCurrent5->setContent('Im a current task');
            $taskCurrent5->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskCurrent6 = new Task;
            $taskCurrent6->setTitle('Im a current task');
            $taskCurrent6->setContent('Im a current task');
            $taskCurrent6->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskCurrent7 = new Task;
            $taskCurrent7->setTitle('Im a current task');
            $taskCurrent7->setContent('Im a current task');
            $taskCurrent7->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskCurrent8 = new Task;
            $taskCurrent8->setTitle('Im a current task');
            $taskCurrent8->setContent('Im a current task');
            $taskCurrent8->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskCurrent9 = new Task;
            $taskCurrent9->setTitle('Im a current task');
            $taskCurrent9->setContent('Im a current task');
            $taskCurrent9->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskCurrent10 = new Task;
            $taskCurrent10->setTitle('Test ajax');
            $taskCurrent10->setContent('Im a current task');
            $taskCurrent10->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish1 = new Task;
            $taskFinish1->setTitle('Im a finish task');
            $taskFinish1->setContent('Im a finish task');
            $taskFinish1->toggle(true);
            $taskFinish1->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish2 = new Task;
            $taskFinish2->setTitle('Im a finish task');
            $taskFinish2->setContent('Im a finish task');
            $taskFinish2->toggle(true);
            $taskFinish2->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish3 = new Task;
            $taskFinish3->setTitle('Im a finish task');
            $taskFinish3->setContent('Im a finish task');
            $taskFinish3->toggle(true);
            $taskFinish3->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish4 = new Task;
            $taskFinish4->setTitle('Im a finish task');
            $taskFinish4->setContent('Im a finish task');
            $taskFinish4->toggle(true);
            $taskFinish4->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish5 = new Task;
            $taskFinish5->setTitle('Im a finish task');
            $taskFinish5->setContent('Im a finish task');
            $taskFinish5->toggle(true);
            $taskFinish5->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish6 = new Task;
            $taskFinish6->setTitle('Im a finish task');
            $taskFinish6->setContent('Im a finish task');
            $taskFinish6->toggle(true);
            $taskFinish6->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish7 = new Task;
            $taskFinish7->setTitle('Im a finish task');
            $taskFinish7->setContent('Im a finish task');
            $taskFinish7->toggle(true);
            $taskFinish7->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish8 = new Task;
            $taskFinish8->setTitle('Im a finish task');
            $taskFinish8->setContent('Im a finish task');
            $taskFinish8->toggle(true);
            $taskFinish8->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish9 = new Task;
            $taskFinish9->setTitle('Im a finish task');
            $taskFinish9->setContent('Im a finish task');
            $taskFinish9->toggle(true);
            $taskFinish9->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish10 = new Task;
            $taskFinish10->setTitle('Path edit task');
            $taskFinish10->setContent('Path edit task');
            $taskFinish10->toggle(true);
            $taskFinish10->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish11 = new Task;
            $taskFinish11->setTitle('Im a finish task');
            $taskFinish11->setContent('Im a finish task');
            $taskFinish11->toggle(true);
            $taskFinish11->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $taskFinish12 = new Task;
            $taskFinish12->setTitle('Test finish ajax');
            $taskFinish12->setContent('Im a finish task');
            $taskFinish12->toggle(true);
            $taskFinish12->setUser($this->getReference(UserFixtures::MAIN_USER_TEST_REFERENCE));

            $unknowTask1 = new Task;
            $unknowTask1->setTitle('Test unknow task ajax');
            $unknowTask1->setContent('Test unknow task');

            $unknowTask2 = new Task;
            $unknowTask2->setTitle('Delete me ajax');
            $unknowTask2->setContent('Test unknow task');

            $unknowTask3 = new Task;
            $unknowTask3->setTitle('Bad user role');
            $unknowTask3->setContent('Test unknow task');

            $unknowTask4 = new Task;
            $unknowTask4->setTitle('Test unknow task');
            $unknowTask4->setContent('Test unknow task');

            $unknowTask5 = new Task;
            $unknowTask5->setTitle('Test unknow task');
            $unknowTask5->setContent('Test unknow task');

            $unknowTask6 = new Task;
            $unknowTask6->setTitle('Test unknow task');
            $unknowTask6->setContent('Test unknow task');

            $unknowTask7 = new Task;
            $unknowTask7->setTitle('Test unknow task');
            $unknowTask7->setContent('Test unknow task');

            $unknowTask8 = new Task;
            $unknowTask8->setTitle('Test unknow task');
            $unknowTask8->setContent('Test unknow task');

            $unknowTask9 = new Task;
            $unknowTask9->setTitle('Test unknow task');
            $unknowTask9->setContent('Test unknow task');

            $unknowTask10 = new Task;
            $unknowTask10->setTitle('Test unknow task');
            $unknowTask10->setContent('Test unknow task');

            $unknowTask11 = new Task;
            $unknowTask11->setTitle('Test unknow task');
            $unknowTask11->setContent('Test unknow task');

            $manager->persist($taskForUpdate);
            $manager->persist($taskBadValues);
            $manager->persist($taskForToggle);
            $manager->persist($taskForDelete);
            $manager->persist($taskForTestUp);
            $manager->persist($taskCurrent1);
            $manager->persist($taskCurrent2);
            $manager->persist($taskCurrent3);
            $manager->persist($taskCurrent4);
            $manager->persist($taskCurrent5);
            $manager->persist($taskCurrent6);
            $manager->persist($taskCurrent7);
            $manager->persist($taskCurrent8);
            $manager->persist($taskCurrent9);
            $manager->persist($taskCurrent10);
            $manager->persist($taskFinish1);
            $manager->persist($taskFinish2);
            $manager->persist($taskFinish3);
            $manager->persist($taskFinish4);
            $manager->persist($taskFinish5);
            $manager->persist($taskFinish6);
            $manager->persist($taskFinish7);
            $manager->persist($taskFinish8);
            $manager->persist($taskFinish9);
            $manager->persist($taskFinish10);
            $manager->persist($taskFinish11);
            $manager->persist($taskFinish12);
            $manager->persist($unknowTask1);
            $manager->persist($unknowTask2);
            $manager->persist($unknowTask3);
            $manager->persist($unknowTask4);
            $manager->persist($unknowTask5);
            $manager->persist($unknowTask6);
            $manager->persist($unknowTask7);
            $manager->persist($unknowTask8);
            $manager->persist($unknowTask9);
            $manager->persist($unknowTask10);
            $manager->persist($unknowTask11);
        }

        if ($env == 'dev') {
            $taskCurrentList1 = new Task;
            $taskCurrentList1->setTitle('Lorem ipsum dolor sit amet');
            $taskCurrentList1->setContent('Duis sodales cursus ullamcorper. Morbi at nibh lorem.');
            $taskCurrentList1->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList2 = new Task;
            $taskCurrentList2->setTitle('Duis sodales');
            $taskCurrentList2->setContent('Aenean sit amet suscipit nunc');
            $taskCurrentList2->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList3 = new Task;
            $taskCurrentList3->setTitle('Morbi at nibh lorem');
            $taskCurrentList3->setContent('Suspendisse vulputate massa eget');
            $taskCurrentList3->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList4 = new Task;
            $taskCurrentList4->setTitle('Maecenas mollis luctus');
            $taskCurrentList4->setContent('Curabitur placerat arcu nec enim');
            $taskCurrentList4->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList5 = new Task;
            $taskCurrentList5->setTitle('Quisque porttitor');
            $taskCurrentList5->setContent('In molestie scelerisque mattis');
            $taskCurrentList5->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList6 = new Task;
            $taskCurrentList6->setTitle('Mauris feugiat');
            $taskCurrentList6->setContent('Morbi sed vehicula lorem');
            $taskCurrentList6->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList7 = new Task;
            $taskCurrentList7->setTitle('Praesent scelerisque');
            $taskCurrentList7->setContent('Morbi blandit dignissim lacinia');
            $taskCurrentList7->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList8 = new Task;
            $taskCurrentList8->setTitle('Cras lobortis dolor');
            $taskCurrentList8->setContent('Nullam semper, est quis');
            $taskCurrentList8->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList9 = new Task;
            $taskCurrentList9->setTitle('Nullam consequat');
            $taskCurrentList9->setContent('Aliquam ultricies aliquam');
            $taskCurrentList9->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList10 = new Task;
            $taskCurrentList10->setTitle('Sed non finibus');
            $taskCurrentList10->setContent('Praesent ipsum lectus');
            $taskCurrentList10->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList11 = new Task;
            $taskCurrentList11->setTitle('Aenean bibendum auctor');
            $taskCurrentList11->setContent('Aliquam molestie');
            $taskCurrentList11->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentList12 = new Task;
            $taskCurrentList12->setTitle('Nulla facilisi');
            $taskCurrentList12->setContent('Proin magna arcu');
            $taskCurrentList12->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList1 = new Task;
            $taskFinishList1->setTitle('Fusce pellentesque');
            $taskFinishList1->setContent('Mauris eu dictum erat');
            $taskFinishList1->toggle(true);
            $taskFinishList1->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList2 = new Task;
            $taskFinishList2->setTitle('Mauris euismod');
            $taskFinishList2->setContent('Vestibulum id enim euismod, vestibulum tortor');
            $taskFinishList2->toggle(true);
            $taskFinishList2->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList3 = new Task;
            $taskFinishList3->setTitle('Suspendisse consectetur');
            $taskFinishList3->setContent('Morbi malesuada facilisis faucibus');
            $taskFinishList3->toggle(true);
            $taskFinishList3->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList4 = new Task;
            $taskFinishList4->setTitle('Nullam odio ligula');
            $taskFinishList4->setContent('Curabitur venenatis aliquet pulvinar');
            $taskFinishList4->toggle(true);
            $taskFinishList4->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList5 = new Task;
            $taskFinishList5->setTitle('Nunc ac gravida');
            $taskFinishList5->setContent('Lorem ipsum dolor sit amet');
            $taskFinishList5->toggle(true);
            $taskFinishList5->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList6 = new Task;
            $taskFinishList6->setTitle('Donec tempus');
            $taskFinishList6->setContent('Donec bibendum tincidunt odio');
            $taskFinishList6->toggle(true);
            $taskFinishList6->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList7 = new Task;
            $taskFinishList7->setTitle('Phasellus consectetur');
            $taskFinishList7->setContent('Phasellus eros lectus');
            $taskFinishList7->toggle(true);
            $taskFinishList7->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList8 = new Task;
            $taskFinishList8->setTitle('Aenean consequat');
            $taskFinishList8->setContent('Suspendisse id sapien in odio mollis consequat');
            $taskFinishList8->toggle(true);
            $taskFinishList8->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList9 = new Task;
            $taskFinishList9->setTitle('Sed dignissim');
            $taskFinishList9->setContent('Nulla vel malesuada');
            $taskFinishList9->toggle(true);
            $taskFinishList9->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList10 = new Task;
            $taskFinishList10->setTitle('Need update');
            $taskFinishList10->setContent('Nulla auctor, leo sit amet ullamcorper feugiat');
            $taskFinishList10->toggle(true);
            $taskFinishList10->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList11 = new Task;
            $taskFinishList11->setTitle('Sed at nibh');
            $taskFinishList11->setContent('Quisque id ante ac nisi vehicula aliquam');
            $taskFinishList11->toggle(true);
            $taskFinishList11->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishList12 = new Task;
            $taskFinishList12->setTitle('Vestibulum ante');
            $taskFinishList12->setContent('Proin elit nunc');
            $taskFinishList12->toggle(true);
            $taskFinishList12->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskUnknowList1 = new Task;
            $taskUnknowList1->setTitle('Vestibulum ante');
            $taskUnknowList1->setContent('Proin tristique interdum enim quis porta.');

            $taskUnknowList2 = new Task;
            $taskUnknowList2->setTitle('Nulla varius');
            $taskUnknowList2->setContent('Class aptent taciti sociosqu ad litora torquent');

            $taskUnknowList3 = new Task;
            $taskUnknowList3->setTitle('Maecenas pellentesque');
            $taskUnknowList3->setContent('Nulla vitae dolor ipsum');

            $taskUnknowList4 = new Task;
            $taskUnknowList4->setTitle('Nulla quis');
            $taskUnknowList4->setContent('Class aptent taciti sociosqu ad litora');

            $taskUnknowList5 = new Task;
            $taskUnknowList5->setTitle('Aliquam metus');
            $taskUnknowList5->setContent('Vestibulum nec venenatis massa');

            $taskUnknowList6 = new Task;
            $taskUnknowList6->setTitle('Sed quis luctus');
            $taskUnknowList6->setContent('Phasellus pulvinar dolor quis nulla');

            $taskUnknowList7 = new Task;
            $taskUnknowList7->setTitle('Cras ullamcorper');
            $taskUnknowList7->setContent('Etiam scelerisque fermentum erat');

            $taskUnknowList8 = new Task;
            $taskUnknowList8->setTitle('Quisque erat');
            $taskUnknowList8->setContent('Nam eget posuere nibh');

            $taskUnknowList9 = new Task;
            $taskUnknowList9->setTitle('Quisque dictum');
            $taskUnknowList9->setContent('Morbi imperdiet sagittis neque, nec volutpat');

            $taskUnknowList10 = new Task;
            $taskUnknowList10->setTitle('Aenean risus');
            $taskUnknowList10->setContent('Aenean congue tortor quis nisi fermentum');

            $taskUnknowList11 = new Task;
            $taskUnknowList11->setTitle('Pellentesque consectetur');
            $taskUnknowList11->setContent('In augue nulla, commodo eu tortor id, bibendum');

            $taskUnknowList12 = new Task;
            $taskUnknowList12->setTitle('Suspendisse nec');
            $taskUnknowList12->setContent('Cras eget eros vehicula');

            $taskCurrentApiList1 = new Task;
            $taskCurrentApiList1->setTitle('Aenean sit');
            $taskCurrentApiList1->setContent('Duis feugiat, mauris ut ultrices accumsan');
            $taskCurrentApiList1->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentApiList2 = new Task;
            $taskCurrentApiList2->setTitle('Praesent a sapien');
            $taskCurrentApiList2->setContent('Orci varius natoque penatibus et magnis dis parturient montes');
            $taskCurrentApiList2->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentApiList3 = new Task;
            $taskCurrentApiList3->setTitle('Donec imperdie');
            $taskCurrentApiList3->setContent('Donec imperdie');
            $taskCurrentApiList3->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentApiList4 = new Task;
            $taskCurrentApiList4->setTitle('Donec lacinia');
            $taskCurrentApiList4->setContent('Donec ac interdum dui');
            $taskCurrentApiList4->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentApiList5 = new Task;
            $taskCurrentApiList5->setTitle('Mauris eget');
            $taskCurrentApiList5->setContent('Donec ac dolor hendrerit');
            $taskCurrentApiList5->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentApiList6 = new Task;
            $taskCurrentApiList6->setTitle('Pellentesque tempot');
            $taskCurrentApiList6->setContent('Proin dapibus, libero vel pharetra imperdiet');
            $taskCurrentApiList6->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishApiList1 = new Task;
            $taskFinishApiList1->setTitle('Curabitur placerat');
            $taskFinishApiList1->setContent('Curabitur placerat');
            $taskFinishApiList1->toggle(true);
            $taskFinishApiList1->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishApiList2 = new Task;
            $taskFinishApiList2->setTitle('Maecenas pretium');
            $taskFinishApiList2->setContent('Sed feugiat aliquam diam sed congue');
            $taskFinishApiList2->toggle(true);
            $taskFinishApiList2->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishApiList3 = new Task;
            $taskFinishApiList3->setTitle('Morbi iaculis');
            $taskFinishApiList3->setContent('Vivamus varius nunc sit amet ullamcorper');
            $taskFinishApiList3->toggle(true);
            $taskFinishApiList3->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishApiList4 = new Task;
            $taskFinishApiList4->setTitle('Ut dictum');
            $taskFinishApiList4->setContent('Nullam consectetur fringilla sem vel commodo');
            $taskFinishApiList4->toggle(true);
            $taskFinishApiList4->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishApiList5 = new Task;
            $taskFinishApiList5->setTitle('Ut efficitur');
            $taskFinishApiList5->setContent('Morbi eleifend ex vel mattis semper');
            $taskFinishApiList5->toggle(true);
            $taskFinishApiList5->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskFinishApiList6 = new Task;
            $taskFinishApiList6->setTitle('Sed posuere');
            $taskFinishApiList6->setContent('Cras sodales euismod sapien');
            $taskFinishApiList6->toggle(true);
            $taskFinishApiList6->setUser($this->getReference(UserFixtures::MAIN_USER_DEMO_REFERENCE));

            $taskCurrentAdminList1 = new Task;
            $taskCurrentAdminList1->setTitle('Vivamus in viverra');
            $taskCurrentAdminList1->setContent('Donec at nisl libero');
            $taskCurrentAdminList1->setUser($this->getReference(UserFixtures::SECONDARY_USER_DEMO_REFERENCE));

            $taskCurrentAdminList2 = new Task;
            $taskCurrentAdminList2->setTitle('Aenean quis');
            $taskCurrentAdminList2->setContent('Sed mattis ipsum finibus purus');
            $taskCurrentAdminList2->setUser($this->getReference(UserFixtures::SECONDARY_USER_DEMO_REFERENCE));

            $taskCurrentAdminList3 = new Task;
            $taskCurrentAdminList3->setTitle('Aenean faucibus');
            $taskCurrentAdminList3->setContent('Cras neque sem, tempor id dolor');
            $taskCurrentAdminList3->setUser($this->getReference(UserFixtures::SECONDARY_USER_DEMO_REFERENCE));

            $taskCurrentAdminList4 = new Task;
            $taskCurrentAdminList4->setTitle('Praesent tincidunt');
            $taskCurrentAdminList4->setContent('Sed ut justo varius, commodo');
            $taskCurrentAdminList4->setUser($this->getReference(UserFixtures::SECONDARY_USER_DEMO_REFERENCE));

            $taskCurrentAdminList5 = new Task;
            $taskCurrentAdminList5->setTitle('Curabitur massa');
            $taskCurrentAdminList5->setContent('Aliquam erat volutpat');
            $taskCurrentAdminList5->setUser($this->getReference(UserFixtures::SECONDARY_USER_DEMO_REFERENCE));

            $taskCurrentAdminList6 = new Task;
            $taskCurrentAdminList6->setTitle('Maecenas pretium');
            $taskCurrentAdminList6->setContent('Suspendisse scelerisque');
            $taskCurrentAdminList6->setUser($this->getReference(UserFixtures::SECONDARY_USER_DEMO_REFERENCE));

            $manager->persist($taskCurrentList1);
            $manager->persist($taskCurrentList2);
            $manager->persist($taskCurrentList3);
            $manager->persist($taskCurrentList4);
            $manager->persist($taskCurrentList5);
            $manager->persist($taskCurrentList6);
            $manager->persist($taskCurrentList7);
            $manager->persist($taskCurrentList8);
            $manager->persist($taskCurrentList9);
            $manager->persist($taskCurrentList10);
            $manager->persist($taskCurrentList11);
            $manager->persist($taskCurrentList12);

            $manager->persist($taskFinishList1);
            $manager->persist($taskFinishList2);
            $manager->persist($taskFinishList3);
            $manager->persist($taskFinishList4);
            $manager->persist($taskFinishList5);
            $manager->persist($taskFinishList6);
            $manager->persist($taskFinishList7);
            $manager->persist($taskFinishList8);
            $manager->persist($taskFinishList9);
            $manager->persist($taskFinishList10);
            $manager->persist($taskFinishList11);
            $manager->persist($taskFinishList12);


            $manager->persist($taskUnknowList1);
            $manager->persist($taskUnknowList2);
            $manager->persist($taskUnknowList3);
            $manager->persist($taskUnknowList4);
            $manager->persist($taskUnknowList5);
            $manager->persist($taskUnknowList6);
            $manager->persist($taskUnknowList7);
            $manager->persist($taskUnknowList8);
            $manager->persist($taskUnknowList9);
            $manager->persist($taskUnknowList10);
            $manager->persist($taskUnknowList11);
            $manager->persist($taskUnknowList12);

            $manager->persist($taskCurrentApiList1);
            $manager->persist($taskCurrentApiList2);
            $manager->persist($taskCurrentApiList3);
            $manager->persist($taskCurrentApiList4);
            $manager->persist($taskCurrentApiList5);
            $manager->persist($taskCurrentApiList6);

            $manager->persist($taskFinishApiList1);
            $manager->persist($taskFinishApiList2);
            $manager->persist($taskFinishApiList3);
            $manager->persist($taskFinishApiList4);
            $manager->persist($taskFinishApiList5);
            $manager->persist($taskFinishApiList6);

            $manager->persist($taskCurrentAdminList1);
            $manager->persist($taskCurrentAdminList2);
            $manager->persist($taskCurrentAdminList3);
            $manager->persist($taskCurrentAdminList4);
            $manager->persist($taskCurrentAdminList5);
            $manager->persist($taskCurrentAdminList6);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return array(
            UserFixtures::class,
        );
    }

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null): void
    {
        $this->container = $container;
    }
}