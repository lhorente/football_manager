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
						<select class="form-control" name="club_id" id="select-club">
							<option value="">All Clubs</option>
							<?php foreach ($clubs as $club){ ?>
								<option value="<?php echo $club->id ?>"><?php echo $club->name ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group" id="form-froup-email" style="display:none;">
						<label for="email">Email</label>
						<input type="text" class="form-control" name="email" id="email" placeholder="Email que irá receber o XML para download">
					</div>
				  <button type="submit" class="btn btn-primary" id="btn-export">Download CSV</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection