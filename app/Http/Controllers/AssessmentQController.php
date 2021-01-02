<?php

namespace App\Http\Controllers;

use App\Models\AssessmentQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssessmentQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AssessmentQ::latest()->get();
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
        Storage::disk('googleAssessmentQuestions')->put(str_replace(' ', '_', $f->getClientOriginalName().''), fopen($f, 'r+'));
        $fileLink = Storage::disk('googleAssessmentQuestions')->url(str_replace(' ', '_', $f->getClientOriginalName().''));
        
        AssessmentQ::create([
            'name' => $request->name,
            'branch' => $request->branch,
            'sem' => $request->sem,
            'is_f' => $request->is_f,
            'fileName' => $request->fileName,
            'fileLink' => $fileLink,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'uploaded_at' => $request->uploaded_at,
            'subject_id' => $request->subject_id,
            'subject_name' => $request->subject_name,
            'sub_code' => $request->sub_code,
            'created_by_id' => $request->created_by_id,
            'created_by_name' => $request->created_by_name,
            'date' => $request->date,
        ]);

        return AssessmentQ::latest()->take(1)->get();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssessmentQ  $assessmentQ
     * @return \Illuminate\Http\Response
     */
    public function show(AssessmentQ $assessmentQ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssessmentQ  $assessmentQ
     * @return \Illuminate\Http\Response
     */
    public function edit(AssessmentQ $assessmentQ)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssessmentQ  $assessmentQ
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssessmentQ $assessmentQ)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssessmentQ  $assessmentQ
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssessmentQ $assessmentQ)
    {
        //
    }
}
