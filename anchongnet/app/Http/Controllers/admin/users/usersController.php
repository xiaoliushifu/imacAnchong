<?php

namespace App\Http\Controllers\admin\users;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class usersController extends Controller
{
       public function index()
        {
          return view('admin.users.index');
        }
}
