@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Dispensing Obat

@stop
@section('page-title') 
<h2>Dispensing</h2>
<ol class="breadcrumb">
  <li>
      <a href="{{ url('laporans') }}">Home</a>
  </li>
  <li class="active">
      <strong>Dispensing Obat</strong>
  </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
				<div class="panelLeft"><h3>
					<h3>Total : {!! count($dispensings) !!}</h3>
					</h3></div>
				<div class="panelRight">
					<a class="btn btn-success" href="{{ url('pdfs/dispensing/' . $rak->id . '/' . $mulai . '/' . $akhir) }}" target="_blank">Cetak Bentuk PDF</a>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="row">
		  	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			  <div class="table-responsive">
				<table class="table table-bordered table-hover" id="tableAsuransi">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>keluar</th>
							<th>masuk</th>
							<th>Action</th>
							{{--<th>Keterangan</th>--}}
						</tr>
					</thead>
					<tbody>
						@foreach ($dispensings as $dispensing)
							<tr>
							<td>{!! App\Models\Classes\Yoga::updateDatePrep($dispensing->tanggal) !!}</td>
							<td>{!! $dispensing->keluar !!} {{ $rak->formula->sediaan }}</td>
							<td>{!! $dispensing->masuk !!} {{ $rak->formula->sediaan }}</td>
							<td> <a class="btn btn-info btn-xs btn-block" href="{{ url('dispensings/' . $rak->id . '/' . $dispensing->tanggal) }}">Detail</a> </td>

							  {{--<td>{!! $dispensing->dispensable_type !!} {!! $dispensing->dispensable_id !!}</td>--}}
						</tr>
						@endforeach
					</tbody>
				</table>
			  </div>
		  	</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			  <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				  <h3>Merek Terdaftar : </h3>
				  <div class="alert alert-success">
					  <ul>
						  @foreach($rak->merek as $mrk)
						  <li>{{ $mrk->merek }}</li>
						  @endforeach
					  </ul>
				  </div>
				</div>
			  </div>
			  <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h3>Periode Tanggal</h3>
					<div class="alert alert-info">
						{{ App\Models\Classes\Yoga::updateDatePrep( $mulai ) }} s/d {{ App\Models\Classes\Yoga::updateDatePrep( $akhir ) }}
				  </div>
				</div>
			  </div>
			</div>
		  </div>
      </div>
</div>
@stop
@section('footer') 
	
@stop
