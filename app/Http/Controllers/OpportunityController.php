<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Opportunity;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opp = Opportunity::all();
        return $opp;

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $mem_id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $mem=Member::find($mem_id);

        if(!$mem){
            return response()->json(['error' => 'Member not found'], 404);
        }else{

        $opp = new Opportunity();
        
        $opp->title = $request->title;
        // $opp->verified = $request->verified;
        $opp->description = $request->description;
        $opp->type = $request->type;
        $opp->start_date = $request->start_date;
        $opp->end_date = $request->end_date;
        
        $opp->save();

        return response()->json([
            'message' => 'Comment created successfully',
            'data' => $opp
        ]);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $mem_id, $id)
    {
        
        $mem=Member::find($mem_id);

        if(!$mem){
            return response()->json(['error' => 'Member not found'], 404);
        }else{
            return Opportunity::find($id);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $mem_id, $id)
    {
       
        $mem=Member::find($mem_id);

        if(!$mem){
            return response()->json(['error' => 'Member not found'], 404);
        }else{
        $opp= Opportunity::find($id);
        $opp->update($request->all());
        return $opp;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $mem_id, $id)
    {
        
        $mem=Member::find($mem_id);

        if(!$mem){
            return response()->json(['error' => 'Member not found'], 404);
        }else{
        return Opportunity::destroy($id);
        }
    }
}
