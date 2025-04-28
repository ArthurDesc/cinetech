<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Liste des commentaires pour l'administration
     */
    public function comments()
    {
        $comments = \App\Models\Comment::with('user')->latest()->paginate(15);
        $currentPage = $comments->currentPage();
        $totalPages = $comments->lastPage();
        return view('admin.comments', compact('comments', 'currentPage', 'totalPages'));
    }
} 