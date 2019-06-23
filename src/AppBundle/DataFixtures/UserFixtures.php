<?php
declare(strict_types=1);

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

        $userList1 = new User;
        $userList1->setUsername('userList1');
        $userList1->setPassword('userListPass1');
        $userList1->setEmail('userList1@gmail.com');
        $userList1->setRole('ROLE_USER');

        $userList2 = new User;
        $userList2->setUsername('userList2');
        $userList2->setPassword('userListPass2');
        $userList2->setEmail('userList2@gmail.com');
        $userList2->setRole('ROLE_USER');

        $userList3 = new User;
        $userList3->setUsername('userList3');
        $userList3->setPassword('userListPass3');
        $userList3->setEmail('userList3@gmail.com');
        $userList3->setRole('ROLE_USER');

        $userList4 = new User;
        $userList4->setUsername('userList4');
        $userList4->setPassword('userListPass4');
        $userList4->setEmail('userList4@gmail.com');
        $userList4->setRole('ROLE_USER');

        $userList5 = new User;
        $userList5->setUsername('userList5');
        $userList5->setPassword('userListPass5');
        $userList5->setEmail('userList5@gmail.com');
        $userList5->setRole('ROLE_USER');

        $userList6 = new User;
        $userList6->setUsername('userList6');
        $userList6->setPassword('userListPass6');
        $userList6->setEmail('userList6@gmail.com');
        $userList6->setRole('ROLE_USER');

        $manager->persist($mainUser);
        $manager->persist($secondaryUser);
        $manager->persist($adminUser);
        $manager->persist($userForUpdate);
        $manager->persist($userList1);
        $manager->persist($userList2);
        $manager->persist($userList3);
        $manager->persist($userList4);
        $manager->persist($userList5);
        $manager->persist($userList6);

        $manager->flush();

        $this->addReference(self::MAIN_USER_TEST_REFERENCE, $mainUser);
        $this->addReference(self::SECONDARY_USER_TEST_REFERENCE, $secondaryUser);
    }
}