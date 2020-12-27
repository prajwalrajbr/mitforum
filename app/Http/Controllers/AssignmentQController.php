<?php

namespace App\Http\Controllers;

use App\Models\AssignmentQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AssignmentQ::latest()->get(['name','created_by','last_date_time','subject_id','id','fileLink']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $f = $request->file('fileName');
        Storage::disk('googleAssignmentQuestions')->put(str_replace(' ', '_', $f->getClientOriginalName().''), fopen($f, 'r+'));
        $fileLink = Storage::disk('googleAssignmentQuestions')->url(str_replace(' ', '_', $f->getClientOriginalName().''));
        
        AssignmentQ::create([
            'name' => $request->name,
            'fileName' => $request->fileName,
            'fileLink' => $fileLink,
            'created_by' => $request->created_by,
            'last_date_time' => $request->last_date_time,
            'subject_id' => $request->subject_id,
        ]);

        return $fileLink;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssignmentQ  $assignmentQ
     * @return \Illuminate\Http\Response
     */
    public function show(AssignmentQ $assignmentQ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssignmentQ  $assignmentQ
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignmentQ $assignmentQ)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssignmentQ  $assignmentQ
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssignmentQ $assignmentQ)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssignmentQ  $assignmentQ
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignmentQ $assignmentQ)
    {
        //
    }

    
    public function getAssignmentQLink(Request $request){
        $id = $request->id;
        return AssignmentQ::where('id',$id)->get(['fileLink','name']);
    }
}
