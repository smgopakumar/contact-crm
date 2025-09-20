<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Lead;
use App\Services\ContactSources\LeadSourceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadSourceServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_contact_data_from_lead()
    {
        $lead = Lead::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.test',
            'phone' => '9999999999',
        ]);

        $service = new LeadSourceService($lead);
        $data = $service->getContactData();

        $this->assertIsArray($data);
        $this->assertEquals('John Doe', $data['name']);
        $this->assertEquals('john@example.test', $data['email']);
        $this->assertEquals('9999999999', $data['phone']);
        $this->assertEquals('lead', $data['source_type']);
        $this->assertEquals($lead->id, $data['source_id']);
    }
}
