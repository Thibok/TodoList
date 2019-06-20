<?php

/**
 * User Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * User Fixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @var public
     */
    const MAIN_USER_TEST_REFERENCE = 'main-user-test-reference';

    /**
     * Load fixtures
     * @access public
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $mainUser = new User;
        $mainUser->setUsername('BryanTest');
        $mainUser->setPassword('goodpassword');
        $mainUser->setEmail('goodemail@yahoo.com');

        $manager->persist($mainUser);
        $manager->flush();

        $this->addReference(self::MAIN_USER_TEST_REFERENCE, $mainUser);
    }
}