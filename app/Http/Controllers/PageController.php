<?php

namespace App\Http\Controllers;

use App\Excel\UsersExport;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.welcome');
    }
}
