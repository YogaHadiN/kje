	@extends('layout.master')

	@section('title') 
	Klinik Jati Elok | Home Visit

	@stop
	@section('page-title') 
	<h2>Home Visit</h2>
	<ol class="breadcrumb">
		  <li>
			  <a href="{{ url('laporans')}}">Home</a>
		  </li>
		  <li class="active">
			  <strong>Home Visit</strong>
		  </li>
	</ol>

	@stop
	@section('content') 
		<div class="panelRight">
			<a href="{{ url('home_visits/create') }}" class="btn btn-primary"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create </a>
		</div>
		<br>
			<div class="table-responsive">
				<div class="row">
					<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
						Menampilkan <span id="rows"></span> hasil
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
						{!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
							'class' => 'form-control',
							'onchange' => 'clearAndSelect();return false;',
							'id'    => 'displayed_rows'
						]) !!}
					</div>
				</div>
		</br>
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>
								Tanggal <br>
								{!! Form::text('tanggal', null, ['class' => 'form-control', 'id' => 'tanggal']) !!}
							</th>
							<th>
								Nama Pasien <br>
								{!! Form::text('nama', null, ['class' => 'form-control', 'id' => 'nama']) !!}
							</th>
							<th>
								Nomor BPJS <br>
								{!! Form::text('nomor_asuransi_bpjs', null, ['class' => 'form-control', 'id' => 'nomor_asuransi_bpjs']) !!}
							</th>
							<th>Tekanan Darah</th>
							<th>Berat Badan</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="ajax_container"></tbody>
				</table>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div id="page-box">
							<nav class="text-right" aria-label="Page navigation" id="paging">
							
							</nav>
						</div>
					</div>
				</div>
			</div>
	@stop
	@section('footer') 
			<script src="{!! url('js/twbs-pagination/jquery.twbsPagination.min.js') !!}"></script>
			{!! HTML::script('js/home_visit.js')!!}
	@stop
