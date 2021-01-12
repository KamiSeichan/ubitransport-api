<?php

declare(strict_types=1);


namespace App\Tests\api;


use Symfony\Component\HttpFoundation\Response;

class StudentCest
{
    public function _before(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    public function _after(\ApiTester $I)
    {
    }

    public function testListStudent(\ApiTester $I) {

        $I->wantTo('Check this list of student');
        $I->sendGET('/students');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->assertCount(2, json_decode($I->grabResponse()));

    }
}