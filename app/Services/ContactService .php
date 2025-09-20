<?php

namespace App\Services;

use App\Models\Contact;
use App\Services\ContactSources\ContactSourceInterface;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * ContactService
 *
 * Handles contact creation logic using a flexible
 * Strategy Pattern approach.
 */
class ContactService
{
    /**
     * Creates a new Contact based on the given source.
     *
     * @param ContactSourceInterface $source
     * @return Contact
     * @throws Exception
     */
    public function createContact(ContactSourceInterface $source): Contact
    {
        try {
            $data = $source->getContactData();

            Log::info('Creating contact with data', $data);

            return Contact::create($data);
        } catch (Exception $e) {
            Log::error('Failed to create contact', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e; // rethrow so controller can handle
        }
    }
}
