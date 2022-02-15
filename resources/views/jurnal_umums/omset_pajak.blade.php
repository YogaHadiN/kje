@extends('layout.master')
@section('title') 
{{ env("NAMA_KLINIK") }} | Omset Pajak
@stop
@section('page-title') 
 <h2>Omset Pajak</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
         <strong>Omset Pajak</strong>
      </li>
</ol>
@stop
@section('head') 
@stop
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Omset Pajak</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed table-bordered">
							<thead>
								<tr>
									<th>Bulan</th>
									<th>Nilai</th>
								</tr>
							</thead>
							<tbody>
								@if(count($pajaks) > 0)
									@foreach($pajaks as $pajak)
										<tr>
											<td>{{ $pajak->bulan }}</td>
											<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $pajak->nilai ) }}</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="2" class="text-center">
											Tidak ada Data Untuk Ditampilkan 
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
@stop
@section('footer') 

@stop
