@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Laporan Pembayaran

@stop
@section('page-title') 
	<h2>Laporan Pembayaran {!! $asuransi->nama !!}</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Per Pembayaran</strong>
      </li>
</ol>
@stop

@section('head') 
	<style type="text/css" media="all">
		.barcode {
			position: fixed;
			bottom: 73px;
			left: 0px;
			z-index: 999;
		}
	</style>
@stop
@section('content') 
@if (isset($rekening))
	@include('pendapatans.memproses')
@endif
<div class="row">
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="panel-title">
					<div class="panelLeft">
						Pembayaran
					</div>
					<div class="panelRight">
						<button class="btn btn-primary" onclick="importPembayaranExcel(this);return false;" type="button">
							 Excel  <span class="glyphicon glyphicon-import" aria-hidden="true"></span>
						</button>
					</div>
				</div>
            </div>
            <div class="panel-body">
                {!! Form::open([
					'url'          => 'pendapatans/pembayaran/asuransi',
					'method'       => 'post',
					'autocomplete' => 'off'
				]) !!} 
                    {!! Form::textarea('temp', json_encode( $pembayarans ), ['class' => 'form-control hide', 'id' => 'pembayarans']) !!} 
                    {!! Form::text('mulai', $mulai, ['class' => 'form-control hide']) !!} 
                    {!! Form::text('akhir', $akhir, ['class' => 'form-control hide']) !!} 
                <div class="form-group hide">
                    {!! Form::label('asuransi_id', 'Staf') !!}
                    {!! Form::text('asuransi_id' , $asuransi_id, ['class' => 'form-control']) !!}
                </div>
				<div class="form-group @if($errors->has('staf_id'))has-error @endif">
				  {!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
                  {!! Form::select('staf_id', App\Models\Classes\Yoga::stafList() , null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true', 'id'=>'staf_id']) !!}
				  @if($errors->has('staf_id'))<code>{!! $errors->first('staf_id') !!}</code>@endif
				</div>
				<div class="form-group @if($errors->has('coa_id'))has-error @endif">
				  {!! Form::label('coa_id', 'Akun Kas Tujuan', ['class' => 'control-label']) !!}
				  {!! Form::select('coa_id', $kasList, $arus_kas_tujuan, ['class' => 'form-control rq', 'id'=>'kasList']) !!}
				  @if($errors->has('coa_id'))<code>{!! $errors->first('coa_id') !!}</code>@endif
				</div>
				<div class="form-group @if($errors->has('tanggal_dibayar'))has-error @endif">
				  {!! Form::label('tanggal_dibayar', 'Tanggal Dibayar', ['class' => 'control-label']) !!}
                  {!! Form::text('tanggal_dibayar' , $tanggal_dibayar, ['class' => 'form-control tanggal rq']) !!}
				  @if($errors->has('tanggal_dibayar'))<code>{!! $errors->first('tanggal_dibayar') !!}</code>@endif
				</div>
				<div class="form-group @if($errors->has('dibayar'))has-error @endif">
				  {!! Form::label('dibayar', 'Dibayar Sebesar', ['class' => 'control-label']) !!}
				  {!! Form::text('dibayar' , null, ['class' => 'form-control rq', 'id'=>'piutang', 'readonly' => 'readonly']) !!}
				  @if($errors->has('dibayar'))<code>{!! $errors->first('dibayar') !!}</code>@endif
				</div>
				<div class="form-group @if($errors->has('invoice_id'))has-error @endif">
				  {!! Form::label('invoice_id', 'ID Invoice', ['class' => 'control-label']) !!}
				  <div class="table-responsive">
				  	<table class="table table-hover table-condensed table-bordered">
				  		<tbody>
							<tr>
								<td class="td_invoice">
									<div class="form-group">
										{!! Form::select('invoice_id[]', $option_invoices, null, array(
											'class'       => 'form-control',
											'onchange'    => 'getPiutangAsuransiDetail(this);return false;',
											'placeholder' => 'Nomor Invoice'
											))!!}
									</div>
								</td>
								<td class="column-fit">
									<button type="button" class="btn btn-primary" onclick="tambahInput(this); return false;">
										<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
									</button>
								</td>
							</tr>
						</tbody>
				  	</table>
				  </div>
				  @if($errors->has('invoice_id'))<code>{!! $errors->first('invoice_id') !!}</code>@endif
				</div>
				<div class="form-group @if($errors->has('kata_kunci'))has-error @endif">
				  {!! Form::label('kata_kunci', 'Kata Kunci', ['class' => 'control-label']) !!}
				  {!! Form::text('kata_kunci' , $asuransi->kata_kunci, ['class' => 'form-control kata_kunci', 'id'=>'kata_kunci']) !!}
				  @if($errors->has('kata_kunci'))<code>{!! $errors->first('kata_kunci') !!}</code>@endif
				</div>
				@if(isset($id))
					@include('pendapatans.pembayaran_show_form', ['id' => $id])
				@else
					@include('pendapatans.pembayaran_show_form', ['id' => null])
				@endif
				{!! Form::textarea('catatan_container', '[]', ['class' => 'form-control textareacustom hide', 'id' => 'catatan_container']) !!}
                <div class="form-group">
                    <button class="btn btn-success btn-lg btn-block" type="button" onclick="submitPage(this);return false;">Bayar</button>
                    {!! Form::submit('Bayar', ['class' => 'btn btn-success hide', 'id'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
				<textarea name="" id="excel_pembayaran" class="textareacustom hide" rows="8" cols="40">{{ $excel_pembayaran }}</textarea>
            </div>
        </div>
    </div>
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Informasi</div>
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table table-condensed">
						<tbody>
							<tr>
								<tr>
									<td>Nama Asuransi</td>
									<td class="text-right"> {{ $asuransi->nama }}</td>
								</tr>
								<tr>
									<td>Mulai</td>
									<td class="text-right"> {{ $mulai }}</td>
								</tr>
								<tr>
									<td>Akhir</td>
									<td class="text-right"> {{ $akhir }}</td>
								</tr>
								<tr>
									<td> Total Piutang </td>
									<td class="text-right">{{  App\Models\Classes\Yoga::buatrp( $total_belum_dibayar + $total_sudah_dibayar) }}</td>
								</tr>
								<tr>
									<td>Sudah Dibayar Total</td>
									<td class="text-right">{{  App\Models\Classes\Yoga::buatrp( $total_sudah_dibayar )}}</td>
								</tr>
								<tr>
									<td>Belum Dibayar Total</td>
									<td class="text-right">{{  App\Models\Classes\Yoga::buatrp( $total_belum_dibayar )}}</td>
								</tr>
							</tr>
						</tbody>
					</table>
				</div>
            </div>
        </div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Invoice</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<tbody id="body_invoice">

						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		<div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Catatan</div>
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Nama Peserta</th>
								<th>Tagihan</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="container_catatan">

						</tbody>
					</table>
				</div>
			</div>
        </div>
		<div class="barcode" id="panel_perbandingan">
			
		</div>
    </div>
</div>
<div>
  <!-- Nav tabs -->
  <div class="panel panel-default">
  	<div class="panel-body">
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#detail_pembayaran" aria-controls="detail_pembayaran" role="tab" data-toggle="tab">Detail Pembayaran</a></li>
		<li role="presentation"><a href="#excel_gak_cocok" aria-controls="excel_gak_cocok" role="tab" data-toggle="tab">Bandingkan Data</a></li>
		<li role="presentation"><a href="#cari_transaksi" aria-controls="cari_transaksi" role="tab" data-toggle="tab">Cari Transaksi</a></li>
	  </ul>

  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="detail_pembayaran">
			 <div class="panel panel-danger">
				<div class="panel-heading">
					<div class="panelLeft">
						<div class="panel-title">Detail Pembayaran  <span id="jumlah_pasien"></span> Pasien </div>
					</div>
					<div class="panelRight">
						<a class="btn btn-success" href="#" onclick="cekAll();return false;">Cek Semua</a>
						<a class="btn btn-danger" href="#" onclick="resetAll();return false;">Reset Semua</a>
					</div>
				</div>
				<div class="panel-body">
					<div class-"table-responsive">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>ID PERIKSA</th>
									<th>Nama Pasien</th>
									<th>Piutang</th>
									<th>Sudah Dibayar</th>
									<th>Pembayaran</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="table_temp2">

							</tbody>
						</table>
					</div>
				</div>
			</div>   
		</div>
		<h3>Cocok = <span id="cocok"></span></h3>
		<h3>Tiak Cocok = <span id="tidak_cocok"></span></h3>
		<h3></h3>
		<div role="tabpanel" class="tab-pane" id="excel_gak_cocok">
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Nama Peserta</th>
							<th>Tagihan</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="bandingkan_data">

					</tbody>
				</table>
			</div>
			
		</div>
		<div role="tabpanel" class="tab-pane" id="cari_transaksi">
			<h1>Ketemu {{ count($cari_transaksis) }}</h1>
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Nama Peserta</th>
							<th>Tagihan</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($cari_transaksis as $trx)
							<tr>
								<td>{{ $trx->nama }}</td>
								<td>{{ $trx->piutang }}</td>
								<td>{{ $trx->tanggal }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<h1>Tidak Ketemu <span id="jumlah_tidak_ketemu"></span></h1>
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Nama Peserta</th>
							<th>Tagihan</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tidak_ketemu"></tbody>
				</table>
			</div>
			<textarea name="cari_transaksis" class="hide" id="cari_transaksis">
				{{ json_encode($cari_transaksis) }}
			</textarea>
		</div>
	  </div>
  	</div>
  </div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<div class="panelLeft">
				Sudah Dibayar
				{{ count($sudah_dibayars)  }} pasien, TOTAL {{ App\Models\Classes\Yoga::buatrp( $total_sudah_dibayar ) }}
			</div>
		</h3>
	</div>
	<div class="panel-body">
		<div class-"table-responsive">
			<table class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>ID PERIKSA</th>
						<th>Nama Pasien</th>
						<th>Piutang</th>
						<th>Sudah Dibayar</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($sudah_dibayars) > 0)
						@foreach($sudah_dibayars as $dibayar)
							<tr>
								<td>{{ $dibayar->periksa_id }}</td>
								<td> {{ $dibayar->nama_pasien }} </td>
								<td>{{ App\Models\Classes\Yoga::buatrp( $dibayar->piutang )}}</td>
								<td>{{ App\Models\Classes\Yoga::buatrp( $dibayar->pembayaran )}}</td>
								<td nowrap class="autofit">
									<a class="btn btn-warning btn-sm" href="{{ url('piutang_dibayars/' . $dibayar->piutang_dibayar_id . '/edit') }}">Edit</a>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5">
								Tidak ada data untuk ditampilkan :p
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('footer') 
<script src="{!! asset('js/pembayaran_show.js?ver=123') !!}"></script>
<script type="text/javascript" charset="utf-8">
view(true);
@if(isset($id))
	cekRekening('#rekening_id');
@endif
</script>
@stop
