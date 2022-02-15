@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pph21 Detil

@stop
@section('page-title') 
<h2>Pph21</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li>
		  <a href="{{ url('pajaks/pph21s')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong> {{ $bayar_gajis->first()->tanggal_dibayar->format('Y m') }} / {{ $bayar_gajis->first()->staf->nama }} </strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>Nama</th>
					<th>Gaji Pokok</th>
					<th>Bonus</th>
					<th>Pph21</th>
				</tr>
			</thead>
			<tbody>
				@php($total_gaji_pokok = 0)
				@php($total_bonus = 0)
				@php($total_pph21 = 0)
				@foreach($bayar_gajis as $gaji)
					@php($total_gaji_pokok += $gaji->gaji_pokok)
					@php($total_bonus += $gaji->bonus)
					@php($total_pph21 += $gaji->pph21s->pph21)
						<tr>
							<td>{{ $gaji->tanggal_dibayar->format('d-m-Y') }}</td>
							<td>{{ $gaji->staf->nama }}</td>
							<td class="text-right uang">{{ $gaji->gaji_pokok }}</td>
							<td class="text-right uang">{{ $gaji->bonus }}</td>
							<td class="text-right uang">{{ $gaji->pph21s->pph21 }}</td>
						</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">Total</th>
					<th class="text-right uang">{{ $total_gaji_pokok }}</th>
					<th class="text-right uang">{{ $total_bonus }}</th>
					<th class="text-right uang">{{ $total_pph21 }}</th>
				</tr>
			</tfoot>
		</table>
	</div>
@stop
@section('footer') 
	
@stop
