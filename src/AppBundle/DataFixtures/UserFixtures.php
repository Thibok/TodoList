<?php
declare(strict_types=1);

/**
 * User Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * User Fixtures
 */
class UserFixtures extends Fixture implements ContainerAwareInterface
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
     * @var public
     */
    const MAIN_USER_DEMO_REFERENCE = 'main-user-demo-reference';

    /**
     * @var public
     */
    const SECONDARY_USER_DEMO_REFERENCE = 'secondary-user-demo-reference';

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
        }

        if ($env == 'dev') {
            $mainUser = new User;
            $mainUser->setUsername('BryanUser');
            $mainUser->setPassword('BryanUser1');
            $mainUser->setEmail('bryanuser@yahoo.com');
            $mainUser->setRole('ROLE_USER');

            $adminUser = new User;
            $adminUser->setUsername('BryanAdmin');
            $adminUser->setPassword('BryanAdmin1');
            $adminUser->setEmail('bryanadmin@yahoo.com');
            $adminUser->setRole('ROLE_ADMIN');

            $userList1 = new User;
            $userList1->setUsername('PierreList');
            $userList1->setPassword('PierreList12');
            $userList1->setEmail('pierrelist@yahoo.com');
            $userList1->setRole('ROLE_USER');

            $userList2 = new User;
            $userList2->setUsername('BryanList');
            $userList2->setPassword('BryanList80');
            $userList2->setEmail('bryanlist@yahoo.com');
            $userList2->setRole('ROLE_ADMIN');

            $userList3 = new User;
            $userList3->setUsername('JeanList');
            $userList3->setPassword('JeanList98');
            $userList3->setEmail('jeanlist@gmail.com');
            $userList3->setRole('ROLE_USER');

            $userList4 = new User;
            $userList4->setUsername('SarahList');
            $userList4->setPassword('SarahList45');
            $userList4->setEmail('sarahlist@hotmail.com');
            $userList4->setRole('ROLE_ADMIN');

            $userList5 = new User;
            $userList5->setUsername('MathieuList');
            $userList5->setPassword('MathieuList58');
            $userList5->setEmail('mathieulist@yahoo.fr');
            $userList5->setRole('ROLE_USER');

            $userList6 = new User;
            $userList6->setUsername('AlexList');
            $userList6->setPassword('AlexList152');
            $userList6->setEmail('alexlist@yahoo.com');
            $userList6->setRole('ROLE_ADMIN');

            $userList7 = new User;
            $userList7->setUsername('GerardList');
            $userList7->setPassword('GerardList989');
            $userList7->setEmail('gerardlist@gmail.com');
            $userList7->setRole('ROLE_USER');

            $userList8 = new User;
            $userList8->setUsername('BernardList');
            $userList8->setPassword('BernardList458');
            $userList8->setEmail('bernardlist@gmail.com');
            $userList8->setRole('ROLE_ADMIN');

            $userApiList1 = new User;
            $userApiList1->setUsername('PatrickList');
            $userApiList1->setPassword('PatrickList456');
            $userApiList1->setEmail('patricklist@yahoo.com');
            $userApiList1->setRole('ROLE_USER');

            $userApiList2 = new User;
            $userApiList2->setUsername('ChristopheList');
            $userApiList2->setPassword('ChristopheList852');
            $userApiList2->setEmail('christophelist@yahoo.com');
            $userApiList2->setRole('ROLE_ADMIN');

            $userApiList3 = new User;
            $userApiList3->setUsername('MaximeList');
            $userApiList3->setPassword('MaximeList528');
            $userApiList3->setEmail('maximelist@hotmail.com');
            $userApiList3->setRole('ROLE_USER');

            $userApiList4 = new User;
            $userApiList4->setUsername('KarineList');
            $userApiList4->setPassword('KarineList125');
            $userApiList4->setEmail('karinelist@yahoo.com');
            $userApiList4->setRole('ROLE_USER');

            $userApiList5 = new User;
            $userApiList5->setUsername('DylanList');
            $userApiList5->setPassword('DylanList9856');
            $userApiList5->setEmail('dylanlist@gmail.com');
            $userApiList5->setRole('ROLE_USER');

            $userApiList6 = new User;
            $userApiList6->setUsername('JackList');
            $userApiList6->setPassword('JackList356');
            $userApiList6->setEmail('jacklist@yahoo.com');
            $userApiList6->setRole('ROLE_USER');

            $manager->persist($mainUser);
            $manager->persist($adminUser);
            $manager->persist($userList1);
            $manager->persist($userList2);
            $manager->persist($userList3);
            $manager->persist($userList4);
            $manager->persist($userList5);
            $manager->persist($userList6);
            $manager->persist($userList7);
            $manager->persist($userList8);
            $manager->persist($userApiList1);
            $manager->persist($userApiList2);
            $manager->persist($userApiList3);
            $manager->persist($userApiList4);
            $manager->persist($userApiList5);
            $manager->persist($userApiList6);
        }

        $manager->flush();

        if ($env == 'test') {
            $this->addReference(self::MAIN_USER_TEST_REFERENCE, $mainUser);
            $this->addReference(self::SECONDARY_USER_TEST_REFERENCE, $secondaryUser);
        }

        if ($env == 'dev') {
            $this->addReference(self::MAIN_USER_DEMO_REFERENCE, $mainUser);
            $this->addReference(self::SECONDARY_USER_DEMO_REFERENCE, $adminUser);
        }
    }

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null): void
    {
        $this->container = $container;
    }
}