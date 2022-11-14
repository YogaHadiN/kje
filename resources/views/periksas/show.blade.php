@extends('layout.master')
@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Pasien

@stop
@section('page-title') 

 <h2>Semua Pemeriksaan</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Semua Pemeriksaan</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Nama Pasien : {!!$periksa->pasien->id!!} - {!!$periksa->pasien->nama!!}</h3>
                </div>
                <div class="panelRight">
					<a class="btn btn-lg btn-warning " href="{{ url('periksas/' .$periksa->id . '/edit/transaksiPeriksa') }}">
						Edit
					</a>
				</div>
            </div>
      </div>
      <div class="panel-body">
		  @include('periksas.status')
      </div>
</div>

<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<div class="panel-title">
					<div class="panelLeft">
						Jurnal Umum
					</div>	
					<div class="panelRight">
					</div>
				</div>
			</div>
			<div class="panel-body">
				@include('periksas.jurnals')
			</div>
		</div>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		@include('periksas.showForm')
	</div>
</div>
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Rincian obat</h3>
  </div>
  <div class="panel-body">
	  <div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="tableAsuransi">
			  <thead>
				<tr>
				  <th>ID</th>
				  <th>Merek Obat</th>
				  <th>harga beli</th>
				  <th>harga jual</th>
				  <th>jumlah</th>
				  <th>Modal</th>
				  <th>Bruto</th>
				  <th>Untung</th>
				</tr>
			</thead>
			<tbody>
			   @foreach ($periksa->terapii as $terapi)
				 <tr>
					<td>
					  {!! $terapi->id !!}
					</td>
					<td>
					 {!! $terapi->merek_id !!} - {!! $terapi->merek->merek !!}
					</td>
					<td class="uang">
					  {!! $terapi->harga_beli_satuan !!}
					</td>
					<td class="uang">
					  {!! $terapi->harga_jual_satuan !!}
					</td>
					<td>
					  {!! $terapi->jumlah !!}
					</td>
					<td class="uang">
					  {!! $terapi->jumlah * $terapi->harga_beli_satuan !!}
					</td>
					<td class="uang">
					  {!! $terapi->jumlah * $terapi->harga_jual_satuan !!}
					</td>
					<td class="uang">
					  {!! $terapi->jumlah * $terapi->harga_jual_satuan - $terapi->jumlah * $terapi->harga_beli_satuan !!}
					</td>
				 </tr>
			   @endforeach
			</tbody>
			<tfoot>
			  <tr>
				<th colspan="5">Total :</th>
				<td class="uang">{!! $periksa->terapi_modal !!}</td>
				<td class="uang">{!! $periksa->terapi_bruto !!}</td>
				<td class="uang">{!! $periksa->terapi_untung !!}</td>
			  </tr>
			</tfoot>
		</table>
	  </div>
  </div>
</div>
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">
					<div class="panelLeft">
						Pembayaran
					</div>	
					<div class="panelRight">
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Id</th>
								<th>Tanggal Dibayar</th>
								<th>Staf</th>
								<th>Tanggal Input</th>
								<th>Dibayar ke</th>
								<th>Jumlah Pembayaran</th>
							</tr>
						</thead>
						<tbody>
							@if($periksa->pembayarans->count() > 0)
								@foreach($periksa->pembayarans as $pa)
									<tr>
										<td>{{ $pa->pembayaran_asuransi_id }}</td>

										<td>{{ date('d M y', strtotime( $pa->pembayaranAsuransi->tanggal_dibayar )) }}</td>
										<td>{{ $pa->pembayaranAsuransi->staf->nama }}</td>
										<td>{{ date('d M y', strtotime( $pa->created_at )) }}</td>
										<td>{{ $pa->pembayaranAsuransi->coa->coa }}</td>
										<td class="text-right"> 
											<a class="" href="{{ url('pembayaran_asuransis/' . $pa->pembayaran_asuransi_id) }}">
												{{ App\Models\Classes\Yoga::buatrp( $pa->pembayaran ) }}
											</a>
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="6" class="text-center">Tidak ada data untuk ditampilkan</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>



@include('obat')
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
	var base = '{{ url("/") }}';
</script>
	{!! HTML::script('js/show_periksa.js') !!}
	{!! HTML::script('js/informasi_obat.js') !!}
@stop
