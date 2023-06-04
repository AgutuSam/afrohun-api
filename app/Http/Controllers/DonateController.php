<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDonateRequest;
use App\Models\Donate;
use App\Models\Member;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class DonateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponses;
    public function index()
    {
        $don = Donate::all();
        return $don;
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
    public function store(StoreDonateRequest $request, $mem_id)
    {
        $this->validate($request, array(
            'donation_type' => 'required',
            'title'=> 'required',
            'description' => 'required',
            'amount' => 'required',
            'status' => 'required'
          ));
          // decode token to  get id
          // or get id from front end

        $don= new Donate();
        $mem= Member::find($mem_id);
        if (!$mem){
        return response()->json(['error' => 'Member not found'], 404);
        }else{
        
        $don->donor_id = $mem_id;
        $don->donation_type = $request->donation_type;
        $don->title = $request->title;
        $don->description = $request->description;
        $don->amount = $request->amount;
        $don->status = $request->status;
        $don->save();

        return $this->success([
        'data' => $don,
        'message'=>'donation created'
        ]);  
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $mem_id, $id)
    {
        $mem= Member::find($mem_id);
        if (!$mem){
        return response()->json(['error' => 'Member not found'], 404);
        }else{
            return Donate::find($id);
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
        $mem= Member::find($mem_id);
        if (!$mem){
        return response()->json(['error' => 'Member not found'], 404);
        }else{
        $don=Donate::find($id);
        $don->update($request->all());
        return $don;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $mem_id, $id)
    {
        $mem= Member::find($mem_id);
        if (!$mem){
        return response()->json(['error' => 'Member not found'], 404);
        } else{return Donate::destroy($id);}
    }
}
