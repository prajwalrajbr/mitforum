<?php

namespace App\Http\Controllers;

use App\Models\subjects;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return subjects::latest()->get();
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
        $request->validate([
            'sub_code' => ['required', 'unique:subjects'],
            'subject_name' => ['required'],
            'sem' => ['required'],
            'branch' => ['required'],
            'created_by' => ['required'],
        ]);
        subjects::create([
            'sub_code' => $request->sub_code,
            'subject_name' => $request->subject_name,
            'sem' => $request->sem,
            'branch' => $request->branch,
            'created_by' => $request->created_by,
        ]);

        return subjects::latest()->take(1)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subjects  $subjects
     * @return \Illuminate\Http\Response
     */
    public function show(subjects $subjects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subjects  $subjects
     * @return \Illuminate\Http\Response
     */
    public function edit(subjects $subjects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subjects  $subjects
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, subjects $subjects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subjects  $subjects
     * @return \Illuminate\Http\Response
     */
    public function destroy(subjects $subjects)
    {
        //
    }

    public function getSubjectId(Request $request){
        return subjects::where([
            ['sem',$request->sem],
            ['branch',$request->branch],
            ['sub_code',$request->sub_code],
        ])->get(['id']);
    }

    public function getSubjects(Request $request){
        $branch = $request->branch;
        return subjects::where('branch',$branch)->get(['id','sem','sub_code','subject_name']);
    }

    public function getSubjectSemAndBranch(Request $request){
        $id = $request->id;
        return subjects::where('id',$id)->get(['sem','branch','sub_code','subject_name']);
    }
}
