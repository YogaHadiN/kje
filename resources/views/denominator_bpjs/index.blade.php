@extends('layout.master')

@section('title') 
Klinik Jati Elok | Denominator BPJS

@stop
@section('page-title') 
<h2>Denominator BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Denominator BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div class="pull-right">
			<a href="{{ url('denominator_bpjs/create') }}" class="btn btn-primary">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				Denominator
			</a>
		</div>
		<br>
		<br>
		<br>
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>Bulan Tahun</th>
						<th>Jumlah Peserta</th>
						<th>Denominator DM</th>
						<th>Denominator HT</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if($denominator_bpjs->count() > 0)
						@foreach($denominator_bpjs as $d)
							<tr>
								<td>{{ $d->bulanTahun->format('M Y') }}</td>
								<td class="text-right">{{ $d->jumlah_peserta }}</td>
								<td class="text-right">{{ $d->denominator_dm }}</td>
								<td class="text-right">{{ $d->denominator_ht }}</td>
								<td nowrap class="autofit">
									{!! Form::open(['url' => 'denominator_bpjs/' . $d->id, 'method' => 'delete']) !!}
										<a class="btn btn-warning btn-sm" href="{{ url('denominator_bpjs/' . $d->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
										@if(  $d->bulanTahun->format('Y-m')  == date('Y-m') )
											<button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus denominator {{ $d->id }}?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
										@endif
									{!! Form::close() !!}
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4" class="text-center">Tidak ada data untuk ditampilkan</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
		
@stop
@section('footer') 
	
@stop
