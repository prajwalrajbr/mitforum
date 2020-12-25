<?php

namespace App\Http\Controllers;

use App\Models\notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {$size = Storage::size('381xKFTrG6bOnAnHNetfkjltaIDtgiiEgLlTdtCl.pdf');
        if (Storage::disk('google')->exists('381xKFTrG6bOnAnHNetfkjltaIDtgiiEgLlTdtCl.pdf')) {
            return true;
        }
        return $size;
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
        Storage::disk('googleNotes')->put(str_replace(' ', '_', $f->getClientOriginalName().''), fopen($f, 'r+'));
        $fileId = Storage::disk('googleNotes')->url(str_replace(' ', '_', $f->getClientOriginalName().''));
        $fileId = substr($fileId,strpos($fileId,"="),-13);
        $fileId = substr($fileId,1);
        notes::create([
            'name' => $request->name,
            'fileName' => $request->fileName,
            'fileId' => $fileId,
            'uploaded_by' => $request->uploaded_by,
            'uploaded_subject_id' => $request->uploaded_subject_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function show(notes $notes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function edit(notes $notes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, notes $notes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function destroy(notes $notes)
    {
        //
    }

    public function getNotesName(Request $request){
        $id = $request->id;
        return notes::where('id',$id)->get(['fileName','name']);
    }
}
