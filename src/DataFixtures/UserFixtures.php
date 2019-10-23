<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    public $container;
    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');

        /**
         * user@test.com / azerty / ROLE_USER / status 1
         */
        $user = new User();
        $user->setEmail('user@test.com');
        $user->setStatus(1);

        $password = $encoder->encodePassword($user, 'azerty');
        $user->setPassword($password);



        $manager->persist($user);

        /**
         * admin@test.com / azerty / ROLE_ADMIN / status 1
         */
        $admin = new User();
        $admin->setEmail('admin@test.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setStatus(1);

        $password = $encoder->encodePassword($admin, 'azerty');
        $admin->setPassword($password);

        $manager->persist($admin);

        $manager->flush();
    }
}
