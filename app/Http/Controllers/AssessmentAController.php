<?php

namespace App\Http\Controllers;

use App\Models\AssessmentA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssessmentAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AssessmentA::latest()->get();
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
        Storage::disk('googleAssessmentAnswers')->put(str_replace(' ', '_', $f->getClientOriginalName().''), fopen($f, 'r+'));
        $fileLink = Storage::disk('googleAssessmentAnswers')->url(str_replace(' ', '_', $f->getClientOriginalName().''));
        
        AssessmentA::create([
            'fileLink' => $fileLink,
            'Assessment_id' => $request->Assessment_id,
            'uploaded_by' => $request->uploaded_by,
        ]);

        return AssessmentA::latest()->take(1)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssessmentA  $assessmentA
     * @return \Illuminate\Http\Response
     */
    public function show(AssessmentA $assessmentA)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssessmentA  $assessmentA
     * @return \Illuminate\Http\Response
     */
    public function edit(AssessmentA $assessmentA)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssessmentA  $assessmentA
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssessmentA $assessmentA)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssessmentA  $assessmentA
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssessmentA $assessmentA)
    {
        //
    }
}
