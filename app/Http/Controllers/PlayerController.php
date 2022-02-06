<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Member;
use App\Models\mayo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function home()
    {
        $members = Member::all();
        $players = mayo::with('Member')->where('status','!=','3')->get();
        
        return [
            'members' => $members,
            'players' => $players
        ];

    }
    public function topPlayer($id)
    {
        $player = mayo::with('Member')->where('id',$id)->first();
        
        return [
            'player' => $player
        ];

    }
    public function index($member,$cate)
    {
        $categories = Category::all();
        $members = Member::all();
        $current_member = Member::where('name', '=', $member)->first();
        $name = $current_member->name;
        
        return view('players/mayoPlayer', [
            'categories' => $categories,
            'members' => $members,
            'current_member' => $current_member,
            'name' => $name,
        ]);

    }
    public function cate($member,$cate)
    {
        $players = mayo::whereHas('member', function ($query) use ($member) {
                            $query->where('name', $member );
                        })->where('players.cate_id', $cate)
                        ->where('status','!=','3')
                        ->orderBy('id','DESC')->get();

        return response()->json(['players' => $players]);
    }
    public function player($member,$id)
    {
        $data = mayo::find($id);

        return response()->json(['data' => $data]);
    }
    
    public function edit(Request $request,int $id)
    {   
        $data = mayo::find($id);
        $data->status = $request->status;
        $data->save();

        return redirect("api/root/player/".$id);
    }
    public function addindex($member)
    {
        $categories = Category::all();
        $members = Member::all();
        $current_member = Member::where('name', '=', $member)->first();
        $name = $current_member->name;
        
        return view('players/mayoPlayer', [
            'categories' => $categories,
            'members' => $members,
            'current_member' => $current_member,
            'name' => $name,
        ]);

    }
    public function add(Request $request,string $member){
        $temp = $request->all();
        var_dump($temp);
        DB::table('players')->insert($temp);
    }
    
    public function clip(Request $request,string $member){
        $temp = $request->all();
        var_dump($temp);
        DB::table('players')->insert($temp);
    }
}