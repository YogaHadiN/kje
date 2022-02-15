@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Daftar Peralatan

@stop
@section('page-title') 
<h2>Daftar Peralatan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Daftar Peralatan</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-info">
				  <div class="panel-body">
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#peralatan" aria-controls="peralatan" role="tab" data-toggle="tab">Peralatan</a></li>
    <li role="presentation"><a href="#bahan_bangunan" aria-controls="bahan_bangunan" role="tab" data-toggle="tab">Bahan Bangunan</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="peralatan">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Peralatan</th>
						<th>Masa Pakai</th>
						<th>Harga Peroleh</th>
						<th>Penyusutan</th>
						<th>Petugas</th>
					</tr>
				</thead>
				<tbody>
					@if(count( $peralatans ))
						@foreach($peralatans as $p)
							<tr>
								<td>{{ $p->tanggal }}</td>
								<td>{{ $p->peralatan }} <br /> {{ $p->jumlah }} unit </td>
								<td>{{ $p->masa_pakai }} tahun</td>
								<td class="uang">{{ $p->harga_satuan * $p->jumlah }}</td>
								<td class="uang">{{ $p->penyusutan }}</td>
								<td>{{ $p->nama }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td class="text-center" colspan="8">Tidak Ada Data Untuk Ditampilkan :p</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
</div>
    <div role="tabpanel" class="tab-pane" id="bahan_bangunan">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Peralatan</th>
						{{-- <th>Masa Pakai</th> --}}
						<th>Harga Peroleh</th>
						<th>Penyusutan</th>
						<th>Petugas sssss</th>
					</tr>
				</thead>
				<tbody>
					@if(count( $bahan_bangunans ))
						@foreach($bahan_bangunans as $p)
							<tr>
								<td>{{ $p->tanggal }}</td>
								<td>{{ $p->peralatan }} <br /> {{ $p->jumlah }} unit </td>
								{{-- <td>{{ $p->masa_pakai }} tahun</td> --}}
								<td class="uang">{{ $p->harga_satuan * $p->jumlah }}</td>
								<td class="uang">{{ $p->penyusutan }}</td>
								<td>{{ $p->nama }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td class="text-center" colspan="8">Tidak Ada Data Untuk Ditampilkan :p</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
</div>
  </div>

</div>
				  </div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	@if( Session::has('print') )
		<script type="text/javascript" charset="utf-8">
			var base = "{{ url('/') }}";
			window.open(base + "/pdfs/pembelian/{!! Session::get('print') !!}");
		</script>	
	@endif
@stop
