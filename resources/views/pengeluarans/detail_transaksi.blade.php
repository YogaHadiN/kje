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
							<th>Informasi</th>
						  <th>Jurnal Umum</th>
							<!--<th>Action</th>-->
						</tr>
					</thead>
					<tbody>

					  @if($periksas->count() > 0)

						 @foreach ($periksas as $key => $periksa)
						
						<tr>
						  <td>
							  <div class="row">
								  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							{!! App\Models\Classes\Yoga::updateDatePrep($periksa->tanggal) !!} <br>
							<br>Umur :
							{!! App\Models\Classes\Yoga::datediff($periksa->pasien->tanggal_lahir->format('Y-m-d'), date('Y-m-d'))!!}
							<br>Pembayaran : 
							{!! $periksa->asuransi->nama !!}
							<br>Staf :
							{!! $periksa->staf->nama !!} <br>
							<strong>{!! $periksa->id !!}</strong> <br>
							  </div>
							  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							  <strong>Diagnosa :</strong> <br>
								  @if($periksa->diagnosa_id)

									{!! $periksa->diagnosa->diagnosa !!} - {!! $periksa->diagnosa->icd10->diagnosaICD !!} <br>
									{!! $periksa->keterangan_diagnosa !!}

								  @else
									{!! $periksa->keterangan_diagnosa !!}
								  @endif
								  <br>
								<strong>Pembayaran :</strong> <br>
								{!! $periksa->asuransi->nama !!} <br>
								<br>
							  </div>
							</div>
							  <table class="table table-bordered table-hover table-condensed ">
								  <thead>
									  <tr>
										  <th colspan="2">Jenis Tarif</th>
										  <th>Biaya</th>
									  </tr>
								  </thead>
								  <tbody>
									  {!! $periksa->tindakan_html !!}
								  </tbody>
								  <tfoot>
									  <tr>
										  <th colspan="2">Total</th>
										  <th>{!! $periksa->total_transaksi !!}</th>
									  </tr>
								  </tfoot>
								  
							  </table>
						  </td>
						  <td>
							<div>
								@include('periksas.jurnals')
							</div>
						  </td>
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

