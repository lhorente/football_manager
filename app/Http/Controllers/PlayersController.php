<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Club;
use App\Player;

class PlayersController extends Controller{
    public function index(Request $request){
		$players = Player::get();
		
		return view('players/index',compact('players'));
	}
	
	public function create(Request $request){
		$clubs = Club::get();
		return view('players/create',compact('clubs'));
	}
	
	public function edit(Request $request, $id){
		$clubs = Club::get();
		$player = Player::where('id',$id)->get()->first();
		if (!$player){
			abort(404);
		}
		return view('players/edit',compact('clubs','player'));
	}
	
	public function remove(Request $request, $id){
		$deleteRows = Player::where('id',$id)->delete();
		if ($deleteRows){
			$request->session()->flash('message', 'Success! Player removed.'); 
			$request->session()->flash('alert-class', 'alert-success');
			return redirect()->route('playersIndex');
		} else {
			$request->session()->flash('message', 'Player not found'); 
			$request->session()->flash('alert-class', 'alert-danger');
			return redirect()->route('playersIndex');
		}
	}
	
	public function postCreate(Request $request){
		$data = $request->all();
		$rules = [
			'name' => 'required|max:255',
			'club_id' => 'required',
			'birthdate' => 'required|date',
		];
		
		$validator = Validator::make($data, $rules);
		if (!$validator->passes()){
			$request->session()->flash('message', 'Please, check the fields'); 
			$request->session()->flash('alert-class', 'alert-danger');
			return redirect()->route('playersCreate');
		}
		
		$player = new Player;
		$player->name = $data['name'];
		$player->club_id = $data['club_id'];
		$player->birthdate = $data['birthdate'];
		if ($player->save()){
			$request->session()->flash('message', 'Success! Player created.'); 
			$request->session()->flash('alert-class', 'alert-success');
			return redirect()->route('playersIndex');
		}
		
		$request->session()->flash('message', 'Error creating player'); 
		$request->session()->flash('alert-class', 'alert-danger');		
		return redirect()->route('playersCreate');
	}
	
	public function postEdit(Request $request, $id){
		$player = Player::where('id',$id)->get()->first();
		if (!$player){
			abort(404);
		}
		
		$data = $request->all();
		$rules = [
			'name' => 'required|max:255',
			'club_id' => 'required',
			'birthdate' => 'required|date',
		];
		
		$validator = Validator::make($data, $rules);
		if (!$validator->passes()){
			$request->session()->flash('message', 'Please, check the fields'); 
			$request->session()->flash('alert-class', 'alert-danger');
			return redirect()->route('playersPostEdit',[$id]);
		}
		
		$player->name = $data['name'];
		$player->club_id = $data['club_id'];
		$player->birthdate = $data['birthdate'];
		if ($player->save()){
			$request->session()->flash('message', 'Success! Player created.'); 
			$request->session()->flash('alert-class', 'alert-success');
			return redirect()->route('playersIndex');
		}
		
		$request->session()->flash('message', 'Error creating player'); 
		$request->session()->flash('alert-class', 'alert-danger');		
		return redirect()->route('playersPostEdit',[$id]);
	}
	
	public function export(Request $request){
		$clubs = Club::get();
		return view('players/export',compact('clubs'));
	}
	
	public function postExport(Request $request){
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="players.csv"');
	
		$data = $request->all();
		
		if ($data['club_id']){
			$players = Player::where('club_id',$data['club_id'])->get();			
		} else {
			$players = Player::get();
		}
		
		$columns = ["Name","Birthdate","Club"];
		
		echo "Name;Birthdate;Club\n";
		
		if ($players){
			foreach ($players as $player){
				echo $player->name . ";";
				echo $player->birthdate . ";";
				echo $player->club->name . "\n";
				// fputcsv($file, [$player->name, $player->birthdate, $player->club->name]);
			}
		}
	}
}
