<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Account;
use App\Services\ContactSources\AccountSourceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountSourceServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_contact_data_from_account()
    {
        $account = Account::factory()->create([
            'company_name' => 'Acme LLC',
            'representative_name' => 'Alice Smith',
            'email' => 'alice@acme.test',
            'phone' => '8888888888',
        ]);

        $service = new AccountSourceService($account);
        $data = $service->getContactData();

        $this->assertIsArray($data);
        $this->assertEquals('Alice Smith', $data['name']);
        $this->assertEquals('alice@acme.test', $data['email']);
        $this->assertEquals('8888888888', $data['phone']);
        $this->assertEquals('account', $data['source_type']);
        $this->assertEquals($account->id, $data['source_id']);
    }
}
