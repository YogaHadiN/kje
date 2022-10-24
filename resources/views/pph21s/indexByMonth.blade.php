@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Pph21 {{ $bulanTahun }}

@stop
@section('page-title') 
<h2>Pph21</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li>
		  <a href="{{ url('pajaks/pph21s')}}">Pph21</a>
	  </li>
	  <li class="active">
		  <strong>{{ $bulanTahun }}</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Gaji</th>
							<th>Pph21</th>
						</tr>
					</thead>
					<tbody>
						@php( $total_gaji = 0 )
						@php( $total_pph = 0 )
						@if(count($datas) > 0)
							@foreach($datas as $data)
								@php( $total_gaji += $data->gaji )
								@php( $total_pph += $data->pph21 )
								@if ( $data->pph21 > 0 )
									<tr>
										<td>{{ $data->nama }}</td>
										<td class="uang">{{ $data->gaji }}</td>
										<td class="uang">{{ $data->pph21 }}</td>
									</tr>
								@endif
							@endforeach
						@else
							<tr>
								<td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
@section('footer') 
							<script type="text/javascript" charset="utf-8">
								function dummySubmit(control){
									if(validatePass2(control)){
										$('#submit').click();
									}
								}
							</script>
	
@stop
