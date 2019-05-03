@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
	    <div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title">Export Players</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">	
				<form method="post" action="{{ route('playersPostExport') }}">
					@csrf
					<div class="form-group">
						<label for="club">Club</label>
						<select class="form-control" name="club_id">
							<option value="">All Clubs</option>
							<?php foreach ($clubs as $club){ ?>
								<option value="<?php echo $club->id ?>"><?php echo $club->name ?></option>
							<?php } ?>
						</select>
					</div>

				  <button type="submit" class="btn btn-primary">Export CSV</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection