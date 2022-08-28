@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Transaksi Periksa

@stop
@section('head')
    <style type="text/css" media="screen">
        .jenis_tarif {
            width : 30%
        }
    </style>
@stop
@section('page-title') 
<h2>Edit Transaksi Periksa</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Transaksi Periksa</strong>
	  </li>
</ol>
@stop
@section('content') 
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="panel panel-info">
							<div class="panel-heading">
								<div class="panel-title">
									<div class="panelLeft">
										Edit Transaksi Periksa
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table id="table_transaksi_periksa" class="table table-hover table-condensed">
										<thead>
											<tr>
												<th class="k hide">k</th>
												<th class="coa_id hide">coa_id</th>
												<th class="jenis_tarif">Jenis Tarif</th>
												<th>Biaya</th>
												<th>Keterangan</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody id="container_transaksi_periksa">

                                        </tbody>
                                        <tfoot>
											<tr>
												<td class="k hide">k</td>
												<td class="coa_id hide">coa_id</td>
												<td class="jenis_tarif">
                                                    {!! Form::select('jenis_tarif_id', \App\Models\JenisTarif::pluck('jenis_tarif', 'id'), null , [
                                                        'class' => 'form-control selectpick jenis_tarif_id', 
                                                        'placeholder' => '- Pilih Transaksi -',
                                                        'data-live-search' => 'true'
                                                    ]) !!}
                                                </td>
												<td>
                                                    {!! Form::text('biaya', null, ['class' => 'form-control uangInput biaya']) !!}
                                                </td>
												<td>
                                                    {!! Form::text('keterangan_pemeriksaan', null, ['class' => 'form-control keterangan_pemeriksaan']) !!}
                                                </td>
												<td>
                                                    <button class="btn btn-info btn-sm" onclick="tambahTransaksiPeriksa(this);return false">Tambah</button>
                                                </td>
											</tr>
                                        </tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="panelLeft">
									<div class="panel-title">Informasi</div>
								</div>
								<div class="panelRight">
								</div>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-hover table-condensed table-bordered">
										<tbody>
											<tr>
												<td>Periksa Id</td>
												<td>{{ $periksa->id }}</td>
											</tr>
											<tr>
												<td>Nama Pasien</td>
												<td>{{ $periksa->pasien_id }}-{{ $periksa->pasien->nama }}</td>
											</tr>
											<tr>
												<td>Pembayaran</td>
												{{-- <td>{{ $periksa->asuransi->nama }}</td> --}}
												<td>
													{!! Form::select('asuransi_id', $list_asuransi, $periksa->asuransi_id, [
														'class'            => 'form-control selectpick',
														'id'            => 'asuransi_id',
														'onchange'         => 'changeAsuransi(this);return false;',
														'data-live-search' => 'true'
													]) !!}
												</td>
											</tr>
											<tr class="hide">
												<td>Asuransi Coa Id</td>
												<td id="asuransi_coa_id">{{ $periksa->asuransi->coa_id }}</td>
											</tr>
											<tr>
												<td>Nama Dokter</td>
												<td>{{ $periksa->staf->nama }}</td>
											</tr>
											<tr>
												<td>Tanggal</td>
											</tr>
											<tr>
												<td>Jam</td>
												<td>{{ $periksa->created_at->format('H:i:s') }}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<div class="panel-title">
							<div class="panelLeft">
								Edit Tunai / Piutang
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed">
								<thead>
									<tr>
										<th>Pembayaran</th>
										<th>Nilai</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td> Tunai </td>
										<td>
										   {!! Form::text('tunai', $periksa->tunai, [
											   'class'   => 'form-control uangInput text-right tunai',
											   'id'      => 'totalTransaksiTunai',
											   'onkeyup' => 'refreshTunaiPiutang();return false;'
										   ]) !!}
									   </td>
									</tr>
									<tr>
										<td>Piutang</td>
										<td>
										   {!! Form::text('piutang', $periksa->piutang, [
											   'class'    => 'form-control uangInput text-right piutang',
											   'id'       => 'totalTransaksiPiutang',
											   'disabled' => 'disabled'
										   ]) !!}
									   </td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-danger">
						<h2>Peringatan</h2>
						<p>Halaman ini hanya untuk Super Admin atau Manager</p>
						<p>Jika Anda bukan termasuk diantara keduanya Harap segera logout</p>
					</div>
					<div class="alert alert-info">
						<h2>Petunjuk</h2>
						<ul>
							<li>Jumlah nilai pada kolom debit dan kolom kredit pada <strong>Jurnal Umum</strong>  harus sama (seimbang)</li>
							<li>Jumlah nilai seluruh baris pada <strong>Transaksi Periksa</strong> dan <strong>Edit Tunai Piutang</strong> harus sama</li>
							<li>Jumlah tersebut harus sama dengan <strong>jumlah harta</strong> yang diterima pada transaksi ini</li>
							<li>Harta yang dimaksud pada halaman ini adalah
								<ul>
									@foreach( $periksa->jurnals as $j )
										@if( substr( $j->coa_id, 0, 2 ) == '11' && $j->debit == 1  )
											<li>{{ $j->coa->coa }}</li>
										@endif
									@endforeach
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>
					<div class="panelLeft">
						Jurnal Umum
					</div>
				</h3>
			</div>
			<div class="panel-body">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Akun</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="container_jurnals">

                    </tbody>
                </table>
            </div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
		@include('jurnal_umums.formManualInput')
	</div>
