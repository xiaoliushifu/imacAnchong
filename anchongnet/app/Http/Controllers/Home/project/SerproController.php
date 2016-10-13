<?php

namespace App\Http\Controllers\Home\project;

use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;

class SerproController extends CommonController
{

    public function getLepro()
    {
        $lepro =  Business::where('type', 2)->orderBy('created_at', 'asc')->paginate(15);

        return view('home.project.projectlist2', compact('lepro'));
    }
}
