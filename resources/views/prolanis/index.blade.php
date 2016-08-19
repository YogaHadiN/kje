@extends('layout.master')

@section('title') 
Klinik Jati Elok | Data Pasien Prolanis BPJS

@stop
@section('page-title') 
<h2>Data Pasien Prolanis BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Data Pasien Prolanis BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 
<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">Diabetes</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="table-responsive">
						<table class="table table-hover table-bordered table-condensed DTa">
							<thead>
								<tr>
									<th>Nomor Pasien</th>
									<th>Nama Pasien</th>
									<th>Tekanan Darah</th>
									<th>Rata Tensi</th>
									<th>Ada DM</th>
									<th>No HP</th>
									<th>Riwayat GDS</th>
									<th>Action</th>

								</tr>
							</thead>
							<tbody>
								@if(count($prolanis) > 0)
									@foreach($prolanis as $pro)
										<tr>
											<td>{{ $pro->id }}</td>
											<td>{{ $pro->nama }}</td>
											<td>{!! $pro->tensis !!}</td>
											<td>{{ $pro->ratatensi }}</td>
											<td>{{ $pro->adadm }}</td>
											<td>{{ $pro->no_telp }}</td>
											<td>{!! $pro->riwgds !!}</td>
											<td> <a class="btn btn-info btn-xs btn-block" href="{{ url('pasiens/' . $pro->id) }}">detail</a> </td>
										</tr>
									@endforeach
								@else
									<tr>
										<td class="text-center" colspan="4">Tidak Ada Data Untuk Ditampilkan :p</td>
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

