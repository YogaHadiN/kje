@extends('layout.master')

@section('title') 
Klinik Jati Elok | Daftar Gaji {{ $staf->nama }}

@stop
@section('page-title') 
<h2>Daftar Gaji {{ $staf->nama }}</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
		<li>
		<a href="{{ url('stafs/' . $staf->id . '/edit')}}">{{ $staf->nama }}</a>
	  </li>
	  <li class="active">
		  <strong>Daftar Gaji</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Daftar Gaji {{ $staf->nama }}</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
			<?php echo $stafArray->appends(Input::except('page'))->links(); ?>
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Tanggal Dibayar</th>
							<th>Periode</th>
							<th>Gaji Pokok</th>
							<th>Bonus</th>
							<th>Total Gaji</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($stafArray->count() > 0)
							@foreach($stafArray as $gaji)
								<tr>
									<td>{{ $gaji->tanggal_dibayar->format('d-m-Y') }}</td>
									<td>{{ $gaji->mulai->format('M-Y') }}</td>
									<td class="text-right">{{ App\Classes\Yoga::buatrp($gaji->gaji_pokok) }}</td>
									<td class="text-right">{{ App\Classes\Yoga::buatrp($gaji->bonus) }}</td>
									<td class="text-right strong">{{ App\Classes\Yoga::buatrp($gaji->bonus + $gaji->gaji_pokok) }}</td>
									<td> <a class="btn btn-sm btn-primary" href="{{ url('pdfs/bayar_gaji_karyawan/' . $gaji->id) }}" target="_blank">Print Struk</a> </td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="">Tidak Ada Data Untuk Ditampilkan :p</td>
							</tr>
						@endif
					</tbody>
				</table>
			<?php echo $stafArray->appends(Input::except('page'))->links(); ?>
			</div>
			
		</div>
	</div>
	
@stop
@section('footer') 
	
@stop

