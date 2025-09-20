<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Account;
use App\Services\ContactService;
use App\Services\ContactSources\LeadSourceService;
use App\Services\ContactSources\AccountSourceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * ContactController
 *
 * API endpoints for creating contacts from different sources.
 */
class ContactController extends Controller
{
    protected ContactService $service;

    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    /**
     * Create a contact from a lead.
     *
     * @param int $leadId
     * @return JsonResponse
     */
    public function createFromLead(int $leadId): JsonResponse
    {
        try {
            $lead = Lead::findOrFail($leadId);
            $source = new LeadSourceService($lead);

            $contact = $this->service->createContact($source);

            return response()->json([
                'success' => true,
                'data'    => $contact,
            ], 201);
        } catch (Exception $e) {
            Log::error('Error creating contact from lead', [
                'lead_id' => $leadId,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create contact from lead',
            ], 500);
        }
    }

    /**
     * Create a contact from an account.
     *
     * @param int $accountId
     * @return JsonResponse
     */
    public function createFromAccount(int $accountId): JsonResponse
    {
        try {
            $account = Account::findOrFail($accountId);
            $source = new AccountSourceService($account);

            $contact = $this->service->createContact($source);

            return response()->json([
                'success' => true,
                'data'    => $contact,
            ], 201);
        } catch (Exception $e) {
            Log::error('Error creating contact from account', [
                'account_id' => $accountId,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create contact from account',
            ], 500);
        }
    }
}
