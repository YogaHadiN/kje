@extends('layout.master')

@section('title') 
Klinik Jati Elok | Invoices

@stop
@section('page-title') 
<h2>Invoices</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Invoices</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Tanggal
						 <br>
						{!! Form::text('tanggal', null, [
							'class' => 'form-control',
							'onkeyup' => 'getData();return false;',
							'id'    => 'tanggal'
						])!!}
					</th>
					<th>Invoice
						<br>
						{!! Form::text('invoice_id', null, [
							'class'   => 'form-control',
							'onkeyup' => 'getData();return false;',
							'id'      => 'invoice_id'
						]) !!}
					</th>
					<th>Asuransi
						<br>
						{!! Form::text('nama_asuransi', null, [
							'class'   => 'form-control',
							'onkeyup' => 'getData();return false;',
							'id'      => 'nama_asuransi'
						]) !!}
					</th>
					<th>Piutang
						<br>
						{!! Form::text('piutang', null, [
							'class'   => 'form-control',
							'onkeyup' => 'getData();return false;',
							'id'      => 'piutang'
						]) !!}
					</th>
					<th>Sudah Dibayar
						<br>
						{!! Form::text('sudah_dibayar', null, [
							'class'   => 'form-control',
							'onkeyup' => 'getData();return false;',
							'id'      => 'sudah_dibayar'
						]) !!}
					</th>
					<th>Sisa
						<br>
						{!! Form::text('sisa', null, [
							'class'   => 'form-control',
							'onkeyup' => 'getData();return false;',
							'id'      => 'sisa'
						]) !!}
					</th>
					<th>Action</th>
					<a href="http://www.url.com" target="_blank">Anchor Text</a>
				</tr>
			</thead>
			<tbody id="invoices_data">

			</tbody>
		</table>
	</div>
@stop
@section('footer') 
	{!! HTML::script('js/invoices.js')!!}
@stop
