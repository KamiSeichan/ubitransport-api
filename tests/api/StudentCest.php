<?php

declare(strict_types=1);


namespace App\Tests\api;

use App\DataFixtures\GradeFixtures;
use App\Entity\Grade;
use App\Entity\Student;
use Symfony\Component\HttpFoundation\Response;

class StudentCest
{
    public function testListStudent(\ApiTester $I)
    {
        $I->wantTo('Check this list of student');
        $I->sendGET('/students');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->assertCount(2, json_decode($I->grabResponse()));
    }

    public function testCreateSuccess(\ApiTester $I)
    {
        $I->wantToTest("The creation of a student and it success");
        $I->sendPost(
            '/students',
            [
                'lastname' => 'apitest lastname',
                'firstname' => 'testfirstname',
                'birthday' => '1981-10-15',
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_CREATED);

        $I->seeResponseContainsJson([
            'lastname' => 'apitest lastname',
        ]);

        $I->canSeeInRepository(Student::class, ['lastname' => 'apitest lastname']);
    }

    public function testCreateFail(\ApiTester $I)
    {
        $I->wantToTest("The creation of and student and if fail");

        //if last name is empty
        $I->sendPost(
            '/students',
            [
                'lastname' => '',
                'firstname' => 'apitest firstname',
                'birthday' => '1981-10-15',
            ]
        );


        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);

        //if last name is empty
        $I->sendPost(
            '/students',
            [
                'lastname' => 'apitest lastname',
                'firstname' => '',
                'birthday' => '1981-10-15',
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);

        //if last name is too short
        $I->sendPost(
            '/students',
            [
                'lastname' => 'a',
                'firstname' => 'apitest firstname',
                'birthday' => '1981-10-15',
            ]
        );


        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);

        //if  firstname is too short
        $I->sendPost(
            '/students',
            [
                'lastname' => 'api lastname',
                'firstname' => 'z',
                'birthday' => '1981-10-15',
            ]
        );


        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function updateStudentSuccess(\ApiTester $I)
    {
        $I->wantToTest("update a student and it success");
        $I->sendPut(
            'students/1',
            [
                'lastname' => 'apitest lastname',
                'firstname' => 'testfirstname',
                'birthday' => '1981-10-15',
            ]
        );

        $I->seeResponseCodeIs(Response::HTTP_NO_CONTENT);

        $I->canSeeInRepository(Student::class, ['lastname' => 'apitest lastname']);
    }

    public function updateStudentFail(\ApiTester $I)
    {
        $I->wantToTest("update a student and it fail");

        //if last name is empty
        $I->sendPut(
            '/students/1',
            [
                'lastname' => '',
                'firstname' => 'apitest firstname',
                'birthday' => '1981-10-15',
            ]
        );


        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);

        //if last name is empty
        $I->sendPut(
            '/students/1',
            [
                'lastname' => 'apitest lastname',
                'firstname' => '',
                'birthday' => '1981-10-15',
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);

        //if last name is too short
        $I->sendPut(
            '/students/1',
            [
                'lastname' => 'a',
                'firstname' => 'apitest firstname',
                'birthday' => '1981-10-15',
            ]
        );


        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);

        //if  firstname is too short
        $I->sendPut(
            '/students/1',
            [
                'lastname' => 'api lastname',
                'firstname' => 'z',
                'birthday' => '1981-10-15',
            ]
        );


        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function removeStudent(\ApiTester $I)
    {
        $I->wantToTest("remove a student from database");
        $I->sendDelete('/students/1');
        $I->seeResponseCodeIs(Response::HTTP_NO_CONTENT);
    }

    public function addGradeStudent(\ApiTester $I)
    {
        $I->wantTo("add a grade to a student");

        $I->sendPOST('/students/1/grade', [
            'subject' => 'mathapitest',
            'value' => '14',
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_CREATED);

        $I->seeResponseContainsJson([
            'subject' => 'mathapitest',
        ]);

        $I->canSeeInRepository(Grade::class, ['subject' => 'mathapitest', 'value' => '14']);
    }

    public function checkStudentAverage(\ApiTester $I)
    {
        $I->wantTo("check student average with datafixture");

        $average = (GradeFixtures::GRADE_1 + GradeFixtures::GRADE_2) / 2;

        $I->sendGET('/students/1/average');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->assertEquals($average, floatval($I->grabResponse()));
    }
}
