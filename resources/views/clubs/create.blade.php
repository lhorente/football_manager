@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
	    <div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title">Add New Club</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">	
				<form method="post" action="{{ url('clubs/create') }}">
					@csrf
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Name">
					</div>
					<div class="form-group">
						<label for="short_name">Short Name</label>
						<input type="text" class="form-control" name="short_name" id="short_name" placeholder="Short Name" maxlength="3">
					</div>
					<div class="form-group">
						<label for="ground">Ground</label>
						<input type="text" class="form-control" name="ground" id="ground" placeholder="Ground">
					</div>
					<div class="form-group">
						<label for="founded">Founded</label>
						<input type="text" class="form-control input-date" name="founded" id="founded" placeholder="Founded">
					</div>
				  <button type="submit" class="btn btn-primary">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection