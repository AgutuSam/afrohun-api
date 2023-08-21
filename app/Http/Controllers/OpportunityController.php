<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpportunityController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opportunities = Opportunity::all();
        return $opportunities;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'link' => 'required',
            'deadline' => 'required',
            'organisation' => 'required',
        ]);

        if (!Auth::check()) {
            return $this->unauthenticatedResponse();
        }

        $opp = new Opportunity();
        $opp->title = $request->title;
        $opp->link = $request->link;
        $opp->description = $request->description;
        $opp->deadline = $request->deadline;
        $opp->organisation = $request->organisation;
        $opp->user_id = Auth::id();

        // Optional fields
        if ($request->has('organisation_image')) {
            $filename=$request->file('organisation_image')->store('opportunities','public');
            $opp->organisation_image = $filename;
        }
        if ($request->has('type')) {
            $opp->type = $request->type;
        }

        $opp->save();

        return $this->successResponse('Opportunity created successfully', $opp);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Auth::check()) {
            return $this->unauthenticatedResponse();
        }

        $opportunity = Opportunity::find($id);

        if (!$opportunity) {
            return $this->notFoundResponse('Opportunity not found');
        }

        return $opportunity;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::check()) {
            return $this->unauthenticatedResponse();
        }

        $opp = Opportunity::find($id);

        if (!$opp) {
            return $this->notFoundResponse('Opportunity not found');
        }

        // Only update fields that are present in the request
        $opp->fill($request->only(['title', 'description', 'deadline', 'organisation', 'organisation_image', 'type', 'verified']));

        $opp->save();

        return $this->successResponse('Opportunity updated successfully', $opp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::check()) {
            return $this->unauthenticatedResponse();
        }

        $opp = Opportunity::find($id);

        if (!$opp) {
            return $this->notFoundResponse('Opportunity not found');
        }

        $opp->delete();

        return $this->successResponse('Opportunity deleted successfully');
    }

    // Custom response methods
    private function unauthenticatedResponse()
    {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    private function notFoundResponse($message)
    {
        return response()->json(['message' => $message], 404);
    }

    private function successResponse($message, $data = null)
    {
        $response = ['message' => $message];
        if ($data) {
            $response['data'] = $data;
        }
        return response()->json($response);
    }
}
