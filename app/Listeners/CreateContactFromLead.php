<?php

namespace App\Listeners;

use App\Events\LeadCreated;
use App\Services\ContactSources\LeadSourceService;
use App\Services\ContactService;

class CreateContactFromLead
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function handle(LeadCreated $event)
    {
        $lead = $event->lead;
        $source = new LeadSourceService($lead);

        $this->contactService->createContact($source);
    }
}
