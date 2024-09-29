<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Variants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function welcome(){
        $variants = DB::table('variants')
        ->get();
        // $variants = Variants::all();

        $variant = Variants::whereColumn('sale_price', '<', 'listed_price')->get();

        return view('welcome', compact('variants'));
    }

}
