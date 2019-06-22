<?php

/**
 * Listener of User events
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserListener
{
    /**
     * @var UserPasswordEncoderInterface
     * @access private
     */
    private $encoder;

    /**
     * Constructor
     * @access public
     * @param UserPasswordEncoderInterface $encoder
     * 
     * @return void
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Pre persist event
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $user = $args->getObject();

        if (!$user instanceof User) {
            return;
        }

        $encoded = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
    }

    /**
     * Pre update event
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $user = $args->getObject();

        if (!$user instanceof User) {
            return;
        }

        $encoded = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
    }
}