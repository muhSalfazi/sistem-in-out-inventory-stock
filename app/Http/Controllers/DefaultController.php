<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function index()
    {
        // Clear the session
        session()->flush();

        // Flash a message for the session
        session()->flash('danger', 'Page not found. Please log in again.');

        // Redirect to the login page
        return redirect()->route('login');
    }
}
