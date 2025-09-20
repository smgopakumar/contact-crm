<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_contact_from_lead_via_api()
    {
        $lead = Lead::factory()->create();

        $response = $this->postJson("/api/contacts/lead/{$lead->id}");

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'source_type',
                    'source_id',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('contacts', [
            'name' => $lead->name,
            'email' => $lead->email,
            'source_type' => 'lead',
            'source_id' => $lead->id,
        ]);
    }
}
