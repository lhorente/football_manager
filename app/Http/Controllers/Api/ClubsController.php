<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Club;
use Validator;

class ClubsController extends Controller{
	function index(Request $request){
		$ret = [
			'status' => true,
			'message' => '',
			'response' => null
		];
		
		$clubs = Club::get();
		
		$ret['response'] = $clubs;
		
		return response()->json($ret);
	}
	
	function get(Request $request, $id){
		$ret = [
			'status' => false,
			'message' => '',
			'response' => null
		];
		
		$club = Club::where('id',$id)->get()->first();
		if ($club){
			$ret['status'] = true;
			$ret['response'] = $club;
			return response()->json($ret);
		}
		
		$ret['message'] = "Club not found";
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
			'short_name' => 'required|unique:clubs|max:3',
			'ground' => 'nullable',
			'founded' => 'date',
		];
		
		$validator = Validator::make($data, $rules);
		if (!$validator->passes()){
			$ret['message'] = "Please, check the fields";
			return response()->json($ret, 409);
		}
		
		$club = new Club;
		$club->name = $data['name'];
		$club->short_name = $data['short_name'];
		$club->ground = $data['ground'];
		$club->founded = $data['founded'];
		if ($club->save()){
			$ret['status'] = true;
			$ret['response'] = $club;
			return response()->json($ret);
		}
	}
	
	function edit(Request $request, $id){
		$ret = [
			'status' => false,
			'message' => '',
			'response' => null
		];
		$club = Club::where('id',$id)->get()->first();
		if (!$club){
			$ret['message'] = "Club not found";
			return response()->json($ret, 404);
		}
		
		$data = $request->all();
		
		$rules = [
			'name' => 'required|max:255',
			'short_name' => 'required|unique:clubs,short_name,'.$id.'|max:3',
			'ground' => 'nullable',
			'founded' => 'date',
		];
		
		$validator = Validator::make($data, $rules);
		if (!$validator->passes()){
			$ret['message'] = "Please, check the fields";
			return response()->json($ret, 409);
		}
		
		$club->name = $data['name'];
		$club->short_name = $data['short_name'];
		$club->ground = $data['ground'];
		$club->founded = $data['founded'];
		if ($club->save()){
			$ret['status'] = true;
			$ret['response'] = $club;
			return response()->json($ret);
		}
	}
	
	function remove(Request $request, $id){
		$ret = [
			'status' => false,
			'message' => ''
		];
		
		$deleteRows = Club::where('id',$id)->delete();
		if ($deleteRows){
			$ret['status'] = true;
			$ret['message'] = "Club deleted";
			return response()->json($ret);
		} else {
			$ret['message'] = "Club not found";
			return response()->json($ret, 404);
		}
	}
}
