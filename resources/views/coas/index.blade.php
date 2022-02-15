@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Chart Of Account

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
				<div class="panelRight">
					<a href="{{ url('coas/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Buat COA Baru</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed DTa">
						<thead>
							<tr>
								<th>Coa Id</th>
								<th>Chart Of Account</th>
								<th>Kelompok Coa</th>
								<th>Saldo Awal</th>
								<th>Details</th>
								<th>Edit</th>
							</tr>
						</thead>
						<tbody>
							@foreach($coas as $coa)
								<tr>
									<td>{{ $coa->id }}</td>
									<td>{{ $coa->coa }}</td>
									<td>{{ $coa->kelompokCoa->kelompok_coa }}</td>
									<td class="uang">{{ $coa->saldo_awal }}</td>
									<td><a class="btn-sm btn-info btn-block" href="{{ url('coas/' . $coa->id ) }}">Details</a></td>
									<td> <a class="btn-sm btn-primary btn-block"  href="{{ url('coas/' . $coa->id . '/edit') }}">Edit</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Kelompok Coa</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>ID</th>
								<th>Kelompok Coa</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if($kelompokCoa->count() > 0)
								@foreach($kelompokCoa as $kel)
									<tr>
										<td>{{ $kel->id }}</td>
										<td>{{ $kel->kelompok_coa }}</td>
										<td></td>
									</tr>
								@endforeach
							@else
								<tr>
									<td class="text-center" colspan="">Tidak Ada Data Untuk Ditampilkan :p</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		
	</div>
</div>


@stop
@section('footer') 
	
@stop
