@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
	    <div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title">Edit Club</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">	
				<form method="post" action="<?php echo route('clubsPostEdit',[$club->id]) ?>">
					@csrf
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $club->name }}">
					</div>
					<div class="form-group">
						<label for="short_name">Short Name</label>
						<input type="text" class="form-control" name="short_name" id="short_name" placeholder="Short Name" maxlength="3" value="{{ $club->short_name }}">
					</div>
					<div class="form-group">
						<label for="ground">Ground</label>
						<input type="text" class="form-control" name="ground" id="ground" placeholder="Ground" value="{{ $club->ground }}">
					</div>
					<div class="form-group">
						<label for="founded">Founded</label>
						<input type="text" class="form-control input-date" name="founded" id="founded" placeholder="Founded" value="{{ $club->founded }}">
					</div>
				  <button type="submit" class="btn btn-primary">Edit</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection