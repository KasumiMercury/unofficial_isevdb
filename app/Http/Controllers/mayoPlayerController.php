<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\mayoplayers;
use Illuminate\Http\Request;

class mayoPlayerController extends Controller
{
    public function show(string $cate)
    {
        $mayoplayers = mayoplayers::where('cate_id', $cate)->orderBy('id','DESC')->get();

        return response()->json(['mayoplayers' => $mayoplayers]);
    }
}
