<?php

namespace App\Http\Controllers;

use App\Models\AssignmentA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AssignmentA::latest()->get();
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
        Storage::disk('googleAssignmentAnswers')->put(str_replace(' ', '_', $f->getClientOriginalName().''), fopen($f, 'r+'));
        $fileLink = Storage::disk('googleAssignmentAnswers')->url(str_replace(' ', '_', $f->getClientOriginalName().''));
        
        AssignmentA::create([
            'fileLink' => $fileLink,
            'Assignment_id' => $request->Assignment_id,
            'uploaded_at' => $request->uploaded_at,
            'uploaded_by' => $request->uploaded_by,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssignmentA  $assignmentA
     * @return \Illuminate\Http\Response
     */
    public function show(AssignmentA $assignmentA)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssignmentA  $assignmentA
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignmentA $assignmentA)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssignmentA  $assignmentA
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssignmentA $assignmentA)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssignmentA  $assignmentA
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignmentA $assignmentA)
    {
        //
    }
}
