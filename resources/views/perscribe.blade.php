<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panelLeft">
            @if($showSubmit)
                <h3 class="panel-title">Perscription Generator</h3>
            @else
                <button type="button" class="btn btn-info" onclick="generatePerscription(); return false;">Perscription Generator <span class="badge" id="tampungan_sop_terapi">0</span></button>           
            @endif
        </div>
        <div class="panelRight">
            <button class="btn btn-danger" type="button" onclick="clearResep(); return false;" id='clear_resep'>Clear</button>
        </div> 
    </div>
    <div class="panel-body">
        <div class="row hide" id="keterangan_auto_keterangan">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 yellow-bg text-center">
                <h3 class="red">Telah di set untuk BB : <span id="keterangan_auto"></span>, CEK DULU SEBELUM SUBMIT!!</h3>
            </div>
            <br>
        </div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 auto">
                <div class="form-group">
                     <div class="input-group">
                        <span class="input-group-addon">BB</span>
                        <input type="text" class="form-control " id="bb_input" placeholder="" aria-describedby="addonBB" autocomplete='off' value="{!! $berat_badan_input !!}"/>
                        <span class="input-group-addon">kg</span>
                    </div>
                    <input type="text" id="bb_aktif" autocomplete='off' class="hide">
                </div>
            </div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <button type="button" class="btn btn-info" onclick="generate2();return false;">Recreate Percription</button>
            </div>
            {{-- <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 auto">
                <select name="" id="jenis_kalkulator" class="form-control">
                    <option value="tablet">tablet</option>
                    <option value="puyer">puyer</option>
                </select>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 auto">
                <button type="button" class="btn btn-primary btn-block" id='btn_auto'>Nyalakan Auto</button>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button type="button" class="btn btn-danger btn-block" id='btn_auto_off'>Matikan Auto</button>
            </div> --}}
        </div>
        <hr>
        <div id="bhp_tindakan">
            
        </div>
        <div id="ajax5"></div>
        
        <a href="" id="legendpop" data-toggle="popover" title="Popover title" data-content="this" data-placement="left" data-html="true" class="red-tooltip"></a><legend>Isian Resep</legend>
        <input type="text" class="hide" id="boolSirupPuyer" value="0">
        <input type="text" class="hide" id="boolAdd" value="0">
        <input type="text" class="hide" id="puyer" value="0">
    
        <div class="form-group">
            <div class="tfoot" id="formResep">
                <div class="row">
                    
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                         <select id="tipeResep" class="form-control selectpick" title='Tipe Resep'>
                                    <option value="0">Standar</option>
                                    <option value="1">Puyer</option>
                                    <option value="2">Add</option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <select name="ddlNamaObat" id="ddlNamaObat" class="form-control selectpick kosong" data-live-search="true" title="Nama Obat">

                        </select>

                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <input type="text" class="form-control" id="txtjumlah" placeholder="jumlah" />
                    </div>
                </div>
            </div>
        </div>
            <div class="row" style="margin-top:15px;">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="input-group">
                        {!! Form::select('ddlsigna', $signa, null, ['class' => 'form-control selectpick', 'title' => 'Pilih Signa', 'id' => 'ddlsigna', 'data-live-search' => 'true'])!!}
                        <span class="input-group-addon anchor" id="showModalSigna" data-toggle="modal" data-target="#modalSigna"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                     <div class="input-group">
                        {!! Form::select('ddlAturanMinum', $aturanlist, null, ['class' => 'form-control selectpick', 'title' => 'Pilih Aturan Minum', 'id'=> 'ddlAturanMinum', 'data-live-search' => 'true'])!!}
                        <span class="input-group-addon anchor" id="showModalAturanMinum" data-toggle="modal" data-target="#modalAturanMinum"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>
                    </div>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <a href="#" id="inputResep" class="btn btn-success btn-block" onclick="insertTerapi();return false;">input</a>
                </div>
            </div>
            {!! Form::textarea('terapi', $terapiArray, ['class' => 'form-control hide', 'id' => 'terapi'])!!}
            {!! Form::textarea('transaksi', $transaksi, ['class' => 'form-control hide', 'id' => 'tindakan'])!!}
            @if($showSubmit)
            <br>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button type="button" class="btn btn-primary btn-block" onclick="submitResep();return false;">Submit Resep</button>
                    </div>
                </div>
            @endif
          <br>  
   <div class="row">
       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
           <div class="panel panel-primary">
               <div class="panel-heading">
                   <div class="panel-title"><h3>Klik Disini Untuk Menginput Resep yang di tebus di luar</h3></div>
               </div>
               <div class="panel-body hide-panel" id="panel-resepluar">
                  <p>Ketik Resep Secara Manual di bawah ini </p> 
                 <p>Resep yang ditulis di kertas resep juga harus diberikan kepada pasien </p> 
                 {!! Form::textarea('resepluar', null, ['class' => 'form-control textareacustom resepluar', 'id' => 'resepluar', 'placeholder' => 'Contoh : Scabimite cr No. 1 dioleskan di kulit pertahankan 10 jam, ulangi minggu depan']) !!}
               </div>
           </div>
       </div>
   </div>
	</div><!-- end panel body -->
</div><!-- end panel primary -->
	@if($antrianperiksa->asuransi_id == '3') 
		<div class="alert alert-danger">
			<h2>Perhatian</h2>
			<p>Untuk Pasien Inhealth, harap memberikan obat walaupun sedikit, bila pasien dirujuk dan tidak perlu obat, berikan Vitamin saja.. </p>
		</div>
	@endif
    <div class="alert alert-info">
        Bila resep error tidak bisa dimasukkan, click tombol <strong><a href="#" onclick="$('#clear_resep').click(); return false;">Clear</a></strong>, untuk menghapus resep, lalu masukkan ulang resep, atau kalau tidak bisa juga tekan tombol <strong> Ctrl + F5</strong>, lalu ketik ulang status
    </div>
@include('resepluar')
