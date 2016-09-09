<?php

namespace App\Http\Controllers\Home\Community;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommunityController extends Controller
{
    public function index()
    {
        return view('home/community/index');
    }
}
