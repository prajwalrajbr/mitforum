<?php

namespace App\Http\Controllers;

use App\Models\FacultyTable;
use Illuminate\Http\Request;

class FacultyTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FacultyTable::get(['FID','email']);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FacultyTable  $facultyTable
     * @return \Illuminate\Http\Response
     */
    public function show(FacultyTable $facultyTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacultyTable  $facultyTable
     * @return \Illuminate\Http\Response
     */
    public function edit(FacultyTable $facultyTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FacultyTable  $facultyTable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacultyTable $facultyTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacultyTable  $facultyTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacultyTable $facultyTable)
    {
        //
    }
}
