@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Keluar Masuk Kasir

@stop
@section('page-title') 
<h2>Keluar Masuk Kasir</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Keluar Masuk Kasir</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>Jam</th>
						<th>Debet</th>
						<th>Kredit</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					@php
						$total_debit = 0;
						$total_kredit = 0;
					@endphp
					@if($jurnal_umums->count() > 0)
						@foreach($jurnal_umums as $ju)
							<tr>
								<td nowrap>{{ $ju->created_at }}</td>
								<td class="text-right" nowrap>
									@if( $ju->debit == 1 )
										{{ buatrp( $ju->nilai ) }}
										@php
											$total_debit += $ju->nilai;
										@endphp
									@else
										{{ buatrp(0) }}
									@endif
								</td>
								<td class="text-right" nowrap>
									@if( $ju->debit == 0 )
										{{ buatrp( $ju->nilai ) }}
										@php
											$total_kredit += $ju->nilai
										@endphp
									@else
										{{ buatrp(0) }}
									@endif
								</td>
								<td>
									{!! $ju->jurnalable->ket_jurnal !!}
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="">
								{!! Form::open(['url' => 'jurnal_umums/imports', 'method' => 'post', 'files' => 'true']) !!}
									<div class="form-group">
										{!! Form::label('file', 'Data tidak ditemukan, upload data?') !!}
										{!! Form::file('file') !!}
										{!! Form::submit('Upload', ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
									</div>
								{!! Form::close() !!}
							</td>
						</tr>
					@endif
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td nowrap>{{ buatrp($total_debit) }}</td>
						<td nowrap>{{ buatrp($total_kredit) }}</td>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>
		
@stop
@section('footer') 
	
@stop
