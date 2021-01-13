<?php

declare(strict_types=1);


namespace App\Tests\api;

use App\DataFixtures\GradeFixtures;
use Symfony\Component\HttpFoundation\Response;

class GradeCest
{
    public function checkClassroomAverage(\ApiTester $I)
    {
        $I->wantTo('return the average of all grade of the classroom');
        $average = (GradeFixtures::GRADE_1 + GradeFixtures::GRADE_2 + GradeFixtures::GRADE_3 + GradeFixtures::GRADE_4) / 4;

        $I->sendGET('/grades/average');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->assertEquals($average, floatval($I->grabResponse()));
    }
}
