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
        $testProfessor1  = $this->createUser($this->getTestProfessor1Info());
        $testProfessor2  = $this->createUser($this->getTestProfessor2Info());
        $testProfessor3  = $this->createUser($this->getTestProfessor3Info());
        $testDesigner1   = $this->createUser($this->getTestDesigner1Info());
        $testDesigner2   = $this->createUser($this->getTestDesigner2Info());
        $testReg1        = $this->createRegistration($this->getReg1Info());
        $testReg2        = $this->createRegistration($this->getReg2Info());
        $testReg3        = $this->createRegistration($this->getReg3Info());
        $testReg4        = $this->createRegistration($this->getReg4Info());
        $testStudent1    = $this->createUser($this->getTestStudentInfo1());
        $testStudent2    = $this->createUser($this->getTestStudentInfo2());
        $testStudent3    = $this->createUser($this->getTestStudentInfo3());
        $testStudent4    = $this->createUser($this->getTestStudentInfo4());
        $testStudent5    = $this->createUser($this->getTestStudentInfo5());
        $testStudent6    = $this->createUser($this->getTestStudentInfo6());
        $testStudent7    = $this->createUser($this->getTestStudentInfo7());
        $testStudent8    = $this->createUser($this->getTestStudentInfo8());
        $testStudent9    = $this->createUser($this->getTestStudentInfo9());
        $testStudent10    = $this->createUser($this->getTestStudentInfo10());
        $testStudentReg1 = $this->createStudentRegistration($this->getStudentReg1Info());
        $testStudentReg2 = $this->createStudentRegistration($this->getStudentReg2Info());
        $testStudentReg3 = $this->createStudentRegistration($this->getStudentReg3Info());
        $testStudentReg4 = $this->createStudentRegistration($this->getStudentReg4Info());
        $testStudentReg5 = $this->createStudentRegistration($this->getStudentReg5Info());
        $testStudentReg6 = $this->createStudentRegistration($this->getStudentReg6Info());
        $testCourse1 = $this->createCourse($this->getCourse1Info());
        $testCourse2 = $this->createCourse($this->getCourse2Info());
        $testCourse3 = $this->createCourse($this->getCourse3Info());
        $testClass1 = $this->createCLSPClass($this->getClass1Info());
        $testClass2 = $this->createCLSPClass($this->getClass2Info());
        $testClass3 = $this->createCLSPClass($this->getClass3Info());
        $testClass4 = $this->createCLSPClass($this->getClass4Info());
        $testClass5 = $this->createCLSPClass($this->getClass5Info());
        $testClass6 = $this->createCLSPClass($this->getClass6Info());
        $testLanguage1 = $this->createLanguage($this->getLanguage1Info());
        $testLanguage2 = $this->createLanguage($this->getLanguage2Info());
        $testLanguage3 = $this->createLanguage($this->getLanguage3Info());
        $testLanguage4 = $this->createLanguage($this->getLanguage4Info());
        $testLanguage5 = $this->createLanguage($this->getLanguage5Info());

        // specifies the designer that made the course
        $testCourse1->setDesigner($testDesigner1);
        $testCourse2->setDesigner($testDesigner2);
        $testCourse3->setDesigner($testDesigner2);

        // specifies language for the course
        $testCourse1->setLanguage($testLanguage1);
        $testCourse2->setLanguage($testLanguage3);
        $testCourse3->setLanguage($testLanguage3);

        // specifies owner who made prof registration, and the course the registration is being given to
        $testReg1->setOwner($testDesigner1);
        $testReg1->setCourse($testCourse1);
        $testReg2->setOwner($testDesigner1);
        $testReg2->setCourse($testCourse1);
        $testReg3->setOwner($testDesigner2);
        $testReg3->setCourse($testCourse2);
        $testReg4->setOwner($testDesigner2);
        $testReg4->setCourse($testCourse3);

