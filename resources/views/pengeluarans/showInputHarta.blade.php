@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Detail Harta

@stop
@section('page-title') 
<h2>Detail Harta</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Detail Harta</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panelLeft">
						<div class="panel-title">Detail Input Harta</div>
					</div>
					<div class="panelRight">
					  
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed table-bordered">
							<tbody>
								<tr>
									<td>id</td>
									<td>{{ $harta->id }}</td>
								</tr>
								<tr>
									<td>Harta</td>
									<td>{{ $harta->harta }}</td>
								</tr>
								<tr>
									<td>Harga Beli</td>
									<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $harta->harga  )}}</td>
								</tr>
								<tr>
									<td>Harga Jual</td>
									<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $harta->harga_jual ) }}</td>
								</tr>
								<tr>
									<td>Penyusutan</td>
									<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $harta->penyusutan ) }}</td>
								</tr>
								<tr>
									<td>Tax Amensty</td>
									<td>{{ App\Models\Classes\Yoga::yesNo( $harta->tax_amnesty ) }}</td>
								</tr>
								<tr>
									<td>Tanggal Dibeli</td>
									<td>{{ $harta->tanggal_beli->format('d M Y') }}</td>
								</tr>
								<tr>
									<td>Tanggal Dijual</td>
									<td>{{ $harta->tanggal_dijual }}</td>
								</tr>
								<tr>
									<td>Dijual</td>
									<td>{{ $harta->dijual }}</td>
								</tr>
								<tr>
									<td>Masa Pakai</td>
									<td>{{ $harta->masa_pakai }}</td>
								</tr>
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


