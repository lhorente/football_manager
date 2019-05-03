@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
	    <div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title">Players</h3>
			  
				<div class="box-tools pull-right">
					<a type="button" class="btn btn-primary" href="<?php echo url('players/create') ?>">Add New Player</a>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">	
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Birthdate</th>
							<th>Club</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($players as $player){ ?>
						<tr>
							<td><?php echo $player->name ?></td>
							<td><?php echo $player->birthdate ?></td>
							<td><?php echo $player->club->name ?></td>
							<td>
								<a href="<?php echo url('players/edit/'.$player->id) ?>">Edit</a>
							</td>
							<td>
								<a href="<?php echo url('players/remove/'.$player->id) ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Delete</a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection