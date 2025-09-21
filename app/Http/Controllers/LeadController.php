<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Events\LeadCreated;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        // Step 1: Validate incoming request
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:leads',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            // Step 2: Use DB transaction to ensure atomic operation
            $lead = DB::transaction(function () use ($validated) {
                // Create lead record
                $lead = Lead::create($validated);

                // Fire event (this triggers listener to create contact)
                event(new LeadCreated($lead));

                return $lead;
            });

            // Step 3: Eager load the related contact before returning
            $lead->load('contact');

            // Step 4: Return JSON response with 201 Created status
            return response()->json($lead, 201);
        } catch (\Throwable $e) {
            // Log error for debugging
            Log::error('Failed to create lead', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data'  => $validated,
            ]);

            // Return error response to client
            return response()->json([
                'message' => 'Failed to create lead. Please try again later.',
            ], 500);
        }
    }
}
