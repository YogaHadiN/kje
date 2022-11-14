@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | rujukans

@stop
@section('page-title') 
 <h2>List User</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>List Rujukan</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $rujukans->count() !!}</h3>
                </div>
                <div class="panelRight">
                  <h3>Tanggal : {!! App\Models\Classes\Yoga::updateDatePrep($mulai) !!} s/d {!! App\Models\Classes\Yoga::updateDatePrep($akhir) !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>tanggal</th>
							<th>pemeriksa</th>
							<th>diagnosa</th>
							<th>pembayaran</th>
							<th>rumah sakit</th>
							<th>spesialis</th>
							<th>ID PERIKSA</th>
						</tr>
					</thead>
					<tbody>
						@foreach($rujukans as $rujukan)
							<tr>
								<td>{!!App\Models\Classes\Yoga::updateDatePrep($rujukan->periksa->tanggal)!!}</td>
								<td>{!!$rujukan->periksa->staf->nama!!}</td>
								<td>{!!$rujukan->periksa->asuransi->nama!!}</td>
								<td>{!!$rujukan->periksa->diagnosa->diagnosa!!} - {!!$rujukan->periksa->diagnosa->icd10->diagnosaICD!!}</td>
								<td>{!!$rujukan->rumahSakit->nama!!}</td>
								<td>{!!$rujukan->tujuanRujuk->tujuan_rujuk!!}</td>
								<td>{!!$rujukan->periksa_id!!}</td>
							</td>

							</tr>
					   @endforeach
						</tr>
					</tbody>
				</table>
		  </div>
      </div>
</div>
@stop
@section('footer') 


@stop
