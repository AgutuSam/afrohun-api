<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArchiveRequest;
use App\Models\Archive;
use App\Models\Member;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arch = Archive::all();
        return $arch;
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
    public function store(StoreArchiveRequest $request)
    {
        $this->validate($request, array(
            'category' => 'required',
            'title'=> 'required',
            'description' => 'required',
            'file_path' => 'required',

          ));
          // decode token to  get id
          // or get id from front end

        $arch= new Archive();
        $filename=$request->file('file_path')->store('archives','public');

        $arch->category = $request->category;
        $arch->title = $request->title;
        $arch->description = $request->description;
        // $arch->file_path = $request->file_path;
          $arch->file_path = $filename;

        $arch->save();

        return $this->success([
        'data' => $arch,
        'message'=>'Archive Uploaded'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Archive::find($id);
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
    public function update(Request $request, string $id)
    {
        $arch=Archive::find($id);
        $arch->update($request->all());
        return $arch;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Archive::destroy($id);
    }
}
