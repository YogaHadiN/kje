	@extends('layout.master')

	@section('title') 
	{{ \Auth::user()->tenant->name }} | Angka Kontak BPJS

	@stop
	@section('page-title') 
	<h2>Angka Kontak BPJS</h2>
	<ol class="breadcrumb">
		  <li>
			  <a href="{{ url('laporans')}}">Home</a>
		  </li>
		  <li class="active">
			  <strong>Angka Kontak BPJS</strong>
		  </li>
	</ol>

	@stop
	@section('content') 
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group @if($errors->has('tahun')) has-error @endif">
					  {!! Form::label('tahun', 'Tahun', ['class' => 'control-label']) !!}
					  {!! Form::select('tahun', App\Models\Classes\Yoga::tahunList() , date('Y'), [
						  'class' => 'form-control',
						  'onchange' => 'clearAndSelect();return false;',
						  'id'    => 'tahun'
					  ]) !!}
					  @if($errors->has('tahun'))<code>{{ $errors->first('tahun') }}</code>@endif
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group @if($errors->has('bulan')) has-error @endif">
					  {!! Form::label('bulan', 'Bulan', ['class' => 'control-label']) !!}
					  {!! Form::select('bulan', App\Models\Classes\Yoga::bulanList() , date('m'), [
						  'class' => 'form-control',
						  'onchange' => 'clearAndSelect();return false;',
						  'id'    => 'bulan'
					  ]) !!}
					  @if($errors->has('bulan'))<code>{{ $errors->first('bulan') }}</code>@endif
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<div class="row">
					<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
						Menampilkan <span id="rows"></span> hasil
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
						{!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
							'class' => 'form-control',
							'onchange' => 'clearAndSelect();return false;',
							'id'    => 'displayed_rows'
						]) !!}
					</div>
				</div>
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>
								Tanggal Kontak <br>
								{!! Form::text('tanggal', null, [
									'class'   => 'form-control',
									'id'      => 'tanggal',
									'onkeyup' => 'clearAndSelect();return false;'
								]) !!}
							</th>
							<th>
								Nama <br>
								{!! Form::text('nama', null, [
									'class'   => 'form-control',
									'id'      => 'nama',
									'onkeyup' => 'clearAndSelect();return false;'
								]) !!}
							</th>
							<th>
								Nomor BPJS <br>
								{!! Form::text('nomor_asuransi_bpjs', null, [
									'class'   => 'form-control',
									'id'      => 'nomor_asuransi_bpjs',
									'onkeyup' => 'clearAndSelect();return false;'
								]) !!}
							</th>
							<th>
								No Telpon <br>
								{!! Form::text('no_telp', null, [
									'id'      => 'no_telp',
									'class'   => 'form-control',
									'onkeyup' => 'clearAndSelect();return false;'
								]) !!}
							</th>
							<th>
								Action
							</th>
						</tr>
					</thead>
					<tbody id="ajax_container"></tbody>
				</table>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div id="page-box">
							<nav class="text-right" aria-label="Page navigation" id="paging">
							
							</nav>
						</div>
					</div>
				</div>
			</div>
	@stop
	@section('footer') 
			{!! HTML::script('js/angka_kontak_bpjs.js')!!}
			<script src="{!! url('js/twbs-pagination/jquery.twbsPagination.min.js') !!}"></script>
	@stop
