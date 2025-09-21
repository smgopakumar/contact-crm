<?php

namespace App\Listeners;

use App\Events\AccountCreated;
use App\Services\ContactSources\AccountSourceService;
use App\Services\ContactService;

class CreateContactFromAccount
{
    protected $contactService;

    // Constructor injection: Laravel's service container resolves this automatically
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function handle(AccountCreated $event)
    {
        $account = $event->account;

        // Prepare source object for mapping
        $source = new AccountSourceService($account);

        // Delegate to service
        $this->contactService->createContact($source);
    }
}
