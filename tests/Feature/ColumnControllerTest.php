<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ColumnControllerTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function testitShowsAllColumnsWithCards()
    {
        $response = $this->get('/api/columns');

        //test the response we get while visiting this api
        // dd($response->json());

        $response->assertStatus(200);
        //Used 4 becuase in on runing migrations we inserted 4 records
        //This test may fail in future when more columns are added or removed
        //  $this->assertCount(4, $response->json('data'));
        $response->assertOk();
        $response->assertJsonCount(4,'data');

        $this->assertNotNull($response->json('data')[0]['id']);
    }
}
