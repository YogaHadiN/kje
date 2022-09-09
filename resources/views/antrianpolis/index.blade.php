@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Nurse Station

@stop
@section('head')
    <style>
		.left {
		  float: left;
		  width: 125px;
		  text-align: right;
		  margin: 2px 10px;
		  display: inline;
		}

		.right {
		  float: left;
		  text-align: left;
		  margin: 2px 10px;
		  display: inline;
		}
		.imgKonfirmasi {

			width:400px;
			height:300px;

		}
    </style>
@stop
@section('page-title') 
<h2>Nurse Station</h2>
  <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Nurse Station</strong>
      </li>
  </ol>
@stop
@section('content') 
<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
<div class="panel panel-primary">
  <div class="panel-heading">
	<div class="panel-title">
		<div class="panelLeft">
			<h3>Schedulle Hari Ini</h3>
		</div>
		<div class="panelRight">
			<h3>Total : {!! $antrianpolis->count() !!}</h3>
		</div>
	</div>
  </div>
  <div class="panel-body">
	  @include('antrianpolis.form', ['antrianpolis' => $antrianpolis])
  </div>
</div>
<div class="alert alert-danger">
	Baris tabel dengan background merah adalah pasien yang melakukan Pendaftaran sendiri, harap cek dulu asuransi nya bisa dipakai atau tidak
</div>
 <div class="panel-group" id="accordion">
	 @foreach($perjanjian as $k => $p)	
	  <div class="panel panel-success">
		<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $k }}">
			<div class="panel-heading">
			  <h4 class="panel-title">
				   {{ $k }}, sudah ada {{ count($p) }} pasien
			  </h4>
			</div>
		</a>
		<div id="collapse{{ $k }}" class="panel-collapse collapse">
		  <div class="panel-body">
			  @include('antrianpolis.form', ['antrianpolis' => $p])
		  </div>
		</div>
	  </div>
	 @endforeach
