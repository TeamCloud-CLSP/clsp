<?php


// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Registration;

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
        $testProfessor  = $this->createUser($this->getTestProfessorInfo());
        $testDesigner   = $this->createUser($this->getTestDesignerInfo());
        $testReg1        = $this->createRegistration($this->getReg1Info());
        $testReg2        = $this->createRegistration($this->getReg2Info());
        $testReg3        = $this->createRegistration($this->getReg3Info());
        $testStudent1    = $this->createUser($this->getTestStudentInfo1());
        $testStudent2    = $this->createUser($this->getTestStudentInfo2());
        $testStudent3    = $this->createUser($this->getTestStudentInfo3());
        $testStudent4    = $this->createUser($this->getTestStudentInfo4());
        $testStudent5    = $this->createUser($this->getTestStudentInfo5());
        $testStudent6    = $this->createUser($this->getTestStudentInfo6());
        $testStudent7    = $this->createUser($this->getTestStudentInfo7());
        $testStudent8    = $this->createUser($this->getTestStudentInfo8());
        $testStudent9    = $this->createUser($this->getTestStudentInfo9());

        $testReg1->setOwner($testProfessor);
        $testReg2->setOwner($testProfessor);
        $testReg3->setOwner($testProfessor);
        $testStudent1->setRegistration($testReg1);
        $testStudent2->setRegistration($testReg1);
        $testStudent3->setRegistration($testReg1);
        $testStudent4->setRegistration($testReg2);
        $testStudent5->setRegistration($testReg2);
        $testStudent6->setRegistration($testReg2);
        $testStudent7->setRegistration($testReg3);
        $testStudent8->setRegistration($testReg3);
        $testStudent9->setRegistration($testReg3);


        $manager->persist($testAdmin);
        $manager->persist($testProfessor);
        $manager->persist($testDesigner);
        $manager->persist($testReg1);
        $manager->persist($testReg2);
        $manager->persist($testReg3);
        $manager->persist($testStudent1);
        $manager->persist($testStudent2);
        $manager->persist($testStudent3);
        $manager->persist($testStudent4);
        $manager->persist($testStudent5);
        $manager->persist($testStudent6);
        $manager->persist($testStudent7);
        $manager->persist($testStudent8);
        $manager->persist($testStudent9);

        $manager->flush();


    }

    private function createUser($userInfo) {
        $encoder = $this->container->get('security.password_encoder');
        $newUser = new User();
        $newUser->setUsername           ($userInfo['username']);
        $newUser->setPassword           ($encoder->encodePassword($newUser, $userInfo['password']));
        $newUser->setEmail              ($userInfo['email']);
        $newUser->setIsActive           ($userInfo['isActive']);
        $newUser->setDateCreated        ($userInfo['dateCreated']);
        $newUser->setDateDeleted        ($userInfo['dateDeleted']);
        $newUser->setDateStart          ($userInfo['dateStart']);
        $newUser->setDateEnd            ($userInfo['dateEnd']);
        $newUser->setIsStudent          ($userInfo['isStudent']);
        $newUser->setIsProfessor        ($userInfo['isProfessor']);
        $newUser->setIsDesigner         ($userInfo['isDesigner']);
        $newUser->setIsAdministrator    ($userInfo['isAdministrator']);
        return $newUser;
    }

    private function createRegistration($registrationInfo) {
        $newRegistration = new Registration();
        $newRegistration->setDateCreated        ($registrationInfo['dateCreated']);
        $newRegistration->setDateDeleted        ($registrationInfo['dateDeleted']);
        $newRegistration->setDateStart          ($registrationInfo['dateStart']);
        $newRegistration->setDateEnd            ($registrationInfo['dateEnd']);
        $newRegistration->setSignupCode         ($registrationInfo['signupCode']);
        return $newRegistration;
    }

    private function getTestAdminInfo() {
        $testAdmin = array(
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
        );
        return $testAdmin;
    }

    private function getTestDesignerInfo() {
        $testDesigner = array(
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
        );
        return $testDesigner;
    }

    private function getTestProfessorInfo() {
        $testProfessor = array(
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
        );
        return $testProfessor;
    }

    private function getTestStudentInfo1() {
        $testStudentInfo = array(
            "username"          => "testStudent1",
            "password"          => "testStudent1",
            "email"             => "testStudent1@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "isStudent"         => true,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testStudentInfo;
    }

    private function getTestStudentInfo2() {
        $testStudentInfo = array(
            "username"          => "testStudent2",
            "password"          => "testStudent2",
            "email"             => "testStudent2@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "isStudent"         => true,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testStudentInfo;
    }

    private function getTestStudentInfo3() {
        $testStudentInfo = array(
            "username"          => "testStudent3",
            "password"          => "testStudent3",
            "email"             => "testStudent3@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "isStudent"         => true,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testStudentInfo;
    }

    private function getTestStudentInfo4() {
        $testStudentInfo = array(
            "username"          => "testStudent4",
            "password"          => "testStudent4",
            "email"             => "testStudent4@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "isStudent"         => true,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testStudentInfo;
    }

    private function getTestStudentInfo5() {
        $testStudentInfo = array(
            "username"          => "testStudent5",
            "password"          => "testStudent5",
            "email"             => "testStudent5@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "isStudent"         => true,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testStudentInfo;
    }

    private function getTestStudentInfo6() {
        $testStudentInfo = array(
            "username"          => "testStudent6",
            "password"          => "testStudent6",
            "email"             => "testStudent6@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "isStudent"         => true,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testStudentInfo;
    }

    private function getTestStudentInfo7() {
        $testStudentInfo = array(
            "username"          => "testStudent7",
            "password"          => "testStudent7",
            "email"             => "testStudent7@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "isStudent"         => true,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testStudentInfo;
    }

    private function getTestStudentInfo8() {
        $testStudentInfo = array(
            "username"          => "testStudent8",
            "password"          => "testStudent8",
            "email"             => "testStudent8@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "isStudent"         => true,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testStudentInfo;
    }

    private function getTestStudentInfo9() {
        $testStudentInfo = array(
            "username"          => "testStudent9",
            "password"          => "testStudent9",
            "email"             => "testStudent9@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "isStudent"         => true,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testStudentInfo;
    }


    private function getReg1Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "signupCode"        => "1111116789abcdef",
        );
        return $regInfo;
    }

    private function getReg2Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "signupCode"        => "2222226789abcdef",
        );
        return $regInfo;
    }

    private function getReg3Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "signupCode"        => "3333336789abcdef",
        );
        return $regInfo;
    }
}