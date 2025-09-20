<?php

namespace App\Services\ContactSources;

/**
 * Interface ContactSourceInterface
 *
 * Defines the contract for different contact sources
 * (Lead, Account, Campaign, etc.).
 */
interface ContactSourceInterface
{
    /**
     * Returns an array of contact data.
     *
     * @return array
     */
    public function getContactData(): array;
}