</div> 	
@include('antrianpolis.modalalasan')
@include('antrianpolis.modalKonfirmasi')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Masukkan ke antrian</h4>
                </div>
                <div class="modal-body">
                    <form action="antrianperiksas" method="post">
                        <input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group">
									<label for="namaPasien" id="lblNamaPasien" >Nama Pasien</label>
									<input type="text" class="form-control" id="namaPasien1" name="namaPasien">
									<input type="text" class="displayNone" name="pasien_id" id="ID_PASIEN">
									<input type="text" class="displayNone" name="tanggal" id="tanggal">
									<input type="text" class="displayNone" name="antrian_poli_id" id="ID_ANTRIAN_POLI">
									<input type="text" class="displayNone" name="antrian" id="antrian">
									<input type="text" class="displayNone" name="pengantar" id="pengantar">
									<input type="text" class="displayNone" name="prolanis_dm" id="prolanis_dm">
									<input type="text" class="displayNone" name="prolanis_ht" id="prolanis_ht">
									<input type="text" class="displayNone" name="no_telp" id="no_telp">
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6" id="divPembayaran">
                                        <div class="form-group">
                                            <label for="pembayaran" id="lblPembayaran">Pembayaran</label>
											{!!Form::select('asuransi_id', $asu, null, ['class' => 'form-control rq selectpick', 'id' => 'pembayaran1', 'data-live-search' => 'true']) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 hide">
                                        <div class="form-group">
                                            <label for="jamDatang" id="lblJamDatang">Jam Datang</label>
                                            <label class="form-control" id="jamDatang1"></Label>
                                            <input type="text" class="displayNone" id="jamDatang"  name="jam"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 hide" id="divBukanPeserta">
                                        <div class="form-group">
                                            <label for="bukan_peserta" id="lblBukan_peserta">Peserta Klinik</label>
											{!!Form::select('bukan_peserta', $peserta, '0', ['class' => 'form-control rq', 'id' => 'bukan_peserta']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="dokter" id="lblDokter">Dokter</label><br />
                                            {!! Form::select('staf_id', $staf, null, ['id' => 'ddlDokter', 'class' => 'form-control rq']) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="poli" id="lblPoli">Poli</label><br />
                                            {!! Form::select('poli_id', App\Models\Classes\Yoga::poliList(), null, ['id' => 'poli1', 'class' => 'form-control rq'])  !!}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
									<div class="col-lg-2 col-md-2">
                                        <div class="form-group">
                                            <label for="sistolik" id="lblSistolik">Sistolik</label><br />
											<input type="text" class="form-control angka" dir="rtl"  id="sistolik" placeholder="" name="sistolik" aria-describedby="addonTekananDarah"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <div class="form-group">
                                            <label for="diastolik" id="lblDiastolik">Diastolik</label><br />
											<input type="text" class="form-control angka" dir="rtl"  id="diastolik" placeholder="" name="diastolik" aria-describedby="addonTekananDarah"/>
                                        </div>
                                    </div>
									<div class="col-lg-2 col-md-2">
										<label for="diastolik" id="lblDiastolik"></label><br />
										<label for="diastolik" id="lblDiastolik">mmHg</label><br />
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="namaPIC" id="lblBeratBadan">BeratBadan</label><br />
                                             <div class="input-group">
                                                <input type="text" class="form-control " dir="rtl" id="beratBadan" placeholder="" name="berat_badan" aria-describedby="addonBeratBadan"/>
                                                <span class="input-group-addon" id="addonBeratBadan">kg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="suhu" id="lblSuhu">Suhu</label><br />
                                             <div class="input-group">
                                                <input type="text" class="form-control " id="suhuTubuh" dir="rtl" placeholder="" name="suhu" aria-describedby="addonSuhuTubuh" />
                                                <span class="input-group-addon" id="addonSuhuTubuh">&#176;C</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="tinggiBadan" id="lblTinggiBadan">Tinggi Badan</label><br />
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="tinggiBadan" dir="rtl" placeholder="" name="tinggi_badan" aria-describedby="addonTinggiBadan" />
                                                <span class="input-group-addon" id="addonTinggiBadan">cm</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="kecelakaanKerja" id="lblKecelakaanKerja">Kecelakaan Kerja</label><br />
                                            <select class="form-control rq" id="kecelakaanKerja"  name="kecelakaan_kerja" >
                                                <option value="">-pilih-</option>
                                                <option value="1">-Ya-</option>
                                                <option value="0">-Bukan-</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="asisten" id="lblAsisten">Nama Asisten</label><br />
                                            {!! Form::select('asisten_id', $staf, null, ['class' => 'form-control selectpick rq', 'id' => 'asisten_id', 'data-live-search' => 'true']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="hamil" id="lblhamil">Kehamilan</label>
                                            {!! Form::select('hamil', App\Models\Classes\Yoga::hamil(), null, ['class' => 'form-control rq', 'id' => 'hamil']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row hide divAnc">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        @include('antrianpolis.gpa', [
                                            'g' => null,
                                            'p' => null,
                                            'a' => null
                                        ])
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label for="hpht" id="lblhamil">HPHT</label>
                                        {!! Form::text('hpht',  null, ['class' => 'form-control inputObs', 'id' => 'hpht']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 divAnc">
                                        <label for="hpht" id="lblhamil">Umur Kehamilan</label>
                                        {!! Form::text('umur_kehamilan',  null, ['class' => 'form-control inputObs', 'id' => 'umur_kehamilan']) !!}
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 hide" id="divUsg">
                                        <div class="form-group">
                                            {!! Form::label('perujuk') !!}
                                            {!! Form::select('perujuk_id', \App\Models\Perujuk::pluck('nama','id'), null, ['class' => 'form-control selectpick', 'id' => 'perujuk_id']) !!}
                                            <a class="" data-toggle="modal" href='#buat_perujuk'>Perujuk Belum Dibuat</a>
                                        </div>
                                    </div>
                                </div>
								<div class="row" id="rowStatusGDS">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class="form-group @if($errors->has('gds')) has-error @endif">
										{!! Form::label('gds', 'GDS', ['class' => 'control-label']) !!}
										{!! Form::text('gds' , null, [
											'class' => 'form-control status_gds',
											'onkeyup' => 'gdsKeyUp(this);return false;',
											'id'    => 'gds'
										]) !!}
										@if($errors->has('gds'))<code>{{ $errors->first('gds') }}</code>@endif
										</div>
									</div>
								</div>
                                <div class="row" id="pastikan">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div colspan="2" class="text-center"><h2 class="text-red">Pastikan Orang Yang Sama !</h2></div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                                <div colspan="2" class="text-center"><img src="" alt="" id="photo" width="400px" height="300px"></div>
                                            <div class="alert alert-info">
                                                 <h3 class="nama"></h3>
                                                <h3 id="usia"></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                           @include('peringatanbpjs', ['ns' => true])
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="buat_perujuk">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Buat Perujuk Baru</h4>
                                            </div>
                                            <div class="modal-body">
                                                @include('perujuks.form', ['submit' => 'Submit'])
                                            </div>
                                            <div class="modal-footer hide">
                                                <button type="button" class="btn btn-default">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <br>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <button type="button" class="btn btn-primary btn-block" id="dummySubmitButton" onclick="testSubmit(this);return false;">Submit</button>
                                        <input type="submit" name="submit" id="LinkButton1" class="btn btn-primary btn-block hide" value="Submit" />
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <a href="#" class="btn btn-danger block" onclick="$('#exampleModal').modal('hide');">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </form>
            </div>
        </div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="alert_prolanis">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Pastikan Nomor Telepon Benar</h4>
	  </div>
	  <div class="modal-body">
		  <h3>Pasien Adalah Golongan Program Lanjut Usia BPJS</h3>
		  <p>Mohon Pastikan kembali no telpon pasien yang bisa dihubungi</p>
		  <p>Saat ini yang terdaftar adalah :</p>
		  <h2 id="no_telp_pasien"></h2>
		  <p>Jika Nomor Telepon tersebut tidak benar / salah harap ganti dengan </p>
		  <p class='text-red'>Sebisa mungkin nomor telepon handphone yang bisa di SMS, bila format tidak benar misalnya kurang anka nol di depan, tolong dilengkapi dahulu</p>
	  </div>
	  <div class="modal-footer">
		  <div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a href="" id="redirect_update_pasien" class="btn btn-primary btn-block">Ganti Nomor Telepon Pasien</a>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<button type="button" class="btn btn-danger btn-block" onclick="closeModal();">Nomor Telepon Pasien Sudah Benar</button>
			</div>
		  </div>
	  </div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
@section('footer') 
	{!! HTML::script('js/togglepanel.js')!!}
	{!! HTML::script('js/cekbpjskontrol.js')!!}
    {!! HTML::script('js/uk.js') !!}   
    <script>
		@if( Session::has('print') )
			window.open("{{ url('pdfs/formulir/usg/' . Session::get('print')->pasien_id . '/' . Session::get('print')->asuransi_id) }}");
		@endif
    </script>
    {!! HTML::script('js/antrian_poli.js') !!}   
@stop
