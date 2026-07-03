<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TamuControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_index_page_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tamu.index'));

        $response->assertStatus(200)
            ->assertSee('Data Tamu');
    }
}
