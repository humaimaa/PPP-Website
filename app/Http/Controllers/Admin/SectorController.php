<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource with search functionality.
     */
    public function index(Request $request)
    {
        $query = Sector::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('tagline', 'like', '%' . $search . '%')
                  ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }
        
        $sectors = $query->latest()->paginate(10);
        
        return view('admin.sectors.index', compact('sectors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sectors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sectors',
            'tagline' => 'required|string|max:500',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('img')->store('sectors', 'public');

        // Generate unique slug
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Sector::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Sector::create([
            'name' => $request->name,
            'slug' => $slug,
            'tagline' => $request->tagline,
            'img' => $imagePath,
        ]);

        return redirect()->route('admin.sectors.index')
            ->with('success', 'Sector created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sector $sector)
    {
        return view('admin.sectors.show', compact('sector'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sector $sector)
    {
        return view('admin.sectors.edit', compact('sector'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sector $sector)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sectors,name,' . $sector->id,
            'tagline' => 'required|string|max:500',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'tagline' => $request->tagline,
        ];

        // Update slug if name changed
        if ($sector->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;
            while (Sector::where('slug', $slug)->where('id', '!=', $sector->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('img')) {
            // Delete old image
            if ($sector->img) {
                Storage::disk('public')->delete($sector->img);
            }
            $data['img'] = $request->file('img')->store('sectors', 'public');
        }

        $sector->update($data);

        return redirect()->route('admin.sectors.index')
            ->with('success', 'Sector updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector)
    {
        // Delete image
        if ($sector->img) {
            Storage::disk('public')->delete($sector->img);
        }
        
        $sector->delete();

        return redirect()->route('admin.sectors.index')
            ->with('success', 'Sector deleted successfully.');
    }

    /**
     * Bulk delete sectors.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'sector_ids' => 'required|array',
            'sector_ids.*' => 'exists:sectors,id',
        ]);

        $sectors = Sector::whereIn('id', $request->sector_ids)->get();
        $deletedCount = $sectors->count();
        
        foreach ($sectors as $sector) {
            if ($sector->img) {
                Storage::disk('public')->delete($sector->img);
            }
        }
        
        Sector::whereIn('id', $request->sector_ids)->delete();

        return redirect()->route('admin.sectors.index')
            ->with('success', $deletedCount . ' sector(s) deleted successfully.');
    }
}