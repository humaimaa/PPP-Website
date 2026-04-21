<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Homepage
     */
    public function home()
    {
        return view('user.home');
    }

    /**
     * Pitchbook page
     */
    public function pitchbook()
    {
        return view('user.pitchbook');
    }

    /**
     * About page with optional section parameter
     */
    public function about($section = 'overview')
    {
        return view('user.about', compact('section'));
    }

    /**
     * Tenders page with optional section parameter
     */
    public function tenders($section = 'active')
    {
        return view('user.tenders', compact('section'));
    }

    /**
     * Projects page with optional status parameter
     */
    public function projectsIndex($status = 'all')
    {
        return view('user.projects.index', compact('status'));
    }

    /**
     * Individual project detail page
     */
    public function projectsShow($id)
    {
        return view('user.projects.show', compact('id'));
    }

    /**
     * News index page
     */
    public function newsIndex()
    {
        return view('user.news.index');
    }

    /**
     * Individual news detail page
     */
    public function newsShow($id)
    {
        return view('user.news.show', compact('id'));
    }

    /**
     * Gallery index page
     */
    public function galleryIndex()
    {
        return view('user.gallery.index');
    }

    /**
     * Gallery album page
     */
    public function galleryAlbum($id)
    {
        return view('user.gallery.album', compact('id'));
    }

    /**
     * Downloads page
     */
    public function downloads()
    {
        return view('user.downloads', [
            'documents' => collect([])
        ]);
    }

    /**
     * API endpoint for downloading files
     */
    public function apiDownloadFile($id)
    {
        // We'll implement this in Step 4
        return response()->json(['success' => true]);
    }

    /**
     * API endpoint for previewing files
     */
    public function apiPreviewFile($id)
    {
        // We'll implement this in Step 4
        return response()->json(['success' => true]);
    }

    /**
     * Contact page
     */
    public function contact()
    {
        return view('user.contact');
    }
}