//        $testDesigner1->addProfRegistration($testReg1);
//        $testDesigner1->addProfRegistration($testReg2);
//        $testDesigner2->addProfRegistration($testReg3);
//        $testDesigner2->addProfRegistration($testReg4);

        // links professor registrations with the professor
        $testReg1->setProfessor($testProfessor1);
        $testReg2->setProfessor($testProfessor2);
        $testReg3->setProfessor($testProfessor3);
        $testReg4->setProfessor($testProfessor3);
        
        $testProfessor1->addProfRegistration($testReg1);
        

        // links the classes to the courses
        $testClass1->setCourse($testCourse1);
        $testClass2->setCourse($testCourse1);
        $testClass3->setCourse($testCourse1);
        $testClass4->setCourse($testCourse2);
        $testClass5->setCourse($testCourse2);
        $testClass6->setCourse($testCourse3);

        // links the student registration codes to classes
        $testStudentReg1->setRegisteredClass($testClass1);
        $testStudentReg2->setRegisteredClass($testClass2);
        $testStudentReg3->setRegisteredClass($testClass3);
        $testStudentReg4->setRegisteredClass($testClass4);
        $testStudentReg5->setRegisteredClass($testClass5);
        $testStudentReg6->setRegisteredClass($testClass6);
        $testClass1->setStudentRegistration($testStudentReg1);
        $testClass2->setStudentRegistration($testStudentReg2);
        $testClass3->setStudentRegistration($testStudentReg3);
        $testClass4->setStudentRegistration($testStudentReg4);
        $testClass5->setStudentRegistration($testStudentReg5);
        $testClass6->setStudentRegistration($testStudentReg6);
        $testClass1->setProfessorRegistration($testReg1);
        $testClass2->setProfessorRegistration($testReg1);
        $testClass3->setProfessorRegistration($testReg2);
        $testClass4->setProfessorRegistration($testReg3);
        $testClass5->setProfessorRegistration($testReg3);
        $testClass6->setProfessorRegistration($testReg4);

        // links the original designer who gave the professor a registration code to the student registration code
        $testStudentReg1->setDesigner($testDesigner1);
        $testStudentReg2->setDesigner($testDesigner1);
        $testStudentReg3->setDesigner($testDesigner1);
        $testStudentReg4->setDesigner($testDesigner2);
        $testStudentReg5->setDesigner($testDesigner2);
        $testStudentReg6->setDesigner($testDesigner2);

        // the professor registration that the student registration belongs to is linked
        $testStudentReg1->setProfessorRegistration($testReg1);
        $testStudentReg2->setProfessorRegistration($testReg1);
        $testStudentReg3->setProfessorRegistration($testReg2);
        $testStudentReg4->setProfessorRegistration($testReg3);
        $testStudentReg5->setProfessorRegistration($testReg3);
        $testStudentReg6->setProfessorRegistration($testReg4);

        // most likely not necessary?
