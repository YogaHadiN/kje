@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Form Kirim Berkas

@stop
@section('page-title') 
<h2>Edit Form Kirim Berkas</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Form Kirim Berkas</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div id="staf_container" class="hide">
		@include('kirim_berkas.staf_form')
		<textarea name="piutang_asuransi" class="hide" id="piutang_asuransi" rows="8" cols="40">[]</textarea>
	</div>
	<h1>Form Kirim Berkas</h1>
	{!! Form::model( $kirim_berkas, [
		'url'    => 'kirim_berkas/' . $kirim_berkas->id,
		'method' => 'put',
		'id'     => 'postKirimBerkas'
	]) !!}
		@include('kirim_berkas.form')
	{!! Form::close() !!}
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<div class="panelLeft">
						
					</div>
					<div class="panelRight">
						<button type="button" onclick="uncekSemua();return false;" class="btn btn-warning">Uncek Semua</button>
						<button type="button" onclick="cekSemua();return false;" class="btn btn-success">Cek Semua</button>
					</div>
				</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<tbody>
							<tr>
								<td>
									{!! Form::select('asuransi_id', App\Models\Asuransi::list(), null, [
										'class' => 'form-control selectpick',
										'id' => 'asuransi_id',
										'data-live-search' => 'true'
									]) !!}
								</td>
								<td>
									{!! Form::text('date_from', null, ['class' => 'form-control tanggal', 'id' => 'date_from', 'placeholder' => 'Tanggal Mulai']) !!}
								</td>
								<td>
									{!! Form::text('date_frrm', null, ['class' => 'form-control tanggal', 'id' => 'date_to', 'placeholder' => 'Tanggal Akhir']) !!}
								</td>
								<td>
									<button type="button" class="btn btn-success btn-block" onclick="cariPiutangAsuransi();return false;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<div>
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#pencarian_piutang" aria-controls="" role="tab" data-toggle="tab">Pencarian Piutang</a></li>
		<li role="presentation"><a href="#piutang_container" aria-controls="piutang_container" role="tab" data-toggle="tab">Piutang Tercatat</a></li>
	  </ul>
	
	  <!-- Tab panes -->

	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="pencarian_piutang">
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>ID PERIKSA</th>
							<th>Nama Pasien</th>
							<th>Asuransi</th>
							<th>Piutang</th>
							<th>Sudah Dibayar</th>
							<th>Sisa Piutang</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="body_pencarian_piutang">

					</tbody>
				</table>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="piutang_container">
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>ID PERIKSA</th>
						<th>Nama Pasien</th>
						<th>Asuransi</th>
						<th>Piutang</th>
						<th>Sudah Dibayar</th>
						<th>Sisa Piutang</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="body_piutang_tercatat">

				</tbody>
			</table>
		</div>
	  </div>
	</div>
@stop
@section('footer') 
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
    <script src="{!! url('js/kirim_berkas.js') !!}"></script>
	<script type="text/javascript" charset="utf-8">
		$('form .staf_id').selectpicker({
				style: 'btn-default',
				size: 10,
				selectOnTab : true,
				style : 'btn-white'
		});
		var data = parsePiutangTercatat();
		var temp = viewTemp(data, true);
		$('#body_piutang_tercatat').html(temp);
	</script>
@stop

