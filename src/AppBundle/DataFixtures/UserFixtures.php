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
     * @var public
     */
    const SECONDARY_USER_TEST_REFERENCE = 'secondary-user-test-reference';

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
        $mainUser->setRole('ROLE_USER');

        $secondaryUser = new User;
        $secondaryUser->setUsername('JeanTest');
        $secondaryUser->setPassword('goodpass');
        $secondaryUser->setEmail('goodemail@gmail.com');
        $secondaryUser->setRole('ROLE_USER');

        $adminUser = new User;
        $adminUser->setUsername('SuperAdmin');
        $adminUser->setPassword('adminpass');
        $adminUser->setEmail('superadmin@gmail.com');
        $adminUser->setRole('ROLE_ADMIN');

        $userForUpdate = new User;
        $userForUpdate->setUsername('updateUsername');
        $userForUpdate->setPassword('updatePass');
        $userForUpdate->setEmail('updateMail@gmail.com');
        $userForUpdate->setRole('ROLE_USER');

        $manager->persist($mainUser);
        $manager->persist($secondaryUser);
        $manager->persist($adminUser);
        $manager->persist($userForUpdate);
        $manager->flush();

        $this->addReference(self::MAIN_USER_TEST_REFERENCE, $mainUser);
        $this->addReference(self::SECONDARY_USER_TEST_REFERENCE, $secondaryUser);
    }
}