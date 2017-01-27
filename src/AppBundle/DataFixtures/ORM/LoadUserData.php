<?php


// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $testUsers = $this->getTestUsers();
        $encoder = $this->container->get('security.password_encoder');
        foreach($testUsers as $testUser) {
            $newUser = new User();
            $newUser->setUsername           ($testUser['username']);
            $newUser->setPassword           ($encoder->encodePassword($newUser, $testUser['password']));
            $newUser->setEmail              ($testUser['email']);
            $newUser->setIsActive           ($testUser['isActive']);
            $newUser->setDateCreated        ($testUser['dateCreated']);
            $newUser->setDateDeleted        ($testUser['dateDeleted']);
            $newUser->setDateStart          ($testUser['dateStart']);
            $newUser->setDateEnd            ($testUser['dateEnd']);
            $newUser->setIsStudent          ($testUser['isStudent']);
            $newUser->setIsProfessor        ($testUser['isProfessor']);
            $newUser->setIsDesigner         ($testUser['isDesigner']);
            $newUser->setIsAdministrator    ($testUser['isAdministrator']);

            $manager->persist($newUser);
            $manager->flush();
        }
    }

    public function getTestUsers() {
        $users = array(
            array(
                "username"          => "testAdmin",
                "password"          => "testAdmin",
                "email"             => "testAdmin@test.com",
                "isActive"          => true,
                "dateCreated"       => time(),
                "dateDeleted"       => null,
                "dateStart"         => 0,
                "dateEnd"           => time() + 365*24*60*60,
                "isStudent"         => false,
                "isProfessor"       => false,
                "isDesigner"        => false,
                "isAdministrator"   => true,
            ),

            array(
                "username"          => "testStudent",
                "password"          => "testStudent",
                "email"             => "testStudent@test.com",
                "isActive"          => true,
                "dateCreated"       => time(),
                "dateDeleted"       => null,
                "dateStart"         => 0,
                "dateEnd"           => time() + 365*24*60*60,
                "isStudent"         => true,
                "isProfessor"       => false,
                "isDesigner"        => false,
                "isAdministrator"   => false,
            ),

            array(
                "username"          => "testDesigner",
                "password"          => "testDesigner",
                "email"             => "testDesigner@test.com",
                "isActive"          => true,
                "dateCreated"       => time(),
                "dateDeleted"       => null,
                "dateStart"         => 0,
                "dateEnd"           => time() + 365*24*60*60,
                "isStudent"         => false,
                "isProfessor"       => false,
                "isDesigner"        => true,
                "isAdministrator"   => false,
            ),

            array(
                "username"          => "testProfessor",
                "password"          => "testProfessor",
                "email"             => "testProfessor@test.com",
                "isActive"          => true,
                "dateCreated"       => time(),
                "dateDeleted"       => null,
                "dateStart"         => 0,
                "dateEnd"           => time() + 365*24*60*60,
                "isStudent"         => false,
                "isProfessor"       => true,
                "isDesigner"        => false,
                "isAdministrator"   => false,
            ),
        );

        return $users;
    }

}