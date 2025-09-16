<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Kelas;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index(Request $request)
    {

        return view('pages.login');
    }
}
