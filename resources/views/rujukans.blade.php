@extends('layout.master')
@section('title') 
{{ env("NAMA_KLINIK") }} | rujukans
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
							<th>rumah sakit</th>
							<th>spesialis</th>
							<th>ID PERIKSA</th>
						</tr>
					</thead>
					<tbody>
						@foreach($rujukans as $rujukan)
							<tr>
								<td>{!!$rujukan->periksa->tanggal!!}</td>
								<td>{!!$rujukan->periksa->staf->nama!!}</td>
								<td>{!!$rujukan->periksa->diagnosa->diagnosa!!} - {!!$rujukan->periksa->icd10_id->diagnosaICD!!}</td>
								<td>{!!$rujukan->rumahSakit->rumah_sakit!!}</td>
								<td>{!!$rujukan->tujuanRujuk->tujuan_rujuk!!}</td>
								<td>{!!$rujukan->periksa_id!!}</td>
								<td><a href="rujukans/{!!$rujukan->id!!}/edit" class="btn btn-info btn-block ">EDIT</a>
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
