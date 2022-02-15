<div class="row soft-padding">
	<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
		@if($picker)
			{!! Form::select('generik_id[]', $generik_pluck, null ,['class' => 'form-control selectpick', 'onchange' => 'generikChange(this)', 'data-live-search' => 'true'])!!}
		@else
			{!! Form::select('generik_id[]', $generik_pluck, null ,['class' => 'form-control',  'onchange' => 'generikChange(this)','data-live-search' => 'true'])!!}
		@endif
	</div>
	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		<button class="btn btn-warning btn-block disabled" type="button" onclick="tambahAlergi(this)">  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
	</div>
	<br />
</div>
