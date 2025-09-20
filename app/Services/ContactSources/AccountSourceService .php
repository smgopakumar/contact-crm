<?php

namespace App\Services\ContactSources;

use App\Models\Account;

/**
 * AccountSourceService implements ContactSourceInterface
 * to transform Account data into a standard contact format.
 */
class AccountSourceService implements ContactSourceInterface
{
    private Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function getContactData(): array
    {
        return [
            'name'        => $this->account->representative_name,
            'email'       => $this->account->email,
            'phone'       => $this->account->phone,
            'source_type' => 'account',
            'source_id'   => $this->account->id,
        ];
    }
}
