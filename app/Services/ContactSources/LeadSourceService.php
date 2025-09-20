<?php

namespace App\Services\ContactSources;

use App\Models\Lead;

/**
 * LeadSourceService implements ContactSourceInterface
 * to transform Lead data into a standard contact format.
 */
class LeadSourceService implements ContactSourceInterface
{
    private Lead $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function getContactData(): array
    {
        return [
            'name'        => $this->lead->name,
            'email'       => $this->lead->email,
            'phone'       => $this->lead->phone,
            'source_type' => 'lead',
            'source_id'   => $this->lead->id,
        ];
    }
}
