@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
	    <div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title">Clubs</h3>
			  
				<div class="box-tools pull-right">
					<a type="button" class="btn btn-primary" href="<?php echo url('clubs/create') ?>">Add New Club</a>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">	
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Founded</th>
							<th>Short Name</th>
							<th>Ground</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($clubs as $club){ ?>
						<tr>
							<td><?php echo $club->name ?></td>
							<td><?php echo $club->founded ?></td>
							<td><?php echo $club->short_name ?></td>
							<td><?php echo $club->ground ?></td>
							<td>
								<a href="<?php echo route('clubsViewPlayers',[$club->id]) ?>">List Players</a>
							</td>
							<td>
								<a href="<?php echo url('clubs/edit/'.$club->id) ?>">Edit</a>
							</td>
							<td>
								<a href="<?php echo url('clubs/remove/'.$club->id) ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Delete</a>
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