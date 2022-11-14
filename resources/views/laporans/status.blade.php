@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Laporan Pemeriksaan

@stop
@section('page-title') 
<h2>Laporan Pemeriksaan</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Pemeriksaan</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $periksas->total() !!}</h3>
                </div>
                <div class="panelRight">
                   <a href="" type="button" class="btn btn-danger" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Sangat Rahasia</a>

                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
					<table class="table table-bordered" id="tableAsuransi">
					  <thead>
						<tr>
						  <th>No</th>
							<th>Tanggal</th>
							<th>Pemeriksaan</th>
						  <th>Terapi</th>
							<!--<th>Action</th>-->
						</tr>
					</thead>
					<tbody>
					  @if($periksas->count() > 0)
						 @foreach ($periksas as $key => $periksa)
						<tr>
						  <td>
							{!! $key + 1!!}
						  </td>
						  <td>
							{!! App\Models\Classes\Yoga::updateDatePrep($periksa->tanggal) !!} <br>
							<br>Umur :
							{!! App\Models\Classes\Yoga::datediff($periksa->pasien->tanggal_lahir->format('Y-m-d'), date('Y-m-d'))!!}
							<br>Pembayaran : 
							{!! $periksa->asuransi->nama !!}
						  </td>
						  <td>
							{!! $periksa->staf->nama !!} <br>
							<strong>{!! $periksa->id !!}</strong> <br><br>
							  <strong>Nama :</strong> <br>
							  {!! $periksa->pasien->nama !!} <br>
							  <strong>Anamnesa :</strong> <br>
							  {!! $periksa->anamnesa !!} <br>
							  <strong>Pemeriksaan Fisik, Penunjang dan Tindakan :</strong> <br>
							  {!! $periksa->pemeriksaan_fisik !!} <br>
							  {!! $periksa->pemeriksaan_penunjang !!}<br>
							  {{-- <h3> --}}
								 {{-- Transaksi --}} 
							  {{-- </h3> --}}
							  {{-- <table class="table table-bordered table-hover table-condensed "> --}}
								  {{-- <thead> --}}
									  {{-- <tr> --}}
										  {{-- <th colspan="2">Jenis Tarif</th> --}}
										  {{-- <th>Biaya</th> --}}
									  {{-- </tr> --}}
								  {{-- </thead> --}}
								  {{-- <tbody> --}}
									  {{-- {!! $periksa->tindakan_html !!} --}}
								  {{-- </tbody> --}}
								  {{-- <tfoot> --}}
									  {{-- <tr> --}}
										  {{-- <th colspan="2">Total</th> --}}
										  {{-- <th>{!! $periksa->total_transaksi !!}</th> --}}
									  {{-- </tr> --}}
								  {{-- </tfoot> --}}
							  {{-- </table> --}}
						  </td>
						  <td>
							<div class="row">
							  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<strong>Pembayaran :</strong> <br>
								{!! $periksa->asuransi->nama !!} <br><br>
							  </div>
							  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							  <strong>Diagnosa :</strong> <br>
								  @if($periksa->diagnosa_id)
									{!! $periksa->diagnosa->diagnosa !!} - {!! $periksa->diagnosa->icd10->diagnosaICD !!} <br>
									{!! $periksa->keterangan_diagnosa !!}
								  @else
									{!! $periksa->keterangan_diagnosa !!}
								  @endif
							  </div>
							</div>
							{!! $periksa->terapi_html !!}
							{{-- <div> --}}
							{{-- 	<h3>Jurnal Umum</h3> --}}
							{{-- 	<table class="table borderless table-condensed"> --}}
							{{-- 		<thead> --}}
							{{-- 			<tr> --}}
							{{-- 				<th>Akun </th> --}}
							{{-- 				<th>Debet</th> --}}
							{{-- 				<th>Kredit</th> --}}
							{{-- 			</tr> --}}
							{{-- 		</thead> --}}
							{{-- 		<tbody> --}}
							{{-- 			  @if (count($periksa->jurnals) > 0) --}}
							{{-- 				@foreach($periksa->jurnals as $k=>$jur) --}}
							{{-- 					@if($jur->debit == 1) --}}
							{{-- 					   <tr> --}}
							{{-- 						   <td>{!! $jur->coa->coa !!}</td> --}}
							{{-- 						   <td class="uang">{!! $jur->nilai!!}</td> --}}
							{{-- 						   <td></td> --}}
							{{-- 					   </tr> --}} 
							{{-- 					   @else --}}
							{{-- 						<tr> --}}
							{{-- 						   <td class="text-right">{!! $jur->coa->coa !!}</td> --}}
							{{-- 						   <td></td> --}}
							{{-- 						   <td class="uang">{!! $jur->nilai!!}</td> --}}
							{{-- 						</tr> --}}
							{{-- 					@endif --}}
												
							{{-- 				@endforeach --}}
							{{-- 			  @else --}}
							{{-- 				<tr> --}}
							{{-- 				  <td colspan="7" class="text-center">Tidak ada Data Untuk Ditampilkan :p</td> --}}
							{{-- 				</tr> --}}
							{{-- 			  @endif --}}
							{{-- 		</tbody> --}}
							{{-- 	</table> --}}
							{{-- </div> --}}
						  </td>
						  <!--<td>-->
							<!--<button type="button" class="btn btn-default btn-block"><i class="fa fa-question" onclick="unchecked(this)"></i></button>-->
							<!--<button type="button" class="btn btn-danger btn-block"><i class="fa fa-warning" onclick="koreksi(this)"></i></button>-->
							<!--<button type="button" class="btn btn-success btn-block"><i class="fa fa-check" onclick="betul(this)"></i></button>-->
							<!--<button type="button" class="btn btn-primary btn-block"><i class="fa fa-thumbs-o-up" onclick="sop(this)"></i></button>-->
						  <!--</td>-->
						</tr>
					   @endforeach
					   @else
						<tr>
						  <td colspan='4' class="text-center"> Tidak ada data untuk ditampilkan :P </td>
						</tr>
					   @endif
					</tbody>
				</table>
		  </div>
            <?php echo $periksas->appends(Input::except('page'))->links(); ?>
      </div>
</div>
@include('obat')
@stop
@section('footer') 
<script>
  var base = "{{ url('/') }}";
</script>
{!! HTML::script('js/informasi_obat.js')!!} 
	
@stop
