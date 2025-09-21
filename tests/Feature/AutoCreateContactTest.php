<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Lead;
use App\Models\Account;
use App\Models\Contact;

class AutoCreateContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_lead_auto_creates_a_contact()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '9876543210'
        ];

        $response = $this->postJson('/api/leads', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'phone',
                'contact' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'source_type',
                    'source_id'
                ]
            ]);

        $this->assertDatabaseHas('leads', ['email' => 'john@example.com']);
        $this->assertDatabaseHas('contacts', ['email' => 'john@example.com', 'source_type' => Lead::class]);
    }

    /** @test */
    public function creating_an_account_auto_creates_a_contact()
    {
        $payload = [
            'company_name' => 'ACME Ltd',
            'representative_name' => 'Alice Smith',
            'email' => 'alice@company.com',
            'phone' => '1234567890'
        ];

        $response = $this->postJson('/api/accounts', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'company_name',
                'representative_name',
                'email',
                'phone',
                'contact' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'source_type',
                    'source_id'
                ]
            ]);

        $this->assertDatabaseHas('accounts', ['email' => 'alice@company.com']);
        $this->assertDatabaseHas('contacts', ['email' => 'alice@company.com', 'source_type' => Account::class]);
    }
}
