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
		  <div class="table-responsive">
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
</div>
<div class="modal fade bs-example-modal-md" id="pasienInsert" tabindex="-1" role="dialog" aria-labelledby="kriteriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="kriteriaLabel">PASIEN INSERT</h4>
                </div>
				<div class="modal-body">
				
				@include('pasiens.modal_insert', [ 'rq' => false ])
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
{!! HTML::script('js/pasiens.js')!!}
@stop
