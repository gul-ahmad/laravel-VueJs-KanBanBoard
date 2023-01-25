<?php

namespace Tests\Feature;

use App\Models\Card;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CardControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * It displays all the cards.
     *
     * @return void
     */
    public function testitShowsAllCards()
    {
        $response = $this->get('/api/cards');

        $response->assertStatus(200);
    }


    public function testItFiltersCardsByDate()
    {
        Card::factory(3)->create();

        $created_at = '2023-01-25';

        $response = $this->get('/api/list-cards?date=' . $created_at);
     

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
    }
    public function testItFiltersCardsByStatus()
    {
        Card::factory(3)->create();

        Card::factory(2)->create(['status' => Card::STATUS_DELETED]);

        $response = $this->get('/api/list-cards?status=0');
       

        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }
}
