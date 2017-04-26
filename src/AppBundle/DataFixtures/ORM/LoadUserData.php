<?php


// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\ProfessorRegistration;
use AppBundle\Entity\StudentRegistration;
use AppBundle\Entity\Course;
use AppBundle\Entity\CLSPClass;
use AppBundle\Entity\Language;

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
        $testAdmin      = $this->createUser($this->getTestAdminInfo());

        $manager->persist($testAdmin);

        $manager->flush();


    }

    private function createUser($userInfo) {
        $encoder = $this->container->get('security.password_encoder');
        $newUser = new User();
        $newUser->setUsername           ($userInfo['username']);
        $newUser->setName               ($userInfo['name']);
        $newUser->setPassword           ($encoder->encodePassword($newUser, $userInfo['password']));
        $newUser->setEmail              ($userInfo['email']);
        $newUser->setIsActive           ($userInfo['isActive']);
        $newUser->setDateCreated        ($userInfo['dateCreated']);
        $newUser->setDateDeleted        ($userInfo['dateDeleted']);
        $newUser->setDateStart          ($userInfo['dateStart']);
        $newUser->setDateEnd            ($userInfo['dateEnd']);
        $newUser->setTimezone           ($userInfo['timezone']);
        $newUser->setIsStudent          ($userInfo['isStudent']);
        $newUser->setIsProfessor        ($userInfo['isProfessor']);
        $newUser->setIsDesigner         ($userInfo['isDesigner']);
        $newUser->setIsAdministrator    ($userInfo['isAdministrator']);
        return $newUser;
    }

    private function getTestAdminInfo() {
        $testAdmin = array(
            "username"          => "admin",
            "name"              => "Admin",
            "password"          => "admin",
            "email"             => "test@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => 2147483647,
            "timezone"          => "America/New_York",
            "isStudent"         => false,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => true,
        );
        return $testAdmin;
    }
}