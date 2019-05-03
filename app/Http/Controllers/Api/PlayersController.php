<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Club;
use App\Player;
use Validator;

class PlayersController extends Controller{
	function index(Request $request){
		$ret = [
			'status' => true,
			'message' => '',
			'response' => null
		];
		
		$players = Player::get();
		
		$ret['response'] = $players;
		
		return response()->json($ret);
	}
	
	function get(Request $request, $id){
		$ret = [
			'status' => false,
			'message' => '',
			'response' => null
		];
		
		$player = Player::where('id',$id)->get()->first();
		if ($player){
			$ret['status'] = true;
			$ret['response'] = $player;
			return response()->json($ret);
		}
		
		$ret['message'] = "Player not found";
		return response()->json($ret, 404);
	}
	
	function create(Request $request){
		$ret = [
			'status' => false,
			'message' => '',
			'response' => null
		];
		
		$data = $request->all();
		$rules = [
			'name' => 'required|max:255',
			'club_id' => 'required',
			'birthdate' => 'required|date',
		];
		
		$validator = Validator::make($data, $rules);
		if (!$validator->passes()){
			$ret['message'] = "Please, check the fields";
			return response()->json($ret, 409);
		}
		
		$club = Club::where('id',$data['club_id'])->get()->first();
		if (!$club){
			$ret['message'] = "Invalid club ID";
			return response()->json($ret, 409);
		}
		
		$player = new Player;
		$player->name = $data['name'];
		$player->club_id = $data['club_id'];
		$player->birthdate = $data['birthdate'];
		if ($player->save()){
			$ret['status'] = true;
			$ret['response'] = $player;
			return response()->json($ret);
		}
	}
	
	function edit(Request $request, $id){
		$ret = [
			'status' => false,
			'message' => '',
			'response' => null
		];
		$player = Player::where('id',$id)->get()->first();
		if (!$player){
			$ret['message'] = "Player not found";
			return response()->json($ret, 404);
		}
		
		$data = $request->all();
		
		$rules = [
			'name' => 'required|max:255',
			'club_id' => 'required',
			'birthdate' => 'required|date',
		];
		
		$validator = Validator::make($data, $rules);
		if (!$validator->passes()){
			$ret['message'] = "Please, check the fields";
			return response()->json($ret, 409);
		}
		
		$club = Club::where('id',$data['club_id'])->get()->first();
		if (!$club){
			$ret['message'] = "Invalid club ID";
			return response()->json($ret, 409);
		}
		
		$player->name = $data['name'];
		$player->club_id = $data['club_id'];
		$player->birthdate = $data['birthdate'];
		if ($player->save()){
			$ret['status'] = true;
			$ret['response'] = $player;
			return response()->json($ret);
		}
	}
	
	function remove(Request $request, $id){
		$ret = [
			'status' => false,
			'message' => ''
		];
		
		$deleteRows = Player::where('id',$id)->delete();
		if ($deleteRows){
			$ret['status'] = true;
			$ret['message'] = "Player deleted";
			return response()->json($ret);
		} else {
			$ret['message'] = "Player not found";
			return response()->json($ret, 404);
		}
	}
}
