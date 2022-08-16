@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Asuransi
@stop
@section('head')
    <link href="{!! asset('css/print.css') !!}" rel="stylesheet" media="print">
	<style type="text/css" media="all">
		.super-big-font{
		  font-size: 100px;
		  font-weight: bold;
		}

  .affix {
    top: 0;
    z-index: 9999 !important;
  }

  .affix + .container-fluid {
    padding-top: 70px;
  }
	</style>
@stop
@section('page-title') 
<h2>KASIR</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('antriankasirs')}}">Antrian Kasir</a>
      </li>
      <li class="active">
          <strong>Survey</strong>
      </li>
</ol>
@stop
@section('content') 
	<input class="hide" type="text" id="tipe_asuransi" value="{{ $periksa->asuransi->tipe_asuransi_id }}" />
	<input class="hide" type="text" id="asuransi_id" value="{{ $periksa->asuransi_id }}" />
	{!! Form::open([
		'url'          => 'update/surveys',
		'method'       => 'post',
		'files'        => true,
		'autocomplete' => 'off'
	])!!}
	<div class="row">
		<div class="col-lg-4">
			@include('surveys.komponen_pasien')
			@include('surveys.komponen_kelengkapan_dokumen')
		</div>
		<div class="col-lg-8">
			<div class="panel panel-default full-height totalthis" data-spy="affix" data-offset-top="197">
				<div class="panel-body text-right">
					<span class="super-big-font total"></span>
				</div>
			</div>
			<div id="komponen_submit" class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							 <a href="#" id="dummySubmit" class="btn btn-primary btn-lg btn-block" onclick="submitPage();return false">Submit</a>
							<input type="submit" name="submit" value="lanjutkan" class="btn btn-info btn-block btn-lg hide" id="submitthis" />
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							
							<a href="#" class="btn btn-danger btn-lg btn-block">Cancel</a>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-info">
				  <div class="panel-body">
					<table class="tblTerapi table" width="100%">
						<thead>
							<tr>
								<th>Jenis Tarif</th>
								<th>Biaya</th>
								<th>Action</th>
							</tr>
							<tr>
								<th colspan="2">{!! Form::select('slcTindakan', $tindakans, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true', 'id' => 'slcTindakan'])!!}</th>
								<th><button type="button" class="btn btn-success btn-sm" onclick="insertTindakan(this)">input</button></th>
							</tr>
						</thead>
						<tbody id="tarif">

						</tbody>
						<tfoot>
							<tr>
								<td>Total</td>
								<td><label for="" class="form-control total" id=""></label></td>
							</tr>
							@if($periksa->asuransi_id == 0)
								<tr class="hide">
									<td>Dibayar Asuransi</td>
									<td><input type="text" autocomplete="off"  dir="rtl" class="form-control uangInput" id="dibayar_asuransi" name="dibayar_asuransi" onkeyup="asuransiKeyup(event, this)" value="0"></td>
								</tr>
                            @elseif($periksa->asuransi->tipe_asuransi_id == 5)
								<tr>
									<td>Dibayar Asuransi</td>
									<td><input type="text" autocomplete="off"  dir="rtl" class="form-control uangInput" id="dibayar_asuransi" name="dibayar_asuransi" onkeyup="asuransiKeyup(event, this)" value="0" readonly></td>
								</tr>
							@else
								<tr>
									<td>Dibayar Asuransi</td>
									<td><input type="text" autocomplete="off"  dir="rtl" class="form-control uangInput" id="dibayar_asuransi" name="dibayar_asuransi" onkeyup="asuransiKeyup(event, this)" value="{!! $dibayar !!}"></td>
								</tr>
							@endif
							@if($periksa->asuransi_id == 0)
								<tr class="hide">
							@else
								<tr>
							@endif
								<td>Dibayar Pasien</td>
								<td><input type="text" autocomplete="off"  dir="rtl" class="form-control uang" id="dibayar_pasien" name="dibayar_pasien" readonly /></td>
							</tr>
							<tr>
								<td>Pembayaran</td>
								<td>
									<input type="text" autocomplete="off"  dir="rtl" class="form-control uangInput" id="pembayaran_pasien" onkeyup="pembayaranKeyup(event, this)" name="pembayaran"/>
								</td>
							</tr>
							<tr>
								<td>Kembalian</td>
								<td>
									<input type="text" autocomplete="off"  dir="rtl" class="form-control uang" id="kembalian_pasien" name="kembalian" readonly/>
								</td>
							</tr> 
						</tfoot>
					</table>
					{!! Form::textarea('sebelum', $tindakanPeriksa, ['class' => 'hide', 'id' => 'sebelum'])!!}
					{!! Form::textarea('tarif', $tindakanPeriksa, ['class' => 'hide', 'id' => 'txtTarif'])!!}
					{!! Form::text('periksa_id', $periksa->id, ['class' => 'hide'])!!}
				  </div>
			</div>
		</div>
	</div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary hide">
                          <div class="panel-heading">
                                <h3 class="panel-title">Obat</h3>
                          </div>
                          <div class="panel-body">

							  <div class="table-responsive">
								<table class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>Merek Obat</th>
											<th>Jumlah</th>
											<th>Satuan</th>
											<th>Biaya</th>
										</tr>
									</thead>
									<tbody id="tblResep">
										@foreach ($reseps as $resep)
											<tr>
												<td nowrap>
													{!!$resep['merek_obat']!!}
												</td>
												<td nowrap>
												   {!! $resep['jumlah'] !!} 
												</td>
												<td nowrap class="uang">
													@if($periksa->asuransi->tipe_asuransi_id == 5)
														@if($resep['fornas'] == '0')
															{!! $resep['harga_jual'] * $periksa->asuransi->kali_obat !!}
														@else 
															0            
														@endif                
													@else
														{!! $resep['harga_jual'] * $periksa->asuransi->kali_obat !!}
													@endif                
												</td>
												<td nowrap class="uang">
													@if($periksa->asuransi->tipe_asuransi_id == 5)
														@if($resep['fornas'] == '0')
															{!! $resep['jumlah'] * $resep['harga_jual'] * $periksa->asuransi->kali_obat !!}
														@else
															0
														@endif
													@else
														{!! $resep['jumlah'] * $resep['harga_jual'] * $periksa->asuransi->kali_obat !!}
													@endif
												</td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<td nowrap class="displayNone"></td>
											<td nowrap colspan="4" class="text-right"><h2>Total Biaya Obat : <span class="uang">{!!$biayatotal!!}</span></td>
										</tr>
									</tfoot>
								</table>
							  </div>

                          </div>
                    </div>
                    <div class="panel panel-danger hide">
                          <div class="panel-heading">
                                <h3 class="panel-title">PASTIKAN RESEP DOKTER SAMA</h3>
                          </div>
                          <div class="panel-body">
							  <div class="hide">
									{!! $periksa->terapi_htmll!!}
								   @if (!empty($periksa->resepluar))
									   <hr>
									   <p>Resep ditebut di apotek di Luar :</p>
									   {!! $periksa->resepluar !!}
								   @endif
							  </div>
                          </div>
                    </div>
                    @if($periksa->rujukan && $periksa->asuransi->tipe_asuransi_id == '5')
					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-title">Panel Rujukan</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
										{!! Form::label('image', 'Gambar Rujukan') !!}
										{!! Form::file('image') !!}
										@if (isset($periksa->rujukan) && $periksa->rujukan->image)
											<p> <img src="{{ \Storage::disk('s3')->url($periksa->rujukan->image) }}" alt="" class="img-rounded upload"> </p>
											@else
												<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
											@endif
										{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
									</div>
								</div>
							</div>
						</div>
					</div>
                    @endif
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            </div>
        </div>
    {!! Form::close()!!}
<button type="button" class="btn btn-info hide" id="print" onclick="testPrint();return false;">klik</button>
<div class="row" id="content-print">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box title-print text-center">
            <h1>{{ env("NAMA_KLINIK") }}</h1>
            <h5>
                {{ env("ALAMAT_KLINIK") }}
                Telp : {{ env("TELPON_KLINIK") }}  
            </h5>
        </div>
       <hr> 
       <div class="box">
           <table>
               <tbody>
                   <tr>
                       <td>Nama Pasien</td>
                       <td>:</td>
                       <td>{{ $periksa->pasien->nama }}</td>
                   </tr>
                   <tr>
                       <td>Tanggal</td>
                       <td>:</td>
                       <td>{{App\Models\Classes\Yoga::updateDatePrep(  $periksa->tanggal  )}}</td>
                   </tr>
                   <tr>
                       <td>Jam Datang</td>
                       <td>:</td>
                       <td>{{ $periksa->jam }}</td>
                   </tr>
                  <tr>
                      <td>Nomor Kuitansi</td>
                      <td>:</td>
                      <td>{{ $periksa->id }}
                  </tr> 
               </tbody>
           </table>
          <hr> 
       </div>
        <div>
			<div class="table-responsive">
				<table class="table table-condensed">
					<tbody id="transaksi-print">
					</tbody>
					<tfoot>
						<tr class="border-top">
							<td class="">Total:</td>
							<td>:</td>
							<td class="uang text-right" id="biaya-print"></td>
						</tr>
						@if($periksa->asuransi_id != 0)
						<tr>
							<td nowrap>
								Dibayar Asuransi
							</td>
							<td>:</td>
							<td class="uang text-right" id="dibayarAsuransi-print">

							</td>
						</tr>
						@endif
						<tr>
							<td>
								Pembayaran
							</td>
							<td>:</td>
							<td class="uang text-right" id="pembayaran-print">

							</td>
						</tr>
						<tr>
							<td>
								Kembalian
							</td>
							<td>:</td>
							<td class="uang text-right" id="kembalian-print">

							</td>
						</tr>

					</tfoot>
				</table>
			</div>
           <hr> 
<div class="text-center footer box">
    Semoga Lekas Sembuh
</div>
        </div>
        </div>
        </div>
<input type="input" name="" class="hide" id="periksa_id" value="{{ $periksa->id }}" />
@stop
@section('footer') 
<script>
    var base = '{{ url("/") }}';
    var base_s3 = '{{ env("AWS_URL") }}';
	function affixWidth() {
		// ensure the affix element maintains it width
		var affix = $('.totalthis');
		var width = affix.width();
		affix.width(width);
	}

	$(document).ready(function () {

		affixWidth();

	});
</script>
<script src="{!! url('js/app.js') !!}"></script>
<script src="{{ url('js/fotozoom.js') }}" type="text/javascript"></script>
{!! HTML::script('js/togglepanel.js')!!}
@if($periksa->rujukan)
@endif
	{!! HTML::script('js/kasir_index.js') !!}
	{!! HTML::script('js/show_periksa.js') !!}
	{!! HTML::script('js/submit_page_kasir.js') !!}
@stop
