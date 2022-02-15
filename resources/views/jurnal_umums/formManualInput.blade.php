<div class="panel panel-info">
	<div class="panel-heading">
		<div class="panel-title">Input Jurnal Umum Baru</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Coa</th>
								<th>Debit</th>
								<th>Kredit</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id='result'>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
				<div class="form-group @if($errors->has('coa_id'))has-error @endif">
					{!! Form::label('coa_id', 'Coa', ['class' => 'control-label']) !!}
					{!! Form::select('coa_id', App\Models\Coa::list(), null, array(
						'class'            => 'form-control selectpick rq',
						'id'               => 'coa_id',
						'data-live-search' => 'true'

					))!!}
				  @if($errors->has('coa_id'))<code>{{ $errors->first('coa_id') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group @if($errors->has('nilai'))has-error @endif">
					{!! Form::label('nilai', 'Nilai', ['class' => 'control-label']) !!}
					{!! Form::text('nilai', null, array(
						'class' => 'form-control uangInput rq',
						'id'    => 'nilai'
					))!!}
				  @if($errors->has('nilai'))<code>{{ $errors->first('nilai') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group @if($errors->has('debit'))has-error @endif">
					{!! Form::label('debit', 'Debit/Kredit', ['class' => 'control-label']) !!}
					{!! Form::select('debit', App\JurnalUmum::debitKredit(), null, array(
						'class' => 'form-control rq',
						'onchange' => 'validateView();return false;',
						'id'    => 'debit'
					))!!}
				  @if($errors->has('debit'))<code>{{ $errors->first('debit') }}</code>@endif
				</div>
			</div>
		</div>
	</div>
</div>
