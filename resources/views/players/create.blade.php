@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
	    <div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title">Add New Player</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">	
				<form method="post" action="{{ url('players/create') }}">
					@csrf
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Name">
					</div>
					<div class="form-group">
						<label for="birthdate">Birthdate</label>
						<input type="text" class="form-control input-date" name="birthdate" id="birthdate" placeholder="Birthdate">
					</div>
					<div class="form-group">
						<label for="club">Club</label>
						<select class="form-control" name="club_id">
							<option value="">Club</option>
							<?php foreach ($clubs as $club){ ?>
								<option value="<?php echo $club->id ?>"><?php echo $club->name ?></option>
							<?php } ?>
						</select>
					</div>

				  <button type="submit" class="btn btn-primary">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection