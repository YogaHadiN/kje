@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Dispensing Obat Per Tanggal

@stop
@section('page-title') 
<h2>Dispensing</h2>
<ol class="breadcrumb">
  <li>
      <a href="{{ url('laporans') }}">Home</a>
  </li>
  <li class="active">
  <strong>Dispensing Obat {{ $rak->id }} tanggal {{ $tanggal }}</strong>
  </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
				<div class="panelLeft"><h3>
						Rak : {{ $rak->id }}
					</h3></div>
				<div class="panelRight">
					<h3>Total : {!! count($dispensings) !!}</h3>
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
							<th>Keterangan</th>
							<th>Masuk</th>
							<th>Keluar</th>
							{{--<th>Keterangan</th>--}}
						</tr>
					</thead>
					<tbody>
						@foreach ($dispensings as $dispensing)
							<tr>
								<td>
									@if($dispensing->dispensable_type == 'App\Models\Terapi')
										{!! $dispensing->dispensable->periksa->ketjurnal !!}
									@elseif($dispensing->dispensable_type == 'App\Models\Pembelian')
										{!! $dispensing->dispensable->fakturbelanja->ketjurnal !!}
									@endif

								</td>
                                <td nowrap>{!! $dispensing->masuk !!} {{ $rak->formula->sediaan->sediaan }}</td>
                                <td nowrap>{!! $dispensing->keluar !!} {{ $rak->formula->sediaan->sediaan }}</td>
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
						{{ App\Models\Classes\Yoga::updateDatePrep( $tanggal ) }} 
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