</div>

{!! Form::open(['url' => 'periksas/' . $periksa->id . '/update/transaksiPeriksa', 'method' => 'post']) !!}
	<div class="row hide">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group @if($errors->has('nomor_asuransi'))has-error @endif">
			  {!! Form::label('nomor_asuransi', 'Nomor Asuransi', ['class' => 'control-label']) !!}
			  {!! Form::text('nomor_asuransi', $periksa->nomor_asuransi, array(
					'class'         => 'form-control'
				))!!}
			  @if($errors->has('nomor_asuransi'))<code>{{ $errors->first('nomor_asuransi') }}</code>@endif
			</div>
		</div>
	</div>
	<div>
	<div class="hide">
		<h2>Temp</h2>
	</div>
	<div class="hide">
		{!! Form::textarea('temp', '[]', ['class' => 'form-control textareacustom', 'id' => 'temp']) !!}
	</div>
	<div class="">
		<h2>Jurnals</h2>
		{!! Form::textarea('jurnals', $periksa->jurnals, ['class' => 'form-control textareacustom', 'id' => 'jurnals']) !!}
	</div>
	<div class="">
		<h2>Coa List</h2>
		{!! Form::textarea('coa_list', json_encode($coa_list), ['class' => 'form-control textareacustom', 'id' => 'coa_list']) !!}
	</div>
	<div>
	<div class="">
		<h2>Transaksis</h2>
		{!! Form::textarea('transaksis', $periksa->transaksii, ['class' => 'form-control textareacustom', 'id' => 'transaksis']) !!}
	</div>
	<div>
	<div class="hide">
		<h2>Periksa</h2>
		{!! Form::textarea('periksa', $periksa, ['class' => 'form-control textareacustom', 'id' => 'periksa']) !!}
	</div>
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<button class="btn btn-lg btn-block btn-success" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
					{!! Form::submit('Submit', ['class' => 'btn btn-block btn-success hide', 'id' => 'submit']) !!}
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<a class="btn btn-lg btn-danger btn-block" href="{{ url('laporans') }}">Cancel</a>
				</div>
			</div>
		</div>
	</div>
{!! Form::close() !!}
@stop

@section('footer') 
<script src="{!! asset('js/jurnalManual.js') !!}"></script>
<script src="{!! asset('js/transaksiPeriksaEdit.js') !!}"></script>
@stop
	
