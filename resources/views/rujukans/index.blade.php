@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Rujukans

@stop
@section('page-title') 
 <h2>Laporan Rujukan</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Rujukan</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Rujukan</h3>
                </div>
                <div class="panelRight">
                    <h3>Total : {!! $count !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <?php echo $rujukans->appends(Input::except('page'))->links(); ?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>id periksa</th>
							<th>Nama Pasien</th>
							<th>Diagnosa</th>
							<th>Rujukan Kepada</th>
							<th>Pembayaran</th>
							<th>Rumah Sakit</th>
							<th>Alasan Dirujuk</th>
						</tr>
					</thead>
					<tbody>
					@if($rujukans->count() > 0)
						@foreach($rujukans as $rujukan)
							   <tr>
								   <td>{!! App\Models\Classes\Yoga::updateDatePrep($rujukan->periksa->tanggal) !!}</td>
								   <td>
									@if(isset($rujukan->periksa->pasien->nama))
									{!! $rujukan->periksa->pasien->nama !!}
									@endif
								   </td>
								   <td>
									@if(isset($rujukan->periksa->diagnosa->diagnosa))
									{!! $rujukan->periksa->diagnosa->diagnosa!!} 
									@endif
									- 
									@if(isset( $rujukan->periksa->diagnosa->icd10->diagnosaICD))
									{!! $rujukan->periksa->diagnosa->icd10->diagnosaICD!!}</td>
									@endif
								   <td>{!! $rujukan->tujuanRujuk->tujuan_rujuk !!}</td>
								   <td>{!! $rujukan->periksa->asuransi->nama !!}</td>
								   <td>
									@if(isset( $rujukan->rumahSakit->nama ))
									{!! $rujukan->rumahSakit->nama !!}</td>
									@endif
								   <td>{!! $rujukan->complication !!}</td>
							   </tr>
						@endforeach
					@else
						<tr>
							<td colspan="5" class="text-center">Tidak ada data untuk ditampilkan :p</td>
						</tr>
					@endif
					</tbody>
				</table>
			</div>
            <?php echo $rujukans->appends(Input::except('page'))->links(); ?>

      </div>
</div>
@stop
@section('footer') 


@stop
