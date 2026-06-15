<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Models\TenderAdditionalDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
/**
 * Display a listing of the resource.
 */
public function index(Request $request)
{
    $query = Tender::query();
    
    // Search by name
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    
    // Filter by category
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }
    
    // Filter by status (using effective closing date)
    if ($request->filled('status')) {
        $now = now();
        switch ($request->status) {
            case 'open':
                $query->where(function($q) use ($now) {
                    $q->whereRaw('COALESCE(extended_closing_date, closing_date) > ?', [$now])
                      ->where('opening_date', '<=', $now);
                });
                break;
            case 'closed':
                $query->whereRaw('COALESCE(extended_closing_date, closing_date) < ?', [$now]);
                break;
            case 'upcoming':
                $query->where('opening_date', '>', $now);
                break;
        }
    }
    
    $tenders = $query->latest()->paginate(10);
    
    return view('admin.tenders.index', compact('tenders'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tenders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:General Procurement,Transaction Advisory,Private Partner Selection',
            'opening_date' => 'required|date',
            'closing_date' => 'required|date|after:opening_date',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'advertisement' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'additional_docs' => 'nullable|array',
            'additional_docs.*.title' => 'nullable|string|max:255',
            'additional_docs.*.publish_date' => 'nullable|date',
            'additional_docs.*.document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Handle main document upload
        $documentPath = null;
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = time() . '_document_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $document->getClientOriginalName());
            $documentPath = $document->storeAs('tenders/documents', $documentName, 'public');
        }

        // Handle advertisement upload
        $advertisementPath = null;
        if ($request->hasFile('advertisement')) {
            $advertisement = $request->file('advertisement');
            $advertisementName = time() . '_ad_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $advertisement->getClientOriginalName());
            $advertisementPath = $advertisement->storeAs('tenders/advertisements', $advertisementName, 'public');
        }

        // Create tender
        $tender = Tender::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'opening_date' => $validated['opening_date'],
            'closing_date' => $validated['closing_date'],
            'document' => $documentPath,
            'advertisement' => $advertisementPath,
        ]);

        // Handle additional documents
        if ($request->has('additional_docs')) {
            foreach ($request->additional_docs as $doc) {
                if (!empty($doc['title']) && isset($doc['document']) && $doc['document'] instanceof \Illuminate\Http\UploadedFile) {
                    $additionalDocPath = $doc['document']->storeAs('tenders/additional_docs', 
                        time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $doc['document']->getClientOriginalName()), 
                        'public'
                    );
                    
                    TenderAdditionalDoc::create([
                        'tender_id' => $tender->id,
                        'title' => $doc['title'],
                        'publish_date' => $doc['publish_date'] ?? now(),
                        'document' => $additionalDocPath,
                    ]);
                }
            }
        }

        return redirect()->route('admin.tenders.index')
            ->with('success', 'Tender created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tender $tender)
    {
        $tender->load('additionalDocs');
        return view('admin.tenders.show', compact('tender'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tender $tender)
    {
        $tender->load('additionalDocs');
        return view('admin.tenders.edit', compact('tender'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tender $tender)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:General Procurement,Transaction Advisory,Private Partner Selection',
            'opening_date' => 'required|date',
            'closing_date' => 'required|date|after:opening_date',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'advertisement' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'additional_docs' => 'nullable|array',
            'additional_docs.*.title' => 'nullable|string|max:255',
            'additional_docs.*.publish_date' => 'nullable|date',
            'additional_docs.*.document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Prepare data for update (only database columns)
        $updateData = [
            'name' => $validated['name'],
            'category' => $validated['category'],
            'opening_date' => $validated['opening_date'],
            'closing_date' => $validated['closing_date'],
        ];

        // Handle main document upload
        if ($request->hasFile('document')) {
            // Delete old document
            if ($tender->document && Storage::disk('public')->exists($tender->document)) {
                Storage::disk('public')->delete($tender->document);
            }
            
            $document = $request->file('document');
            $documentName = time() . '_document_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $document->getClientOriginalName());
            $updateData['document'] = $document->storeAs('tenders/documents', $documentName, 'public');
        }

        // Handle advertisement upload
        if ($request->hasFile('advertisement')) {
            // Delete old advertisement
            if ($tender->advertisement && Storage::disk('public')->exists($tender->advertisement)) {
                Storage::disk('public')->delete($tender->advertisement);
            }
            
            $advertisement = $request->file('advertisement');
            $advertisementName = time() . '_ad_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $advertisement->getClientOriginalName());
            $updateData['advertisement'] = $advertisement->storeAs('tenders/advertisements', $advertisementName, 'public');
        }

        // Update the tender
        $tender->update($updateData);

        // Handle additional documents
        if ($request->has('additional_docs')) {
            foreach ($request->additional_docs as $doc) {
                if (!empty($doc['title']) && isset($doc['document']) && $doc['document'] instanceof \Illuminate\Http\UploadedFile) {
                    $additionalDocPath = $doc['document']->storeAs('tenders/additional_docs', 
                        time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $doc['document']->getClientOriginalName()), 
                        'public'
                    );
                    
                    TenderAdditionalDoc::create([
                        'tender_id' => $tender->id,
                        'title' => $doc['title'],
                        'publish_date' => $doc['publish_date'] ?? now(),
                        'document' => $additionalDocPath,
                    ]);
                }
            }
        }

        return redirect()->route('admin.tenders.index')
            ->with('success', 'Tender updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tender $tender)
    {
        // Delete main document
        if ($tender->document && Storage::disk('public')->exists($tender->document)) {
            Storage::disk('public')->delete($tender->document);
        }
        
        // Delete advertisement
        if ($tender->advertisement && Storage::disk('public')->exists($tender->advertisement)) {
            Storage::disk('public')->delete($tender->advertisement);
        }
        
        // Delete additional documents - they will be automatically deleted from DB due to cascade
        // But we need to delete the physical files
        $additionalDocs = TenderAdditionalDoc::where('tender_id', $tender->id)->get();
        foreach ($additionalDocs as $doc) {
            if ($doc->document && Storage::disk('public')->exists($doc->document)) {
                Storage::disk('public')->delete($doc->document);
            }
        }
        
        // Delete the tender (additional docs will be deleted automatically due to cascade)
        $tender->delete();
        
        return redirect()->route('admin.tenders.index')
            ->with('success', 'Tender deleted successfully!');
    }

    /**
     * Delete an additional document.
     */
    public function deleteAdditionalDoc($id)
    {
        try {
            $doc = TenderAdditionalDoc::findOrFail($id);
            
            // Delete the physical file
            if ($doc->document && Storage::disk('public')->exists($doc->document)) {
                Storage::disk('public')->delete($doc->document);
            }
            
            // Delete the database record
            $doc->delete();
            
            return redirect()->back()->with('success', 'Additional document deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting document: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete tenders.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:tenders,id',
        ]);

        $tenders = Tender::whereIn('id', $request->ids)->get();

        foreach ($tenders as $tender) {
            // Delete main document
            if ($tender->document && Storage::disk('public')->exists($tender->document)) {
                Storage::disk('public')->delete($tender->document);
            }

            // Delete advertisement
            if ($tender->advertisement && Storage::disk('public')->exists($tender->advertisement)) {
                Storage::disk('public')->delete($tender->advertisement);
            }

            // Delete additional documents physical files
            $additionalDocs = TenderAdditionalDoc::where('tender_id', $tender->id)->get();
            foreach ($additionalDocs as $doc) {
                if ($doc->document && Storage::disk('public')->exists($doc->document)) {
                    Storage::disk('public')->delete($doc->document);
                }
            }

            // Delete the tender (additional docs will be deleted automatically due to cascade)
            $tender->delete();
        }

        return redirect()->route('admin.tenders.index')
            ->with('success', count($request->ids) . ' tender(s) deleted successfully.');
    }



    /**
 * Extend the closing date of a tender
 */
public function extend(Request $request, Tender $tender)
{
    $request->validate([
        'new_closing_date' => 'required|date|after:' . $tender->closing_date->format('Y-m-d'),
    ]);
    
    $tender->update([
        'extended_closing_date' => $request->new_closing_date
    ]);
    
    return redirect()->route('admin.tenders.index')
        ->with('success', sprintf(
            'Closing date extended from %s to %s for tender: %s',
            $tender->closing_date->format('M d, Y'),
            $tender->effective_closing_date->format('M d, Y'),
            $tender->name
        ));
}

/**
 * Remove extension (reset to original closing date)
 */
public function removeExtension(Tender $tender)
{
    $tender->update([
        'extended_closing_date' => null
    ]);
    
    return redirect()->route('admin.tenders.index')
        ->with('success', sprintf(
            'Extension removed for tender: %s. Closing date reset to %s',
            $tender->name,
            $tender->closing_date->format('M d, Y')
        ));
}
}