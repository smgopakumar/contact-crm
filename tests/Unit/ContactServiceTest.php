<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Lead;
use App\Models\Contact;
use App\Services\ContactService;
use App\Services\ContactSources\LeadSourceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_contact_from_lead()
    {
        $lead = Lead::factory()->create([
            'name' => 'Bob Builder',
            'email' => 'bob@builder.test',
        ]);

        $service = new ContactService();

        $contact = $service->createContact(new LeadSourceService($lead));

        // assert returned model exists in DB
        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertDatabaseHas('contacts', [
            'name' => 'Bob Builder',
            'email' => 'bob@builder.test',
            'source_type' => 'lead',
            'source_id' => $lead->id,
        ]);
    }
}
