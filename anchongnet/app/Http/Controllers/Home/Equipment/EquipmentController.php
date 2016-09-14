<?php

namespace App\Http\Controllers\Home\Equipment;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EquipmentController extends Controller
{
    public function getIndex()
    {
        return view('home.equipment.equipshopping');
   }

    public function getList()
    {
        return view('home.equipment.goodslist');
    }
    public function getShow()
    {
        return view('home.equipment.goodsdetals');
    }
    public function getThirdshop()
    {
        return view('home.equipment.thirdparty');
    }
}
