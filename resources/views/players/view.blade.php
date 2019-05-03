@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
	    <div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title">Edit Player</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">	
				<form method="post" action="<?php route('playersPostEdit',[$player->id]) ?>">
					@csrf
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $player->name }}">
					</div>
					<div class="form-group">
						<label for="birthdate">Birthdate</label>
						<input type="text" class="form-control input-date" name="birthdate" id="birthdate" placeholder="Birthdate" value="{{ $player->birthdate }}">
					</div>
					<div class="form-group">
						<label for="club">Club</label>
						<select class="form-control" name="club_id">
							<option value="">Club</option>
							<?php foreach ($clubs as $club){
								$selected = "";
								if ($player->club_id == $club->id){
									$selected = "selected";
								}
								?>
								<option value="<?php echo $club->id ?>" <?php echo $selected ?>><?php echo $club->name ?></option>
							<?php } ?>
						</select>
					</div>

				  <button type="submit" class="btn btn-primary">Edit</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection