<?php

namespace App\Http\Controllers;

use App\Models\AandQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AandQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AandQ::latest()->get();
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
        if($request->includeFiles == 'true'){
            $f = $request->file('fileName');
            Storage::disk('googleAnnouncementAndQueries')->put(str_replace(' ', '_', $f->getClientOriginalName().''), fopen($f, 'r+'));
            $fileLink = Storage::disk('googleAnnouncementAndQueries')->url(str_replace(' ', '_', $f->getClientOriginalName().''));    
        }else{
            $fileLink = null;
        }
        
        AandQ::create([
            'name' => $request->name,
            'description' => $request->description,
            'fileLink' => $fileLink,
            'is_f' => $request->is_f,
            'uploaded_at' => $request->uploaded_at,
            'uploaded_by' => $request->uploaded_by,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AandQ  $aandQ
     * @return \Illuminate\Http\Response
     */
    public function show(AandQ $aandQ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AandQ  $aandQ
     * @return \Illuminate\Http\Response
     */
    public function edit(AandQ $aandQ)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AandQ  $aandQ
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AandQ $aandQ)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AandQ  $aandQ
     * @return \Illuminate\Http\Response
     */
    public function destroy(AandQ $aandQ)
    {
        //
    }
}
