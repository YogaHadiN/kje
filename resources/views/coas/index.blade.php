@extends('layout.master')

@section('title') 
Klinik Jati Elok | Chart Of Account

@stop
@section('page-title') 
<h2>List Semua Chart Of Account</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Chart Of Account</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panelLeft">
					<h3>Chart Of Account</h3>
				</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<?php echo $coas->appends(Input::except('page'))->links(); ?>
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Coa Id</th>
								<th>Chart Of Account</th>
								<th>Kelompok Coa Id</th>
								<th>Kelompok Coa</th>
								<th colspan="2">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($coas as $coa)
								<tr>
									<td>{{ $coa->id }}</td>
									<td>{{ $coa->coa }}</td>
									<td>{{ $coa->kelompok_coa_id }}</td>
									<td>{{ $coa->kelompokCoa->kelompok_coa }}</td>
									<td> <a class="btn-sm btn-info btn-block" href="#">Details</a>	</td>
									<td> <a class="btn-sm btn-primary btn-block" href="#">Edit</a>	</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<?php echo $coas->appends(Input::except('page'))->links(); ?>
				</div>
				
			</div>
		</div>
		
	</div>
	
</div>



@stop
@section('footer') 
	
@stop
