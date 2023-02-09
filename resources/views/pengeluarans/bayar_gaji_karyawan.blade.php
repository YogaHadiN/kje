@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Laporan Pembayaran Gaji Karyawan
@stop
@section('page-title') 
 <h2>Pembayaran Gaji Karyawan</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Pembayaran Gaji Karyawan</strong>
      </li>
</ol>
@stop
@section('content') 
@if ( Session::has('print') )
    <div id="print" class="hide">
        {{ Session::get('print') }}
    </div>
@endif

{!! Form::open(['url' => 'pengeluarans/bayar_gaji_karyawan', 'method' => 'post']) !!}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>Pembayaran Gaji Karyawan</h1>
			<div class="alert alert-info">
				<h3>Informasi</h3>
				Pembayaran Gaji Tidak bisa dilakukan dengan <strong>Sumber Uang di Kasir</strong>
			</div>
            <hr>
				<div class="form-group @if($errors->has('sumber_uang_id'))has-error @endif">
				  {!! Form::label('sumber_uang_id', 'Sumber Dana', ['class' => 'control-label']) !!}
                  {!! Form::select('sumber_uang_id', $sumber_kas_lists, null , ['class' => 'form-control rq']) !!}
				  @if($errors->has('sumber_uang_id'))<code>{{ $errors->first('sumber_uang_id') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('bulan'))has-error @endif">
				  {!! Form::label('bulan', 'Periode Bulan', ['class' => 'control-label']) !!}
                  {!! Form::text('bulan', date('m-Y', strtotime("-1 month")), [
					  'class' => 'form-control rq bulanTahun',
					  'id'    => 'periode'
				  ]) !!}
				  @if($errors->has('bulan'))<code>{{ $errors->first('bulan') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('petugas_id'))has-error @endif">
				  {!! Form::label('petugas_id', 'Petugas Penginput', ['class' => 'control-label']) !!}
                  {!! Form::select('petugas_id', \App\Models\Staf::list(), null, [
					  'class' => 'form-control rq selectpick',
					  'data-live-search' => 'true',
					  'id'    => 'petugas_id'
				  ]) !!}
				  @if($errors->has('petugas_id'))<code>{{ $errors->first('petugas_id') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('tanggal_dibayar'))has-error @endif">
				  {!! Form::label('tanggal_dibayar', 'Tanggal Dibayar', ['class' => 'control-label']) !!}
                  {!! Form::text('tanggal_dibayar', date('d-m-Y'), [
					  'class' => 'form-control rq tanggal',
					  'id'    => 'tanggal_dibayar'
				  ]) !!}
				  @if($errors->has('tanggal_dibayar'))<code>{{ $errors->first('tanggal_dibayar') }}</code>@endif
				</div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit(); return false;">Submit</button>
                      <button class="btn btn-success btn-block btn-lg hide" id="submit" type="submit">Submit</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <a href="{{ url('laporan_laba_rugis') }}" class="btn btn-danger btn-block btn-lg">Cancel</a>
                    </div>
                  </div>
                </div>
				<div class="form-group">
					{!! Form::textarea('container_gaji', '[]', ['class' => 'form-control hide', 'id' => 'container_gaji']) !!}
				</div>
              </div>
            </div>
  </div>
</div>
{!! Form::close() !!}

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Gaji Yang Dibayarkan</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table id="tabel_daftar_gaji" class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th class="hide">key</th>
							<th>Nama Staf Yg Dibayar</th>
							<th>Gaji Pokok</th>
							<th>Bonus</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="hide key">
								0
							</td>
							<td class="nama_staf">
								{!! Form::select('staf_id',App\Models\Classes\Yoga::stafList(), null , [
									'class'            => 'nama_staf_select form-control selectpick this_required',
									'data-live-search' => 'true',
									'onchange'         => 'changeNamaStaf(this);return false;'
								]) !!}
							</td>
							<td class="gaji_pokok">
							  {!! Form::text('gaji_pokok', null, [
								  'class'   => 'form-control gaji_pokok_text uangInput this_required',
								  'onkeyup' => 'changeGajiPokok(this);return false;'
							  ]) !!}
							</td>
							<td class="jumlah_bonus">
							  {!! Form::text('bonus', null, [
								  'class' => 'form-control jumlah_bonus_text uangInput this_required',
								  'onkeyup' => 'changeJumlahBonus(this); return false;'
							  ]) !!}
							</td>
							<td>
								<button class="btn btn-primary" onclick="tambah(this);return false;">
									<i class="fa fa-plus fa-2" aria-hidden="true"></i>
								</button>
								<button class="btn btn-danger" onclick="kurang(this);return false;">
									<i class="fa fa-minus fa-2" aria-hidden="true"></i>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div id="select_template" class="hide">
	  {!! Form::select('staf_id',App\Models\Classes\Yoga::stafList(), null , [
			'class'            => 'nama_staf_select form-control',
			'data-live-search' => 'true',
			'onchange'         => 'changeNamaStaf(this);return false;'
	  ]) !!}
	</div>
@if(Auth::user()->role_id == '6')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">List Semua Pembayaran Gaji Karyawan</div>
				</div>
				<div class="panel-body">
					<div class-"table-responsive">
                    <div class="row">
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            Menampilkan <span id="rows"></span> hasil
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
                            {!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
                                'class'    => 'form-control',
                                'onchange' => 'clearAndSearch();return false;',
                                'id'       => 'displayed_rows'
                            ]) !!}
                        </div>
                      </div>
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
                                    <th nowrap class="kolom_2">
                                        Tanggal Pembayaran <br>
                                        {!! Form::text('tanggal', null, [
                                            'class' => 'form-control-inline tgl form-control',
                                            'onkeyup' => 'clearAndSearch();return false;',
                                            'id'    => 'form_tanggal'
                                        ])!!}
                                    </th>
									<th nowrap class="kolom_2">
                                        Nama Staf <br>
                                        {!! Form::select('staf_id', \App\Models\Staf::pluck('nama', 'id'), null, [
                                            'class' => 'form-control selectpick',
                                            'placeholder' => '- Pilih -',
                                            'data-live-search' => 'true',
                                            'onchange' => 'clearAndSearch();return false;',
                                            'id'    => 'form_staf_id'
                                        ])!!}
                                    </th>
									<th>
                                        Gaji Pokok 
                                        {!! Form::text('gaji_pokok', null, [
                                            'class' => 'form-control-inline form-control',
                                            'onkeyup' => 'clearAndSearch();return false;',
                                            'id'    => 'form_gaji_pokok'
                                        ])!!}
                                    </th>
									<th>
                                        Bonus
                                        {!! Form::text('bonus', null, [
                                            'class' => 'form-control-inline form-control',
                                            'onkeyup' => 'clearAndSearch();return false;',
                                            'id'    => 'form_bonus'
                                        ])!!}
                                    </th>
									<th>
                                        Pph 21
                                        {!! Form::text('pph21', null, [
                                            'class' => 'form-control-inline form-control',
                                            'onkeyup' => 'clearAndSearch();return false;',
                                            'id'    => 'form_pph21'
                                        ])!!}
                                    </th>
									<th>
                                        Gaji Netto
                                        {!! Form::text('gaji_netto', null, [
                                            'class' => 'form-control-inline form-control',
                                            'onkeyup' => 'clearAndSearch();return false;',
                                            'id'    => 'form_gaji_netto'
                                        ])!!}
                                    </th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="rek_container">

                            </tbody>
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
				</div>
			</div>
		</div>
	</div>
@endif
@stop
@section('footer') 
<script>
	var session_print = "{{ Session::get('print') }}";
	console.log(session_print);
</script>
<script src="{!! url('js/twbs-pagination/jquery.twbsPagination.min.js') !!}"></script>
<script src="{!! asset('js/bayar_gaji_karyawan.js') !!}"></script>
<script src="{!! asset('js/pembayaran_gaji_karyawan.js') !!}"></script>
@stop
