<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Club;
use App\Player;

class ClubsController extends Controller{
    public function index(Request $request){
		$clubs = Club::get();
		
		return view('clubs/index',compact('clubs'));
	}
	
    public function viewPlayers(Request $request, $id){
		$club = Club::where('id',$id)->get()->first();
		if (!$club){
			abort(404);
		}
		
		$players = Player::where('club_id',$id)->get();
		
		return view('clubs/viewPlayers',compact('club','players'));
	}	
	
	public function create(Request $request){
		return view('clubs/create');
	}
	
	public function edit(Request $request, $id){
		$club = Club::where('id',$id)->get()->first();
		if (!$club){
			abort(404);
		}
		return view('clubs/edit',compact('club'));
	}
	
	public function remove(Request $request, $id){
		$deleteRows = Club::where('id',$id)->delete();
		if ($deleteRows){
			$request->session()->flash('message', 'Success! Club removed.'); 
			$request->session()->flash('alert-class', 'alert-success');
			return redirect()->route('clubsIndex');
		} else {
			$request->session()->flash('message', 'Club not found'); 
			$request->session()->flash('alert-class', 'alert-danger');
			return redirect()->route('clubsIndex');
		}
	}
	
	public function postCreate(Request $request){
		$data = $request->all();
		$rules = [
			'name' => 'required|max:255',
			'short_name' => 'required|unique:clubs|max:3',
			'ground' => 'nullable',
			'founded' => 'date',
		];
		
		$validator = Validator::make($data, $rules);
		if (!$validator->passes()){
			$request->session()->flash('message', 'Please, check the fields'); 
			$request->session()->flash('alert-class', 'alert-danger');
			return redirect()->route('clubsCreate');
		}
		
		$club = new Club;
		$club->name = $data['name'];
		$club->short_name = $data['short_name'];
		$club->ground = $data['ground'];
		$club->founded = $data['founded'];
		if ($club->save()){
			$request->session()->flash('message', 'Success! Club created.'); 
			$request->session()->flash('alert-class', 'alert-success');
			return redirect()->route('clubsIndex');
		}
		
		$request->session()->flash('message', 'Error creating club'); 
		$request->session()->flash('alert-class', 'alert-danger');		
		return redirect()->route('clubsCreate');
	}
	
	public function postEdit(Request $request, $id){
		$club = Club::where('id',$id)->get()->first();
		if (!$club){
			abort(404);
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
			$request->session()->flash('message', 'Please, check the fields'); 
			$request->session()->flash('alert-class', 'alert-danger');
			return redirect()->route('clubsPostEdit',[$id]);
		}
		
		$club->name = $data['name'];
		$club->short_name = $data['short_name'];
		$club->ground = $data['ground'];
		$club->founded = $data['founded'];
		if ($club->save()){
			$request->session()->flash('message', 'Success! Club created.'); 
			$request->session()->flash('alert-class', 'alert-success');
			return redirect()->route('clubsIndex');
		}
		
		$request->session()->flash('message', 'Error creating club'); 
		$request->session()->flash('alert-class', 'alert-danger');		
		return redirect()->route('clubsPostEdit',[$id]);
	}
}
