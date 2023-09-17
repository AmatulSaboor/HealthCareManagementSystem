<?php
namespace App\Http\Controllers;

use Exception;

class AdminController extends Controller
{
    public function index()
    {
        try {
            return view('admin/admin');
        } catch (Exception $e) {
            return redirect('admin/admin')->with(['error_message' => 'something went wrong, refresh the page and try again']);
        }
    }
}