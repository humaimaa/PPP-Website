<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Project;
use Illuminate\Http\Request;
class ProjectController extends Controller
{
      public function index()
    {
        return view('admin.projects.index');
    }

    public function create()
    {
        return view('admin.projects.add');
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('admin.projects.edit', compact('id'));
    }
}
