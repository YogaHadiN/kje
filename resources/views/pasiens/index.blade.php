@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pasien

@stop
@section('page-title') 
 <h2>Pasien</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Pasien</strong>
      </li>
</ol>

@stop
@section('content')
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : </h3>
                </div>
                <div class="panelRight">
                <a href="#" type="button" class="btn btn-info" data-toggle="modal" data-target="#kriteria"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Parameter Pencarian</a>
                <a href="#" type="button" class="btn btn-success" data-toggle="modal" data-target="#pasienInsert"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> PASIEN Baru</a>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover" id="tablePasien">
                  <thead>
                    <tr>
                    {!! Form::open(['url' => 'pasiens/ajax/ajaxpasiens', 'method' => 'get', 'id' => 'ajaxkeyup', 'autocomplete' => 'off'])!!}

                        <th class="displayNone">
                           No Status<br>
                           {!! Form::text('id', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'id'])!!}
                        </th>
                        <th>
                            Nama Pasien <br>
                           {!! Form::text('nama', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama'])!!}
                        </th>
                        <th>
                            Alamat <br>
                           {!! Form::text('alamat', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'alamat'])!!}
                        </th>
                        <th>
                            Tanggal Lahir <br>
                           {!! Form::text('tanggal_lahir', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'tanggal_lahir'])!!}
                        </th>
                        <th>
                            No Telp <br>
                           {!! Form::text('no_telp', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'no_telp'])!!}
                        </th>
                        <th class="displayNone">
                            Nama Asuransi <br>
                           {!! Form::text('nama_asuransi', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_asuransi'])!!}
                        </th>
                        <th class="displayNone">
                            No Asuransi <br>
                           {!! Form::text('nomor_asuransi', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nomor_asuransi'])!!}
                        </th>
                        <th class="displayNone">
                            Nama Peserta <br>
                           {!! Form::text('nama_peserta', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_peserta'])!!}
                        </th>
                        <th class="displayNone">
                            Nama Ibu <br>
                           {!! Form::text('nama_ibu', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_ibu'])!!}
                        </th>
                        <th class="displayNone">
                            Nama Ayah <br>
                           {!! Form::text('nama_ayah', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_ayah_Input'])!!}
                        </th>
                        <th class="displayNone">Asuransi ID</th>
                        <th>Action <br> <button class="btn btn-danger  btn-block" id="clear">clear</button></th>

                    {!! Form::close()!!}
                    </tr>

                </thead>
                <tbody id="ajax">
                  
                </tbody>
            </table>
      </div>
</div>
<div class="modal fade bs-example-modal-md" id="pasienInsert" tabindex="-1" role="dialog" aria-labelledby="kriteriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="kriteriaLabel">PASIEN INSERT</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            {!! Form::open(['url' => 'pasiens/ajax/create', 'id' => 'pasienInsertForm', 'method' => 'post', 'autocomplete' => 'off'])!!}
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                         <div class="form-group">
                                            {!! Form::label('nama', 'Nama Pasien')!!}
                                            {!! Form::text('nama', null, ['class' => 'form-control hh required', 'placeholder' => 'Masukkan nama tanpa gelar, tanpa nama panggilan'])!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('sex', 'Jenis Kelamin')!!}
                                            {!! Form::select('sex',[null => '- jenis kelamin -' , 'L' => 'Laki-laki', 'P' => 'Perempuan'], null, ['class' => 'form-control required'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">

                                            {!! Form::label('tanggal_lahir', 'Tanggal Lahir')!!}
                                            {!! Form::text('tanggal_lahir', null, ['class' => 'form-control tanggal'])!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('nama_ibu', 'Nama Ibu')!!}
                                            {!! Form::text('nama_ibu', 'Nama Ibu', ['class' => 'form-control hh'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('nama_ayah', 'Nama Ayah')!!}
                                            {!! Form::text('nama_ayah', null, ['class' => 'form-control hh'])!!}
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('no_telp', 'Nomor Telepon')!!}
                                            {!! Form::text('no_telp', null, ['class' => 'form-control hh'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('panggilan', 'Panggilan')!!}
                                            {!! Form::select('panggilan', $panggilan, null, ['class' => 'form-control hh required'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('punya_asuransi', 'Punya Asuransi')!!} <br>
                                            {!! Form::checkbox('punya_asuransi', 0, false, ['id' => 'CheckBox1'])!!}
                                        </div>
                                    </div>
                                </div>
                                 <div class="displayNone transition" id="xx">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-63">
                                            <div class="form-group">
                                              {!!Form::label('asuransi_id', 'Asuransi')!!}
                                              {!!Form::select('asuransi_id', $asuransi, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true'])!!}
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                                            <div class="form-group">
                                                {!! Form::label('jenis_peserta', 'Jenis Peserta')!!}

                                                {!! Form::select('jenis_peserta', $jenis_peserta, null, ['class' => 'form-control tog hh'])!!}
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                                            <div class="form-group">
                                                {!! Form::label('nomor_asuransi', 'Nomor Asuransi')!!}
                                                {!! Form::text('nomor_asuransi', null, ['class' => 'form-control tog hh'])!!}
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                                            <div class="form-group">
                                                {!! Form::label('nama_peserta', 'Nama Peserta')!!}
                                                {!! Form::text('nama_peserta', null, ['class'=>'form-control tog hh'])!!}
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            {!! Form::label('alamat', null)!!}
                                            {!! Form::textarea('alamat', null, ['class' => 'form-control textareacustom'])!!}
                                        </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                          @include('antrianpolis.webcamForm', [
                                          'image' => null,
                                          'ktp_image' => null,
                                          'subject'   => 'Pasien'
                                          ])
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="submitPasien" value="opop">Submit</button>
                            <button type="button" class="btn btn-danger" id="closeModal" data-dismiss="modal">Cancel</button>
                 {!! Form::close() !!}
            </div>
        </div>
        </div>
    </div>

     <div class="modal fade bs-example-modal-sm" id="kriteria" tabindex="-1" role="dialog" aria-labelledby="kriteriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="kriteriaLabel">Tambahkan Kriteria Pencarian</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt" value="Nomor Status">Nomor Status</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt" value="Nama Asuransi">Nama Asuransi</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt" value="Nama Peserta">Nama Peserta</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt" value="Nomor Asuransi">Nomor Asuransi</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt" value="Nama Ibu">Nama Ibu</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt"value="Nama Ayah">Nama Ayah</label>
                            </div>
                        </div>
                    </div>
                        
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Selesai</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Masukkan ke antrian</h4>
                </div>
                <div class="modal-body">
                    <form action="antrianpolis" method="post">
                        <input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <img src="" alt="" width="220px" height="165px" id="imageForm" class="image" >
                            </div>
                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                        <div class="form-group">
                                            <label for="namaPasien" class="control-label">Nama Pasien</label>
                                            <label class="form-control" id="lblInputNamaPasien"></label>
                                            <input type="text" class="displayNone" name="nama" id="namaPasien"/>
                                            <input type="text" class="displayNone" name="pasien_id" id="ID_PASIEN"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="form-group">
                                            <label for="nama" class="control-label">Antrian</label>
                                            <input type="text" class="form-control angka" name="antrian" id="antrian" required/>
                                            <div id="validasiAntrian"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Poli:</label>
                                            {!! Form::select('poli', $poli, null, ['class' => 'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Dokter</label>
                                            {!! Form::select('staf_id', $staf, null, [
                                            'class' => 'form-control selectpick',
                                            'data-live-search' => 'true'
                                            ])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Pembayarans</label>
                                            <select id="ddlPembayaran" class="form-control" name="asuransi_id" required>
                                                <option value="">- Pilih Pembayaran -</option>
                                                <option value="0">Biaya Pribadi</option>
                                            </select>
                                            <input type=text id="TextBox2" class="displayNone"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <button type="button" class="btn btn-danger btn-block" id="btnComplain" onclick='adaComplain(this);return false;'>Apakah Pasien Komplain?</button>
                                        <div class="panel panel-danger" id="timbul">
                                              <div class="panel-heading">
                                                    <h3 class="panel-title">Formulir Komplain</h3>
                                              </div>
                                              <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="">Pasien Komplain Atas Pelayanan Siapa?</label>
                                                            {!! Form::select('staf_id_complain', $staf, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true', 'id' => 'staf_id_complain'])!!}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="">Alasan Komplain</label>
                                                                {!! Form::textarea('complain', null, ['class' => 'form-control textareacustom', 'id' => 'complain'])!!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <button type="button" class="btn btn-success btn-block" onclick="dummy2(event);return false;">Submit</button>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        <button type="button" class="btn btn-danger btn-block" onclick="cancelComplain();return false;">Cancel</button>
                                                    </div>
                                                </div>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                <div class="modal-footer" id="modal-footer">
                    <div class="row">
                      <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 red text-left">
                         @include('peringatanbpjs', ['ns' => false])
                      </div>
                      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <button type="button" class="btn btn-success" id="dummyButton">Masukkan</button>
                        <input type="submit" name="submit" id="submit" class="btn btn-success displayNone" value="Masukkan"/>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="modalClose()">Close</button>
                      </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>  
<div class="modal fade" tabindex="-1" role="dialog" id="confirm_staf">
  <div class="modal-dialog">
  {!! Form::open(['url'=>'pasiens/ajax/confirm_staf', 'method'=> 'post', 'autocomplete' => 'off']) !!} 
<input style="display:none"><input type="password" style="display:none">
    <input type="hidden" name="pasien_id" id="pasien_id_stafs" value=""> 
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Konfirmasi Staf</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger">
            <h4>Riwayat Pemeriksaan Pasien Adalah RAHASIA</h4>
            <p>Hanya Dokter / Staf yang pernah periksa pasien ini yang memiliki wewenang untuk melihat riwayat pasien</p>
        </div> 
        <div class="form-group">
          {!! Form::label('email', 'Email') !!}
          {!! Form::text('email' , null, ['class' => 'form-control rq', 'autocomplete' => 'off']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('password', 'Password') !!}
          {!! Form::password('password',  array('placeholder' => 'password', 'class'=>'form-control rq', 'autocomplete' => 'false'))!!}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="confirmStaf(this);return false;">Submit</button>
        {!! Form::submit('Submit', ['class' => 'hide', 'id' => 'submit_confirm_staf']) !!}
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
    {!! Form::close() !!}
  </div><!-- /.modal-dialog -->
</div>
@stop
@section('footer') 
<script>
  var base = "{{ url('/') }}";
</script>
{!! HTML::script('js/plugins/webcam/photo.js')!!}
{!! HTML::script('js/togglepanel.js')!!}

<script type="text/javascript">

    $(document).ready(function() {

        $('#confirm_staf').on('show.bs.modal', function(){
            $('#confirm_staf input[type!="hidden"]').val('');
        });

        $('#confirm_staf').on('shown.bs.modal', function(){
            $('#email').focus();
            // setTimeout(function(){ $('#email').focus(); }, 300);
        });

       var request;
        $('#dummyButton').click(function(e) {
                 if(
                    $('select[name="staf_id"]').val() == '' ||
                    $('select#ddlPembayaran').val() == '' ||
                    $('select[name="poli"]').val() == '' ||
                    $('input[name="antrian"]').val() == '' ){

                    if($('select[name="staf_id"]').val() == '' ){
                        validasi('select[name="staf_id"]', 'Harus Diisi');
                    }

                    if($('select[name="poli"]').val() == '' ){
                        validasi('select[name="poli"]', 'Harus Diisi');
                    }

                    if($('input[name="antrian"]').val() == '' ){
                        validasi('input[name="antrian"]', 'Harus Diisi');
                    }

                    if($('select#ddlPembayaran').val() == '' ){

                        console.log('asuransi_id = ' + $('select#ddlPembayaran').val());
                        validasi('select#ddlPembayaran', 'Harus Diisi');
                    }

                } else {
               lanjutSubmit(e);
                
            }
        });

        $('#pasienInsert').on('shown.bs.modal', function () {
            $('.hh').val('');
            $('#CheckBox1').prop('checked', false); // Unchecks it
        });

        $('#submitPasien').click(function(e){
            e.preventDefault();
            var data = $('#pasienInsertForm').serializeArray();
            var url = $('#pasienInsertForm').attr('action');

            if($('#pasienInsertForm input[name="nama"]').val() == '' || $('#pasienInsertForm select[name="sex"]').val() == '' || $('#pasienInsertForm select[name="panggilan"]').val() == ''){

                if($('#pasienInsertForm input[name="nama"]').val() == ''){
                    validasi('#pasienInsertForm input[name="nama"]', '<code>Harus Diisi</code>');
                }
                if($('#pasienInsertForm select[name="sex"]').val() == ''){
                    validasi('#pasienInsertForm select[name="sex"]', '<code>Harus Diisi</code>');
                }
                if($('#pasienInsertForm select[name="panggilan"]').val() == ''){
                    validasi('#pasienInsertForm select[name="panggilan"]', '<code>Harus Diisi</code>');
                }
                // $(this).closest('.form-group').find('code').hide().fadeIn(500);
            } else {
                $.post(url, data, function(result) {
                    
                    var DDID_PASIEN     = $('#id').closest('th').hasClass('displayNone');
                    var DDID_ASURANSI   = $('#nama_asuransi').closest('th').hasClass('displayNone');
                    var DDnomorAsuransi = $('#nomor_asuransi').closest('th').hasClass('displayNone');
                    var DDnamaPeserta   = $('#nama_peserta').closest('th').hasClass('displayNone');
                    var DDnamaIbu       = $('#nama_ibu').closest('th').hasClass('displayNone');
                    var DDnamaAyah      = $('#nama_ayah_Input').closest('th').hasClass('displayNone');


                    console.log(result);

                    $('#closeModal').click();
                    $('form#pasienInsertForm').find("input, textarea, select").val("");
                    $('.transition').hide();

                    temp = "<tr style='background-color:orange;'>";

                    if(DDID_PASIEN){
                        temp += "<td nowrap class='displayNone'><div>" + result[0].id + "</div></td>";
                    } else {
                        temp += "<td nowrap><div class='invisible'>" + result[0].id + "</div></td>";
                    }
                    temp += "<td nowrap><div class='invisible'>" + result[0].nama + "</div></td>";
                    temp += "<td nowrap><div class='invisible'>" + result[0].alamat + "</div></td>";
                    temp += "<td nowrap><div class='invisible'>" + result[0].tanggal_lahir + "</div></td>";
                    temp += "<td nowrap><div class='invisible'>" + result[0].no_telp + "</div></td>";
                    if(DDID_ASURANSI){
                        temp += "<td nowrap class='displayNone'><div>" + result[0].nama_asuransi + "</div></td>";
                    } else {
                        temp += "<td nowrap><div class='invisible'>" + result[0].nama_asuransi + "</div></td>";
                    }
                    if(DDnomorAsuransi){
                        temp += "<td nowrap class='displayNone'><div>" + result[0].nomor_asuransi + "</div></td>";
                    } else {
                        temp += "<td nowrap><div class='invisible'>" + result[0].nomor_asuransi + "</div></td>";
                    }
                    if(DDnamaPeserta){
                        temp += "<td nowrap class='displayNone'><div>" + result[0].nama_peserta + "</div></td>";
                    } else{
                        temp += "<td nowrap><div class='invisible'>" + result[0].nama_peserta + "</div></td>";
                    }
                    if(DDnamaIbu){
                        temp += "<td nowrap class='displayNone'><div>" + result[0].nama_ibu + "</div></td>";
                    } else {
                        temp += "<td nowrap><div class='invisible'>" + result[0].nama_ibu + "</div></td>";
                    }
                    if(DDnamaAyah){
                        temp += "<td nowrap class='displayNone'><div>" + result[0].nama_ayah + "</div></td>";
                    } else {
                        temp += "<td nowrap><div class='invisible'>" + result[0].nama_ayah + "</div></td>";
                    }

                    temp += "<td nowrap class='displayNone'><div>" + result[0].asuransi_id + "</div></td>";
                    temp += "<td nowrap class='displayNone'><div>" + result[0].image + "</div></td>";
                    temp += "<td nowrap nowrap><div class='invisible'><a href=\"#\" style=\"color: green; font-size: large;\" onclick=\"rowEntry(this);\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Klik untuk periksa pasien\"><span class=\"glyphicon glyphicon-log-in\" aria-hidden=\"true\"></span></a>";
                    temp += "&nbsp;&nbsp;&nbsp;<a href=\"pasiens/" + result[0].id + "/edit\" style=\"color: ##337AB7; font-size: large;\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Klik untuk ubah data pasien\"><span aria-hidden=\"true\" class=\"glyphicon glyphicon-edit\"></span></a>";
                    temp += "&nbsp;&nbsp;&nbsp;<a onclick='confirmStafModal();' data-value=\"pasiens/" + result[0].id + "\" style=\"color: orange; font-size: large;\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Klik untuk melihat riwayat pasien\"><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"true\"></span></a></td>";
                   temp += "</tr>";

                    $('#ajax').prepend(temp);
                    $('#ajax tr:first-child td div').hide().removeClass('invisible').slideDown('500', function() {
                        $('#ajax tr:first-child').addClass('loaded');
                    });
                });
            }
        });
        $('.required').keypress(function(e) {
            $(this).closest('.form-group').removeClass('has-error');
            $(this).closest('.form-group').find('code').fadeOut('500', function() {
                $(this).closest('.form-group').find('code').remove();
            });
        });

        selectPasien();

        $('.ajaxselectpasien').keyup(function(e) {
            selectPasien();
        });

        $('#CheckBox1').click(function () {
            if ($(this).is(':checked')) {
                $('.transition').hide().removeClass('displayNone').slideDown('fast', function() {
                    $('#asuransi_id').focus();
                });
            } else if (!$(this).is(':checked')) {
                $('.transition').slideUp(300);
                $('.tog').val('');
            }
        });

        $('input[type="radio"][name="opt"]').change(function(e) {
            var $id = $('#id').closest('th');
            var $nama_asuransi = $('#nama_asuransi').closest('th');
            var $nomor_asuransi = $('#nomor_asuransi').closest('th');
            var $nama_peserta = $('#nama_peserta').closest('th');
            var $nama_ibu = $('#nama_ibu').closest('th');
            var $nama_ayah = $('#nama_ayah_Input').closest('th');

            if(this.value == "Nomor Status") {

                $id.toggleClass('displayNone');

                if(!$nama_asuransi.hasClass('displayNone')){
                   $nama_asuransi.toggleClass('displayNone');
                }
                if(!$nomor_asuransi.hasClass('displayNone')){
                   $nomor_asuransi.toggleClass('displayNone');
                }
                if(!$nama_peserta.hasClass('displayNone')){
                    $nama_peserta.toggleClass('displayNone');
                }
                if(!$nama_ibu.hasClass('displayNone')){
                    $nama_ibu.toggleClass('displayNone');
                }
                if(!$nama_ayah.hasClass('displayNone')){
                    $nama_ayah.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();

            } else if (this.value == "Nama Asuransi") {

                $nama_asuransi.toggleClass('displayNone');

                if(!$id.hasClass('displayNone')){
                   $id.toggleClass('displayNone');
                }
                if(!$nomor_asuransi.hasClass('displayNone')){
                   $nomor_asuransi.toggleClass('displayNone');
                }
                if(!$nama_peserta.hasClass('displayNone')){
                    $nama_peserta.toggleClass('displayNone');
                }
                if(!$nama_ibu.hasClass('displayNone')){
                    $nama_ibu.toggleClass('displayNone');
                }
                if(!$nama_ayah.hasClass('displayNone')){
                    $nama_ayah.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();
            } else if (this.value == "Nomor Asuransi") {

                $nomor_asuransi.toggleClass('displayNone');

                if(!$nama_asuransi.hasClass('displayNone')){
                   $nama_asuransi.toggleClass('displayNone');
                }
                if(!$id.hasClass('displayNone')){
                   $id.toggleClass('displayNone');
                }
                if(!$nama_peserta.hasClass('displayNone')){
                    $nama_peserta.toggleClass('displayNone');
                }
                if(!$nama_ibu.hasClass('displayNone')){
                    $nama_ibu.toggleClass('displayNone');
                }
                if(!$nama_ayah.hasClass('displayNone')){
                    $nama_ayah.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();
            } else if (this.value == "Nama Peserta") {

                $nama_peserta.toggleClass('displayNone');

                if(!$nama_asuransi.hasClass('displayNone')){
                   $nama_asuransi.toggleClass('displayNone');
                }
                if(!$nomor_asuransi.hasClass('displayNone')){
                   $nomor_asuransi.toggleClass('displayNone');
                }
                if(!$id.hasClass('displayNone')){
                    $id.toggleClass('displayNone');
                }
                if(!$nama_ibu.hasClass('displayNone')){
                    $nama_ibu.toggleClass('displayNone');
                }
                if(!$nama_ayah.hasClass('displayNone')){
                    $nama_ayah.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();
            } else if (this.value == "Nama Ibu") {

                $nama_ibu.toggleClass('displayNone');

                if(!$nama_asuransi.hasClass('displayNone')){
                   $nama_asuransi.toggleClass('displayNone');
                }
                if(!$nomor_asuransi.hasClass('displayNone')){
                   $nomor_asuransi.toggleClass('displayNone');
                }
                if(!$nama_peserta.hasClass('displayNone')){
                    $nama_peserta.toggleClass('displayNone');
                }
                if(!$id.hasClass('displayNone')){
                    $id.toggleClass('displayNone');
                }
                if(!$nama_ayah.hasClass('displayNone')){
                    $nama_ayah.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();
            } else if (this.value == "Nama Ayah") {

                $nama_ayah.toggleClass('displayNone');

                if(!$nama_asuransi.hasClass('displayNone')){
                   $nama_asuransi.toggleClass('displayNone');
                }
                if(!$nomor_asuransi.hasClass('displayNone')){
                   $nomor_asuransi.toggleClass('displayNone');
                }
                if(!$nama_peserta.hasClass('displayNone')){
                    $nama_peserta.toggleClass('displayNone');
                }
                if(!$nama_ibu.hasClass('displayNone')){
                    $nama_ibu.toggleClass('displayNone');
                }
                if(!$id.hasClass('displayNone')){
                    $id.toggleClass('displayNone');
                }

                $('.form-control-inline').val('');
                        selectPasien();
            } 
        });
    });
</script>
<script>
    function selectPasien(){

            var url = $('form#ajaxkeyup').attr('action');
            var data = $('form#ajaxkeyup').serializeArray();

            var DDID_PASIEN = $('#id').closest('th').hasClass('displayNone');
            var DDID_ASURANSI = $('#nama_asuransi').closest('th').hasClass('displayNone');
            var DDnomorAsuransi = $('#nomor_asuransi').closest('th').hasClass('displayNone');
            var DDnamaPeserta = $('#nama_peserta').closest('th').hasClass('displayNone');
            var DDnamaIbu = $('#nama_ibu').closest('th').hasClass('displayNone');
            var DDnamaAyah = $('#nama_ayah_Input').closest('th').hasClass('displayNone');

            $.get(url, data, function(MyArray) {
                MyArray = $.parseJSON(MyArray);
                var temp = "";
                 for (var i = 0; i < MyArray.length; i++) {
                    temp += "<tr>";
                    if(DDID_PASIEN){
                        temp += "<td nowrap class='displayNone'><div>" + MyArray[i].ID_PASIEN + "</div></td>";
                    } else {
                        temp += "<td nowrap class=''><div>" + MyArray[i].ID_PASIEN + "</div></td>";
                    }
                    temp += "<td nowrap><div>" + MyArray[i].namaPasien + "</div></td>";
                    temp += "<td><div>" + MyArray[i].alamat + "</div></td>";
                    temp += "<td nowrap><div>" + MyArray[i].tanggalLahir + "</div></td>";
                    temp += "<td nowrap><div>" + MyArray[i].noTelp + "</div></td>";
                    if(DDID_ASURANSI){
                        temp += "<td nowrap class='displayNone'><div>" + MyArray[i].namaAsuransi + "</div></td>";
                    } else {
                        temp += "<td nowrap class=''><div>" + MyArray[i].namaAsuransi + "</div></td>";
                    }
                    if(DDnomorAsuransi){
                        temp += "<td nowrap class='displayNone'><div>" + MyArray[i].nomorAsuransi + "</div></td>";
                    } else {
                        temp += "<td nowrap class=''><div>" + MyArray[i].nomorAsuransi + "</div></td>";
                    }
                    if(DDnamaPeserta){
                        temp += "<td nowrap class='displayNone'><div>" + MyArray[i].namaPeserta + "</div></td>";
                    } else{
                        temp += "<td nowrap class=''><div>" + MyArray[i].namaPeserta + "</div></td>";
                    }
                    if(DDnamaIbu){
                        temp += "<td nowrap class='displayNone'><div>" + MyArray[i].namaIbu + "</div></td>";
                    } else {
                        temp += "<td nowrap class=''><div>" + MyArray[i].namaIbu + "</div></td>";
                    }
                    if(DDnamaAyah){
                        temp += "<td nowrap class='displayNone'><div>" + MyArray[i].namaAyah + "</div></td>";
                    } else {
                        temp += "<td nowrap class=''><div>" + MyArray[i].namaAyah + "</div></td>";
                    }

                    temp += "<td nowrap class='displayNone'><div>" + MyArray[i].asuransi_id + "</div></td>";
                    temp += "<td nowrap class='displayNone'><div>" + MyArray[i].image + "</div></td>";
                    temp += "<td nowrap nowrap><div><a href=\"#\" style=\"color: green; font-size: large;\" onclick=\"rowEntry(this);\"><span class=\"glyphicon glyphicon-log-in\" aria-hidden=\"true\"></span></a>";
                    temp += "&nbsp;&nbsp;&nbsp;<a href=\"pasiens/" + MyArray[i].ID_PASIEN + "/edit\" style=\"color: ##337AB7; font-size: large;\"><span aria-hidden=\"true\" class=\"glyphicon glyphicon-edit\"></span></a>";
                    temp += "&nbsp;&nbsp;&nbsp;<a data-value='" + MyArray[i].ID_PASIEN + "' onclick='confirmStafModal(this);' href='#' style=\"color: orange; font-size: large;\" ><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"true\"></span></a> </td>";
         
                    temp += "</tr>";
                 }
                 $('#ajax').html(temp);
            });
    }
</script>

<script>
        function rowEntry(control) {
            var ID = $(control).closest('tr').find('td:first-child div').html();
            var nama = $(control).closest('tr').find('td:nth-child(2) div').html();
            var asuransi_id = $(control).closest('tr').find('td:nth-child(11) div').html();
            var image = $(control).closest('tr').find('td:nth-child(12) div').html();
            var nama_asuransi = $(control).closest('tr').find('td:nth-child(6) div').html();
            var option_asuransi = '<option value="">- Pilih Pembayaran -</option>';
            option_asuransi += '<option value="0">Biaya Pribadi</option>';

            $('#cekBPJSkontrol').hide();
            $('#cekGDSBPJS').hide();
             console.log('ID = ' + ID);
             console.log('nama = ' + nama);
             console.log('asuransi_id = ' + asuransi_id);
             console.log('image = ' + image);
             console.log('nama_asuransi = ' + nama_asuransi);
             console.log('option_asuransi = ' + option_asuransi);

             if (asuransi_id == '32') {
                $.post('{{ url("pasiens/ajax/cekbpjskontrol") }}', {'pasien_id': ID, 'asuransi_id' : asuransi_id}, function(data, textStatus, xhr) {
                  /*optional stuff to do after success */
                  MyArray = $.parseJSON(data);
                  var data = MyArray.kode;
                  var tanggal = MyArray.tanggal;
                  if (tanggal == '') {
                    var text = 'GDS gratis untuk BPJS hanya untuk riwayat kencing manis atau usia > 50 tahun'
                  } else {
                    var text = 'Pasien sudah periksa GDS bulan ini tanggal ' + tanggal;
                  }
                  $('#karena').html(text)

                  if (data == '3') {
                    $('#cekBPJSkontrol').show();
                    $('#cekGDSBPJS').show();
                  } else if(data == '2'){
                    $('#cekBPJSkontrol').show();
                    $('#cekGDSBPJS').hide();
                  } else if(data == '1'){
                    $('#cekBPJSkontrol').hide();
                    $('#cekGDSBPJS').show();
                  } else {
                    $('#cekBPJSkontrol').hide();
                    $('#cekGDSBPJS').hide();
                  }
                });
             } else {
              $('#cekBPJSkontrol').hide();
             }

             imgError();

            if (asuransi_id != '0') {
                option_asuransi += '<option value="' + asuransi_id + '">' + nama_asuransi + '</option>'
            };

            $('#lblInputNamaPasien').html(ID + ' - ' + nama)
                .closest('.form-group')
                .removeClass('has-error')
                .find('code')
                .remove();
            $('#namaPasien').val(nama);
            $('#imageForm').attr('src', image);
            $('#ID_PASIEN').val(ID);
            $("#ddlPembayaran").html(option_asuransi);
            resetComplain();
            $('#exampleModal').modal('show');
            return false;


        }
        function resetComplain(){
            $('#timbul').hide();
            $('#modal-footer').show();
            $('#btnComplain').show();
            $('#complain').val('');
            $('#staf_id_complain').val('').selectpicker('refresh');
        }

        function adaComplain(control){
            $(control).hide(0, function(){
                $('#timbul').slideDown(500, function() {
                    $('#staf_id_complain').closest('div').find('.btn-white').focus();
                });
            });
            $('#modal-footer').hide();

        }

        function dummy2(e){

             if($('select[name="staf_id"]').val() == '' ||
                    $('select#ddlPembayaran').val() == '' ||
                    $('select[name="poli"]').val() == '' ||
                    $('input[name="antrian"]').val() == '' ||
                    $('#staf_id_complain').val() == '' ||
                    $('#komplain').val() == ''

                ){

                    if($('select[name="staf_id"]').val() == '' ){
                        validasi('select[name="staf_id"]', 'Harus Diisi');
                    }

                    if($('select[name="poli"]').val() == '' ){
                        validasi('select[name="poli"]', 'Harus Diisi');
                    }

                    if($('input[name="antrian"]').val() == '' ){
                        validasi('input[name="antrian"]', 'Harus Diisi');
                    }

                    if($('select#ddlPembayaran').val() == '' ){

                        console.log('asuransi_id = ' + $('select#ddlPembayaran').val());
                        validasi('select#ddlPembayaran', 'Harus Diisi');
                    }

                                        if ($('#staf_id_complain').val() == '') {
                        validasi('#staf_id_complain', 'Harus Diisi!')
                    }
                    if ($('#staf_id_complain').val() == '') {
                        validasi('#komplain', 'Harus Diisi!')
                    }
             } else {

               lanjutSubmit(e);
             }
        }

        function lanjutSubmit(e){
             e.preventDefault();
                $.post('{{ url("pasiens/ajax/ajaxpasien") }}', {antrian: $('input[name="antrian"]').val(), 'pasien_id' : $('#ID_PASIEN').val()}, function(data) {

                    data = JSON.parse(data);
                    if(data.antrian == '' && data.pasien == ''){
                        $('#submit').click();
                    } else {
                        if(data.antrian != ''){
                            validasi('input[name="antrian"]', 'Sudah ada antrian <br /> nama : ' + data.antrian);
                        }
                        if(data.pasien != ''){
                            validasi('input[name="pasien_id"]', 'Pasien sudah di antrian');
                        }
                    }
                });
        }

        function modalClose(){
             $('#dummyButton').show();
             $('#dummyButton2').hide();
        }

        function cancelComplain(){
            $('#timbul').hide(0, function(){
                $('#modal-footer').slideDown(500);
                $('#btnComplain').slideDown(500);
                $('#complain').val('');
                $('#staf_id_complain').val('').selectpicker('refresh');
            });
        }
        function confirmStafModal(control){
            var pasien_id = $(control).attr('data-value');
            $('#confirm_staf').modal('show');
            $('#pasien_id_stafs').val(pasien_id);
        }
function confirmStaf(){
    if(validatePass()){
       $('#submit_confirm_staf').click(); 
    }    
}


    </script>

@stop
