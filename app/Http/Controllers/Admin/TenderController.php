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
    public function index()
    {
        $tenders = Tender::latest()->paginate(10);
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
            'advertisement' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
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
            'advertisement' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'additional_docs' => 'nullable|array',
            'additional_docs.*.title' => 'nullable|string|max:255',
            'additional_docs.*.publish_date' => 'nullable|date',
            'additional_docs.*.document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Handle main document upload
        if ($request->hasFile('document')) {
            // Delete old document
            if ($tender->document && Storage::disk('public')->exists($tender->document)) {
                Storage::disk('public')->delete($tender->document);
            }
            
            $document = $request->file('document');
            $documentName = time() . '_document_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $document->getClientOriginalName());
            $validated['document'] = $document->storeAs('tenders/documents', $documentName, 'public');
        }

        // Handle advertisement upload
        if ($request->hasFile('advertisement')) {
            // Delete old advertisement
            if ($tender->advertisement && Storage::disk('public')->exists($tender->advertisement)) {
                Storage::disk('public')->delete($tender->advertisement);
            }
            
            $advertisement = $request->file('advertisement');
            $advertisementName = time() . '_ad_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $advertisement->getClientOriginalName());
            $validated['advertisement'] = $advertisement->storeAs('tenders/advertisements', $advertisementName, 'public');
        }

        $tender->update($validated);

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
        
        // Delete additional documents (cascade will handle database records)
        foreach ($tender->additionalDocs as $doc) {
            if ($doc->document && Storage::disk('public')->exists($doc->document)) {
                Storage::disk('public')->delete($doc->document);
            }
        }
        
        $tender->delete();
        
        return redirect()->route('admin.tenders.index')
            ->with('success', 'Tender deleted successfully!');
    }

    /**
 * Delete an additional document
 */
public function deleteAdditionalDoc($id)
{
    try {
        $doc = TenderAdditionalDoc::findOrFail($id);
        
        // Delete the file
        if ($doc->document && Storage::disk('public')->exists($doc->document)) {
            Storage::disk('public')->delete($doc->document);
        }
        
        $doc->delete();
        
        return redirect()->back()->with('success', 'Additional document deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error deleting document: ' . $e->getMessage());
    }
}
}