//        $testDesigner1->addStudentRegistration($testStudentReg1);
//        $testDesigner1->addStudentRegistration($testStudentReg2);
//        $testDesigner1->addStudentRegistration($testStudentReg3);
//        $testDesigner2->addStudentRegistration($testStudentReg4);
//        $testDesigner2->addStudentRegistration($testStudentReg5);

        // links students that registered to their registration code
        $testStudent1->setRegisteredClass($testStudentReg1);
        $testStudent2->setRegisteredClass($testStudentReg1);
        $testStudent3->setRegisteredClass($testStudentReg1);
        $testStudent4->setRegisteredClass($testStudentReg2);
        $testStudent5->setRegisteredClass($testStudentReg2);
        $testStudent6->setRegisteredClass($testStudentReg3);
        $testStudent7->setRegisteredClass($testStudentReg3);
        $testStudent8->setRegisteredClass($testStudentReg4);
        $testStudent9->setRegisteredClass($testStudentReg5);
        $testStudent10->setRegisteredClass($testStudentReg6);

        $manager->persist($testAdmin);
        $manager->persist($testLanguage1);
        $manager->persist($testLanguage2);
        $manager->persist($testLanguage3);
        $manager->persist($testLanguage4);
        $manager->persist($testLanguage5);
        $manager->persist($testProfessor1);
        $manager->persist($testProfessor2);
        $manager->persist($testProfessor3);
        $manager->persist($testDesigner1);
        $manager->persist($testDesigner2);
        $manager->persist($testCourse1);
        $manager->persist($testCourse2);
        $manager->persist($testCourse3);
        $manager->persist($testClass1);
        $manager->persist($testClass2);
        $manager->persist($testClass3);
        $manager->persist($testClass4);
        $manager->persist($testClass5);
        $manager->persist($testClass6);
        $manager->persist($testReg1);
        $manager->persist($testReg2);
        $manager->persist($testReg3);
        $manager->persist($testReg4);
        $manager->persist($testStudentReg1);
        $manager->persist($testStudentReg2);
        $manager->persist($testStudentReg3);
        $manager->persist($testStudentReg4);
        $manager->persist($testStudentReg5);
        $manager->persist($testStudentReg6);
        $manager->persist($testStudent1);
        $manager->persist($testStudent2);
        $manager->persist($testStudent3);
        $manager->persist($testStudent4);
        $manager->persist($testStudent5);
        $manager->persist($testStudent6);
        $manager->persist($testStudent7);
        $manager->persist($testStudent8);
        $manager->persist($testStudent9);
        $manager->persist($testStudent10);

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

    private function createRegistration($registrationInfo) {
        $newRegistration = new ProfessorRegistration();
        $newRegistration->setDateCreated        ($registrationInfo['dateCreated']);
        $newRegistration->setDateDeleted        ($registrationInfo['dateDeleted']);
        $newRegistration->setDateStart          ($registrationInfo['dateStart']);
        $newRegistration->setDateEnd            ($registrationInfo['dateEnd']);
        $newRegistration->setSignupCode         ($registrationInfo['signupCode']);
        return $newRegistration;
    }

    private function createStudentRegistration($registrationInfo) {
        $newStudentRegistration = new StudentRegistration();
        $newStudentRegistration->setDateCreated        ($registrationInfo['dateCreated']);
        $newStudentRegistration->setDateDeleted        ($registrationInfo['dateDeleted']);
        $newStudentRegistration->setDateStart          ($registrationInfo['dateStart']);
        $newStudentRegistration->setDateEnd            ($registrationInfo['dateEnd']);
        $newStudentRegistration->setSignupCode         ($registrationInfo['signupCode']);
        $newStudentRegistration->setName               ($registrationInfo['name']);
        return $newStudentRegistration;
    }

    private function createCourse($registrationInfo) {
        $newCourse = new Course();
        $newCourse->setName        ($registrationInfo['name']);
        $newCourse->setDescription ($registrationInfo['description']);
        return $newCourse;
    }

    private function createCLSPClass($registrationInfo) {
        $newCLSPClass = new CLSPClass();
        $newCLSPClass->setName        ($registrationInfo['name']);
        return $newCLSPClass;
    }

    private function createLanguage($registrationInfo) {
        $newLanguage = new Language();
        $newLanguage->setName        ($registrationInfo['name']);
        $newLanguage->setLanguageCode($registrationInfo['language_code']);
        return $newLanguage;
    }

    private function getTestAdminInfo() {
        $testAdmin = array(
            "username"          => "testAdmin",
            "name"              => "Admin",
            "password"          => "p",
            "email"             => "testAdmin@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
            "isStudent"         => false,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => true,
        );
        return $testAdmin;
    }

    private function getTestDesigner1Info() {
        $testDesigner = array(
            "username"          => "testDesignerChinese",
            "name"              => "Chinese Designer",
            "password"          => "p",
            "email"             => "testDesignerChinese@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
            "isStudent"         => false,
            "isProfessor"       => false,
            "isDesigner"        => true,
            "isAdministrator"   => false,
        );
        return $testDesigner;
    }

    private function getTestDesigner2Info() {
        $testDesigner = array(
            "username"          => "testDesignerJapanese",
            "name"              => "Japanese Designer",
            "password"          => "p",
            "email"             => "testDesignerJapanese@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
            "isStudent"         => false,
            "isProfessor"       => false,
            "isDesigner"        => true,
            "isAdministrator"   => false,
        );
        return $testDesigner;
    }

    private function getTestProfessor1Info() {
        $testProfessor = array(
            "username"          => "testProfessor1C",
            "name"              => "Chinese Professor 1",
            "password"          => "p",
            "email"             => "testProfessor1C@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
            "isStudent"         => false,
            "isProfessor"       => true,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testProfessor;
    }

    private function getTestProfessor2Info() {
        $testProfessor = array(
            "username"          => "testProfessor2C",
            "name"              => "Chinese Professor 2",
            "password"          => "p",
            "email"             => "testProfessor2C@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
            "isStudent"         => false,
            "isProfessor"       => true,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testProfessor;
    }

    private function getTestProfessor3Info() {
        $testProfessor = array(
            "username"          => "testProfessor3J",
            "name"              => "Japanese Professor 1",
            "password"          => "p",
            "email"             => "testProfessor3J@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
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
            "name"              => "Student 1",
            "password"          => "p",
            "email"             => "testStudent1@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
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
            "name"              => "Student 2",
            "password"          => "p",
            "email"             => "testStudent2@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
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
            "name"              => "Student 3",
            "password"          => "p",
            "email"             => "testStudent3@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
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
            "name"              => "Student 4",
            "password"          => "p",
            "email"             => "testStudent4@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
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
            "name"              => "Student 5",
            "password"          => "p",
            "email"             => "testStudent5@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
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
            "name"              => "Student 6",
            "password"          => "p",
            "email"             => "testStudent6@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
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
            "name"              => "Student 7",
            "password"          => "p",
            "email"             => "testStudent7@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
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
            "name"              => "Student 8",
            "password"          => "p",
            "email"             => "testStudent8@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
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
            "name"              => "Student 9",
            "password"          => "p",
            "email"             => "testStudent9@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
            "isStudent"         => true,
            "isProfessor"       => false,
            "isDesigner"        => false,
            "isAdministrator"   => false,
        );
        return $testStudentInfo;
    }

    private function getTestStudentInfo10() {
        $testStudentInfo = array(
            "username"          => "testStudent10",
            "name"              => "Student 10",
            "password"          => "p",
            "email"             => "testStudent10@test.com",
            "isActive"          => true,
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "timezone"          => "America/New_York",
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
            "signupCode"        => "professorregistration1-58339",
        );
        return $regInfo;
    }

    private function getReg2Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "signupCode"        => "professorregistration2-928AB",
        );
        return $regInfo;
    }

    private function getReg3Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "signupCode"        => "professorregistration3-CA87D",
        );
        return $regInfo;
    }

    private function getReg4Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 365*24*60*60,
            "signupCode"        => "professorregistration4-38581",
        );
        return $regInfo;
    }

    private function getStudentReg1Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 100*24*60*60,
            "signupCode"        => "studentregistration1-XK783",
            "name"              => "CHIN 3002 A"
        );
        return $regInfo;
    }

    private function getStudentReg2Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 100*24*60*60,
            "signupCode"        => "studentregistration2-9UIO3",
            "name"              => "CHIN 3002 B"
        );
        return $regInfo;
    }

    private function getStudentReg3Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 100*24*60*60,
            "signupCode"        => "studentregistration3-AKFIU",
            "name"              => "CHIN 3002 C"
        );
        return $regInfo;
    }

    private function getStudentReg4Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 100*24*60*60,
            "signupCode"        => "studentregistration4-A143U",
            "name"              => "JAPN 3001 A"
        );
        return $regInfo;
    }

    private function getStudentReg5Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 100*24*60*60,
            "signupCode"        => "studentregistration5-93FSD",
            "name"              => "JAPN 3001 B"
        );
        return $regInfo;
    }

    private function getStudentReg6Info() {
        $regInfo = array(
            "dateCreated"       => time(),
            "dateDeleted"       => null,
            "dateStart"         => 0,
            "dateEnd"           => time() + 100*24*60*60,
            "signupCode"        => "studentregistration5-93FSD",
            "name"              => "JAPN 4361 A"
        );
        return $regInfo;
    }

    private function getCourse1Info() {
        $regInfo = array(
            "name"       => "CHIN 3002",
            "description"=> "Advanced Chinese Language, part 2"
        );
        return $regInfo;
    }

    private function getCourse2Info() {
        $regInfo = array(
            "name"       => "JAPN 3001",
            "description"=> "Advanced Japanese Language"
        );
        return $regInfo;
    }

    private function getCourse3Info() {
        $regInfo = array(
            "name"       => "JAPN 4361",
            "description"=> "Japanese Literature"
        );
        return $regInfo;
    }

    private function getClass1Info() {
        $regInfo = array(
            "name"       => "CHIN 3002 A"
        );
        return $regInfo;
    }

    private function getClass2Info() {
        $regInfo = array(
            "name"       => "CHIN 3002 B"
        );
        return $regInfo;
    }

    private function getClass3Info() {
        $regInfo = array(
            "name"       => "CHIN 3002 C"
        );
        return $regInfo;
    }

    private function getClass4Info() {
        $regInfo = array(
            "name"       => "JAPN 3001 A"
        );
        return $regInfo;
    }

    private function getClass5Info() {
        $regInfo = array(
            "name"       => "JAPN 3001 B"
        );
        return $regInfo;
    }

    private function getClass6Info() {
        $regInfo = array(
            "name"       => "JAPN 4361 A"
        );
        return $regInfo;
    }

    private function getLanguage1Info() {
        $regInfo = array(
            "name"       => "Chinese",
            "language_code" => "ZH"
        );
        return $regInfo;
    }

    private function getLanguage2Info() {
        $regInfo = array(
            "name"       => "Russian",
            "language_code" => "RU"
        );
        return $regInfo;
    }

    private function getLanguage3Info() {
        $regInfo = array(
            "name"       => "Japanese",
            "language_code" => "JA"
        );
        return $regInfo;
    }

    private function getLanguage4Info() {
        $regInfo = array(
            "name"       => "Arabic",
            "language_code" => "AR"
        );
        return $regInfo;
    }

    private function getLanguage5Info() {
        $regInfo = array(
            "name"       => "Korean",
            "language_code" => "KO"
        );
        return $regInfo;
    }

}