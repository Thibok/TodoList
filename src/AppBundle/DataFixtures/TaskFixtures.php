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

/**
 * TaskFixtures
 */
class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Load fixtures
     * @access public
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
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
}