<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('admin.tenders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tenders.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tender $tender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tender $tender)
    {
            return view('admin.tenders.edit', compact('tender'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tender $tender)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tender $tender)
    {
        //
    }
}
