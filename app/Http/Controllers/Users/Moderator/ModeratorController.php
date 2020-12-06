<?php

namespace App\Http\Controllers\Users\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:moderator');
    }

    public function index()
    {
        return view('moderator');
    }
}