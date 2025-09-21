<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Events\AccountCreated;

class AccountController extends Controller
{
    public function store(Request $request)
    {
        // Step 1: Validate request input
        $validated = $request->validate([
            'company_name'        => 'required|string|max:255',
            'representative_name' => 'required|string|max:255',
            'email'               => 'required|email|unique:accounts',
            'phone'               => 'nullable|string|max:20',
        ]);

        try {
            // Step 2: Run inside transaction for atomicity
            $account = DB::transaction(function () use ($validated) {
                // Create account
                $account = Account::create($validated);

                // Fire event (listener will create contact)
                event(new AccountCreated($account));

                return $account;
            });

            // Step 3: Eager load related contact
            $account->load('contact');

            // Step 4: Return success response
            return response()->json($account, 201);
        } catch (\Throwable $e) {
            // Log error details for debugging
            Log::error('Failed to create account', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data'  => $validated,
            ]);

            // Return safe error message to client
            return response()->json([
                'message' => 'Failed to create account. Please try again later.',
            ], 500);
        }
    }
}
