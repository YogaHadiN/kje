@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Riwayat Pasien

@stop
@section('page-title') 
<h2>List Semua Asuransi</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('pasiens')}}">Pasien</a>
      </li>
      <li class="active">
          <strong>Riwayat Pemeriksaan</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : </h3>
                </div>
                <div class="panelRight">
                   <a href="" type="button" class="btn btn-danger" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Sangat Rahasia</a>

                </div>
            </div>
      </div>
      <div class="panel-body">
            <?php echo $periksas->appends(Input::except('page'))->links(); ?>
			<div class="table-responsive">
					<table class="table table-bordered table-hover" id="tableAsuransi">
					  <thead>
						<tr>
						  <th>Tanggal</th>
						  <th>Pemeriksaan</th>
						  <th>Terapi</th>
						</tr>
					</thead>
					<tbody>
					   @foreach ($periksas as $periksa)
						
						<tr>
						  <td>
							{!! App\Models\Classes\Yoga::updateDatePrep($periksa->tanggal) !!} <br>
							{!! $periksa->pasien->nama !!}
							 <br> <strong>{!! App\Models\Classes\Yoga::datediff($periksa->pasien->tanggal_lahir, $periksa->tanggal);!!}</strong><br><br>
							Pemeriksa : <br>
							@if($periksa->staf)
							  <strong>{!! $periksa->staf->nama !!}</strong> <br><br>
							@endif
							Pembayaran : <br>
							<strong>{!! $periksa->asuransi->nama!!}</strong><br><br>
						  </td>
						  <td>
							  <strong>Anamnesa : {!! $periksa->id !!}</strong> <br>
							  {!! $periksa->anamnesa !!} <br>
							  <strong>Pemeriksaan Fisik, Penunjang dan Tindakan :</strong> <br>
							  {!! $periksa->pemeriksaan_fisik !!} <br>
							  {!! $periksa->pemeriksaan_penunjang !!}<br>
							  <strong>Diagnosa :</strong> <br>
							  @if($periksa->diagnosa_id != '')
							  {!! $periksa->diagnosa->diagnosa !!} - {!! $periksa->diagnosa->icd10->diagnosaICD !!} <br>
							  <strong>ICD : </strong> {!! $periksa->diagnosa->icd10_id !!} <strong>Admedika </strong>: {!! $periksa->diagnosa->icd10->admedika !!}
							  @else
							  {!! $periksa->keterangan_diagnosa !!}
							  @endif
							  <br><br>

							@if($periksa->usg)
							
							<a href="{{ url('usgs/' . $periksa->id) }}" class="btn btn-primary">Hasil USG</a>
							@endif
							@if($periksa->registerAnc)
							<a href="{{ url('ancs/' . $periksa->id) }}" class="btn btn-info">Hasil ANC</a>
							@endif
							<br>

							  @if($periksa->suratSakit)
							  <hr>
								<div class="alert alert-success">
								  {!! App\Models\Classes\Yoga::suratSakit($periksa) !!}
								</div>
							  @endif
						  </td>
						  <td>
							{!! $periksa->terapi_html !!}

							  @if($periksa->rujukan)
							  <hr>
								<div class="alert alert-warning">
								  dirujuk ke {!! $periksa->rujukan->tujuanRujuk->tujuan_rujuk !!} <br>
								  karena {!!$periksa->rujukan->complication !!} <br>
                                  @if($periksa->asuransi->tipe_asuransi_id == '5')
								  <a href="{{ url('rujukans/' . $periksa->id ) }}" class="btn btn-success">Lihat Rujukan</a>
								  @else
									<a href="{{ url('pdfs/status/' . $periksa->id ) }}" target="_blank" class="btn btn-success">Lihat Rujukan</a>

								  @endif
								</div>
							  @endif

						  </td>
						</tr>
					   @endforeach
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
