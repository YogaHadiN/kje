@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pasien

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
                <div class="panelRight"></div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover" id="tableAsuransi">
                  <thead>
                    <tr>
                    	<th>Tanggal</th>
                    	<th>Status</th>
                    	<th>Terapi</th>
                    </tr>
                </thead>
                <tbody>
            		 <tr>
                            <td rowspan="2">
                                {!! $periksa->tanggal !!} <br><br>
                                <strong>Pemeriksa :</strong><br> 
                                {!! $periksa->staf->nama !!} <br><br>
                                <strong>Pembayaran</strong> <br>
                                {!! $periksa->asuransi->nama !!} <br><br>
                                <strong>Jam Datang</strong> <br>
                                {!! $periksa->jam !!} <br><br>
                                <strong>Periksa id</strong> <br>
                                {!! $periksa->id !!}
                            </td>
                            <td>
                                <strong>Anamnesa :</strong> <br>
                                {!! $periksa->anamnesa !!} <br>
                                <strong>Pemeriksaan Fisik, Penunjang dan Tindakan :</strong> <br>
                                {!! $periksa->pemeriksaan_fisik !!} <br>
                                {!! $periksa->pemeriksaan_penunjang !!}<br>
                                <strong>Diagnosa :</strong> <br>
                                {!! $periksa->diagnosa->diagnosa !!} - {!! $periksa->diagnosa->icd10->diagnosaICD !!}
                                <br> <br>
                                <div class="row">
                                    @if($periksa->usg)
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <a href="{{ url('usgs/' . $periksa->id) }}" class="btn btn-primary btn-block">Hasil USG</a>
                                        </div>
                                    @endif
                                    @if($periksa->registerAnc)
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <a href="{{ url('ancs/' . $periksa->id) }}" class="btn btn-info btn-block">Hasil ANC</a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>{!! $periksa->terapi_html !!}</td>
                        </tr>
                        <tr>
                            <td>
                              <h2>Transaksi : </h2>
                              <table class="table table-condensed">
                                <tbody>
                                  {!! $periksa->tindakan_html !!}
                                </tbody>
                                <tfoot>
                                  <tr class="b-top-bold-big">
                                    <td>Total Baiya Transaksi </td>
                                    <td>:</td>
                                    <td  class="text-right">{!! $periksa->total_transaksi !!}</td>
                                  </tr>
                                </tfoot>
                              </table>
                            </td>
                            <td>
                                <h2>Transaksi</h2>
                                 <table class="table table-condensed">
                                  <tbody>
                                    <tr>
                                      <td>Pembayaran tunai</td>
                                      <td class="uang">{!! $periksa->tunai !!}</td>
                                    </tr>
                                    <tr>
                                      <td>Pembayaran Piutang</td>
                                      <td class="uang">{!! $periksa->piutang !!}</td>
                                    </tr>
                                  </tbody>
                                </table>

                            </td>
                        </tr>
                </tbody>
            </table>
      </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Rincian obat</h3>
  </div>
  <div class="panel-body">
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


@include('obat')
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
var base = '{{ url("/") }}';
</script>
	{!! HTML::script('js/informasi_obat.js') !!}
@stop
