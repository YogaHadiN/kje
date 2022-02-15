@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Promo KTP Per Tahun

@stop
@section('page-title') 
<h2>Promo KTP Per Tahun</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Promo KTP Per Tahun</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Daftar KTP Promo Terdaftar</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>id</th>
									<th>NO KTP</th>
									<th>Nama Pasien</th>
									<th>Poli</th>
									<th>Tahun</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if($promos->count() > 0)
									@foreach($promos as $p)
										<tr>
											<td>{{ $p->id }}</td>
											<td>{{ $p->no_ktp }}</td>
											<td>{{ $p->periksa->pasien->nama }}</td>
											<td>{{ $p->periksa->poli }}</td>
											<td>{{ $p->tahun }}</td>
											<td> <a class="btn btn-info btn-xs" href="{{ url('discounts/promo/' . $p->id) }}">Detail</a> </td>
										</tr>
									@endforeach
								@else
									<tr>
										<td class="text-center" colspan="6">Tidak Ada Data Untuk Ditampilkan :p</td>
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
	
			<script type="text/javascript" charset="utf-8">
				function dummySubmit(){
					if(validatePass()){
						$('#submit').click();
					}
				}
			</script>
@stop

