@extends('layout.master')

@section('title') 
Klinik Jati Elok | Tarif
@stop
@section('page-title') 

 <h2>Tarif</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Tarif</strong>
      </li>
</ol>
@stop
@section('content') 
<input type="hidden" id="token" value="{{ Session::token() }}">
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $tarifs->count() !!}</h3>
                </div>
                <div class="panelRight">
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalInsertJenisTarif" onclick><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Jenis Tarif Baru</a>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-striped table-bordered DT" id="table_tarif" >
                <thead>
                    <tr>
                        <th>jenis tarif id</th>
						<th>Jenis Tarif</th>
						<th>Tipe Tindakan</th>
                        <th >Biaya</th>
                        <th class="hide" >Dibayar Asuransi </th>
                        <th>Jasa Dokter</th>
                        <th class="displayNone">tipe_tindakan_id</th>
                        <th class="displayNone">tipe_laporan_admedika_id</th>
                        <th class="displayNone">bhp_items</th>
                        <th class="displayNone">asuransi_id</th>
						<th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarifs as $tarif)
                        <tr>
                            <td class="jenis_tarif_id"><div>{!!$tarif->jenis_tarif_id!!}</div></td>
                            <td class="jenis_tarif"><div>{!!$tarif->jenisTarif->jenis_tarif!!}</div></td>
                            @if ($tarif->tipe_tindakan_id == '1')
                              <td class="tipe_tindakan"> <div>Non Paket</div> </td>
                            @else
                              <td class="tipe_tindakan"> <div>Paket dengan Obat</div> </td>
                            @endif
                            <td class="biaya"><div class="uang">{!!$tarif->biaya!!}</div></td>
                            <td class="jasa_dokter"><div class="uang">{!!$tarif->jasa_dokter!!}</div></td>
                            <td class="hide tipe_tindakan_id"><div>{!!$tarif->tipe_tindakan_id!!}</div></td>
							<td class="hide tipe_laporan_admedika_id"><div>{!!$tarif->jenisTarif->tipe_laporan_admedika_id!!}</div></td>
							<td class="hide bhp_items"><div>{!!$tarif->jenisTarif->bhp!!}</div></td>
                            <td class="hide"><div>0</div></td>
                              {!! Form::open(['url' => 'tarifs/' .$tarif->id, 'method' => 'delete'])!!}
                              <td nowrap>
                                  <div>
                                      <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalUpadteJenisTarif" onclick="editRow(this)">edit</a>
                                {!! Form::submit('hapus', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Anda yakin mau menghapus ' .$tarif->jenis_tarif_id. ' - ' .$tarif->jenisTarif->jenis_tarif . ' dari Tarif?")'])!!}
                              {!! Form::close()!!}
                            </div></td>
                        </tr>
                   @endforeach
                </tbody>
            </table>
      </div>
</div>
<div class="modal fade bs-example-modal-md" id="modalInsertJenisTarif" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Insert Jenis Tarif Baru</h4>
       </div>
      <div class="modal-body">
        {!! Form::open(['url' => 'tarifs', 'method' => 'post', 'id' => 'insert_jt_form']) !!}
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                      {!! Form::label('jenis_tarif', 'Jenis Tarif')!!}
                      {!! Form::text('jenis_tarif', null, ['class' => 'form-control', 'id' => 'txtJenisTarifInsert'])!!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                    {!! Form::label('tipe_tindakan_id', 'Tipe Tindakan')!!}
                    {!! Form::select('tipe_tindakan_id', $tipeTindakans, '1', ['class' => 'form-control'])!!}

                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                      {!! Form::label('biaya')!!}
                      {!! Form::text('biaya', null, ['class' => 'form-control', 'id' => 'txtBiayaInsert'])!!}
                  </div>
                </div>
            </div>
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  
					<div class="form-group">
                    {!! Form::label('jasa_dokter', 'Jasa Dokter')!!}
                    {!! Form::text('jasa_dokter', null, ['class' => 'form-control', 'id' => 'txtJasaDokterInsert'])!!}
                  </div>

                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                      {!! Form::label('tipe_laporan_admedika_id', 'Tipe Laporan Admedika')!!}
					  {!! Form::select('tipe_laporan_admedika_id', [ null => '-Pilih-' ] + App\TipeLaporanAdmedika::lists('tipe_laporan_admedika', 'id')->all(),null, ['class' => 'form-control', 'id' => 'tipe_laporan_admedika_id'])!!}
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                  <h3 class="panel-title">Input Bahan Habis Pakai</h3>
                            </div>
                            <div class="panel-body">
                                  <table class="table table-condensed tfoot" id="tbl_bhp_insert">
                                      <thead>
                                          <tr>
                                              <th class="displayNone">id</th>
                                              <th>Merek Obat</th>
                                              <th>Jumlah</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                      <tbody id="ajax1">
                                          
                                      </tbody>
                                      <tfoot>
                                          <tr>
                                            <td class="displayNone"></td>
                                              <td style="width:65%;">
                                                <select name="merek_id" id="merek_id" class="form-control selectpick kosong" data-live-search="true" title="Nama Obat">

                                                    @foreach ($mereks as $merek)
                                                        <option value='{!! $merek->id !!}' data-subtext="{!!$merek->komposisi_bymerek!!}"><strong>{!!$merek->merek!!}</strong></option>
                                                    @endforeach

                                                </select>

                                              </td>
                                              <td><input type="text" class="form-control" id="jumlah"></td>
                                              <td><button onclick="insert_bhp(this); return false;" class="btn btn-success" id="submit_bhp">submit</button>
                                              <a href="#" onclick="submitID_MEREK($('#ID_JENIS_TARIF').val()); return false;" class="btn btn-success displayNone" id="inputID_MEREK">submit</a></td>
                                          </tr>
                                      </tfoot>
                                  </table>
                                    {!! Form::textarea('bhp_items', null, ['class' => 'hide', 'id' => 'bahan_habis_pakai'])!!}
                            </div>
                          </div>                      
                  </div>
              </div>
    </div>
</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-md" id="modalUpadteJenisTarif" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Jenis Tarif</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['id' => 'formUpdate', 'method' => 'PUT'])!!}
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                      {!! Form::label('jenis_tarif', 'Jenis Tarif')!!}
                      {!! Form::text('jenis_tarif', null, ['class' => 'form-control', 'id' => 'txtJenisTarifUpdate'])!!}
                  </div>
                </div>
            </div>
        {!! Form::close()!!}
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    {!! Form::label('tipe_tindakan_id', 'Tipe Tindakan')!!}
                    {!! Form::select('tipe_tindakan_id', $tipeTindakans, null, ['class' => 'form-control selectpick', 'id' => 'ddlTipeTindakanUpdate'])!!}
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                      {!! Form::label('biaya')!!}
                      {!! Form::text('biaya', null, ['class' => 'form-control', 'id' => 'txtBiayaUpdate'])!!}
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                      {!! Form::label('jasa_dokter')!!}
                      {!! Form::text('jasa_dokter', null, ['class' => 'form-control', 'id' => 'txtJasaDokterUpdate'])!!}
                      {!! Form::text('jenis_tarif_id', null, ['class' => 'displayNone', 'id' => 'txtJenisTarifIdUpdate'])!!}
                      {!! Form::text('asuransi_id', null, ['class' => 'displayNone', 'id' => 'txtAsuransiIdUpdate'])!!}
                  </div>
              </div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                      {!! Form::label('tipe_laporan_admedika_id', 'Tipe Laporan Admedika')!!}
					  {!! Form::select('tipe_laporan_admedika_id', [ null => '-Pilih-' ] + App\TipeLaporanAdmedika::lists('tipe_laporan_admedika', 'id')->all(),null, ['class' => 'form-control', 'id' => 'txtTipeLaporanAdmedikaUpdate'])!!}
                  </div>
                </div>
            </div>
            <input type="text" id="ID_JENIS_TARIF_UPDATE" class="displayNone">
                
            </div>
              <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                  <h3 class="panel-title">Input Bahan Habis Pakai</h3>
                            </div>
                            <div class="panel-body">
                                  <table class="table table-condensed" id="tbl_bhp_update">
                                      <thead>
                                          <tr>
                                              <th class="displayNone">id</th>
                                              <th>Merek Obat</th>
                                              <th>Jumlah</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          
                                      </tbody>
                                      <tfoot>
                                          <tr>
                                            <td class="displayNone"></td>
                                              <td style="width:65%;">
                                                <select name="" id="ID_MEREK_UPDATE" class="form-control selectpick" data-live-search="true" title="Nama Obat" >
                                                    @foreach ($mereks as $merek)
                                                        <option value='{!! $merek->id !!}' data-subtext="{!!$merek->komposisi_bymerek!!}"><strong>{!!$merek->merek!!}</strong></option>
                                                    @endforeach
                                                </select>
                                              </td>
                                              <td><input type="text" class="form-control" id="jumlah_UPDATE"></td>
                                              <td><a href="#" onclick="insert_bhp_update(); return false;" class="btn btn-success" id="inputID_MEREK_UPDATE_DUMMY">submit</a>
                                              <a href="#" onclick="submitID_MEREK_UPDATE(); return false;" class="btn btn-success displayNone" id="inputID_MEREK_UPDATE">submit</a></td>
                                          </tr>
                                      </tfoot>
                                  </table>
                                  {!! Form::textarea('bhp_items', null, ['class' => 'form-control displayNone', 'id' => 'bhp_items_update'])!!}
                            </div>
                          </div>                      
                  </div>
              </div>
		</div>
	</div>
{!! Form::close()!!}
    </div>
  </div>
</div>
@stop
@section('footer') 
<script>
  var data = [];
  var dataUpdate = [];
  var row_index;

  if($('#bahan_habis_pakai').val() != ''){
    data = JSON.parse($('#bahan_habis_pakai').val());
    view_bhp(data);
  }
  $(document).ready(function() {

    $('.btn-success').keypress(function(e) {
      var key = e.keyCode || e.which;

      if(key == 9){
        $(this).click();
      }

      return false;

    });
  });

  function editRow(control) {

        var jenis_tarif = $(control).closest('tr').find('.jenis_tarif div').html();
        var tipe_tindakan = $(control).closest('tr').find('.tipe_tindakan div').html();
        var biaya = $(control).closest('tr').find('.biaya div').html();
        var jasaDokter = $(control).closest('tr').find('.jasa_dokter div').html();
        var tipe_tindakan_id = $(control).closest('tr').find('.tipe_tindakan_id div').html();
        var bhp_items = $(control).closest('tr').find('.bhp_items div').html();
        var tipe_laporan_admedika_id = $(control).closest('tr').find('.tipe_laporan_admedika_id div').html();
        var jenis_tarif_id = $(control).closest('tr').find('.jenis_tarif_id div').html();
        var asuransi_id = '0';

        biaya = cleanUang(biaya);
        jasaDokter = cleanUang(jasaDokter);

        console.log('jenis_tarif = '+ jenis_tarif);
        console.log('tipe_tindakan = ' +tipe_tindakan);
        console.log('biaya = '+ biaya);
        console.log('jasaDokter = ' + jasaDokter);
        console.log('tipe_tindakan_id = ' + tipe_tindakan_id);
        console.log('bhp_items + '+ bhp_items);
        console.log('jenis_tarif_id = '+ jenis_tarif_id);
        console.log('asuransi_id + ' + asuransi_id);
        console.log('tipe_laporan_admedika_id = ' + tipe_laporan_admedika_id);
        console.log('bhp_items = ' + bhp_items);

        row_index = $(control).closest('tr').index() + 1;

        $('#txtJenisTarifUpdate').val(jenis_tarif);
        $('#ddlTipeTindakanUpdate').val(tipe_tindakan_id);
        $('#txtBiayaUpdate').val(biaya);
        $('#txtJasaDokterUpdate').val(jasaDokter);
        $('#txtJenisTarifIdUpdate').val(jenis_tarif_id);
        $('#txtAsuransiIdUpdate').val(asuransi_id);
        $('#txtTipeLaporanAdmedikaUpdate').val(tipe_laporan_admedika_id);

        if(bhp_items != ''){
          dataUpdate = JSON.parse(bhp_items);
        } else {
          dataUpdate = [];
        }

        view_bhp_update(dataUpdate);
  }

  function insert_bhp() {

    if($('#merek_id').val() == '' || $('#jumlah').val() == ''){
      if($('#merek_id').val() == '') {
        validasi('#merek_id', 'Harus Diisi!');
      }
      if($('#jumlah').val() == '') {
        validasi('#jumlah', 'Harus Diisi!');
      }
    } else {
      var merek = $('#merek_id option:selected').text();
      var merek_id = $('#merek_id').val();
      var jumlah = $('#jumlah').val();

      data[data.length] = {
        "merek" : merek,
        "merek_id" : merek_id,
        "jumlah" : jumlah
      };
      view_bhp(data);
    }

    
  }

  function insert_bhp_update() {

    if($('#ID_MEREK_UPDATE').val() == '' || $('#jumlah_UPDATE').val() == ''){
      if($('#ID_MEREK_UPDATE').val() == '') {
        validasi('#ID_MEREK_UPDATE', 'Harus Diisi!');
      }
      if($('#jumlah_UPDATE').val() == '') {
        validasi('#jumlah_UPDATE', 'Harus Diisi!');
      }
    } else {
      var merek = $('#ID_MEREK_UPDATE option:selected').text();
      var ID_MEREK_UPDATE = $('#ID_MEREK_UPDATE').val();
      var jumlah_UPDATE = $('#jumlah_UPDATE').val();

      dataUpdate[dataUpdate.length] = {
        "merek" : merek,
        "merek_id" : ID_MEREK_UPDATE,
        "jumlah" : jumlah_UPDATE
      };
      view_bhp_update(dataUpdate);
    }
  }
    function view_bhp(data){

      if (data.length > 0){
        var temp ='';

        for (var i = 0; i < data.length; i++) {
          temp += '<tr>';
          temp += '<td>' + data[i].merek + '</td>';
          temp += '<td>' + data[i].jumlah + '</td>';
          temp += '<td><button class="btn btn-danger btn-xs" onclick="del_ins(this); return false" value="' + i + '">hapus</button></td>';
          temp += '</tr>';
        }

        $('#tbl_bhp_insert tbody').html(temp);
        var string = JSON.stringify(data);
        $('#bahan_habis_pakai').val(string);

        $('#merek_id')
        .val('')
        .selectpicker('refresh')
        .closest('td')
        .find('.btn-white')
        .focus();
        $('#jumlah').val('');


      } else {
        $('#tbl_bhp_insert tbody').html('');
        $('#bahan_habis_pakai').val('[]');
      }
    }

    function view_bhp_update(dataUpdate){

      if (dataUpdate.length > 0){
        var temp ='';

        for (var i = 0; i < dataUpdate.length; i++) {
          temp += '<tr>';
          temp += '<td>' + dataUpdate[i].merek.merek + '</td>';
          temp += '<td>' + dataUpdate[i].jumlah + '</td>';
          temp += '<td><button class="btn btn-danger btn-xs" onclick="del_upd(this); return false" value="' + i + '">hapus</button></td>';
          temp += '</tr>';
        }

        $('#tbl_bhp_update tbody').html(temp);
        var string = JSON.stringify(dataUpdate);
        $('#bhp_items_update').val(string);

        $('#ID_MEREK_UPDATE')
        .val('')
        .selectpicker('refresh')
        .closest('td')
        .find('.btn-white')
        .focus();
        $('#jumlah_UPDATE').val('');


      } else {
        $('#tbl_bhp_update tbody').html('');
        $('#bhp_items_update').val('[]');
      }
    }

     function del_ins(control){

        var i = $(control).val();


        data.splice(i, 1);

        view_bhp(data);
      }
     function del_upd(control){

        var i = $(control).val();


        dataUpdate.splice(i, 1);

        view_bhp_update(dataUpdate);
      }

      function submitJT(){
        var jenis_tarif = $('#txtJenisTarifInsert').val();
        var tipe_tindakan_id = $('#tipe_tindakan_id').val();
        var tipe_tindakan = $('#tipe_tindakan_id option:selected').text();
        var bahanHabisPakai = $('#txtBahanHabisPakaiInsert').val();
        var biaya = $('#txtBiayaInsert').val();
        var jasa_dokter = $('#txtJasaDokterInsert').val();
        var jenis_tarif_id = $('#txtJenisTarifIdInsert').val();
        var asuransi_id = '0';
        var bhp_items = $('#bahan_habis_pakai').val();

          if(
            $('#txtJenisTarifInsert').val() == '' ||
            $('select[name="tipe_tindakan_id"]').val() == '' ||
            $('#txtBahanHabisPakaiInsert').val() == '' ||
            $('#txtBiayaInsert').val() == '' ||
            $('#txtJasaDokterInsert').val() == '') 
          {
            if($('#txtJenisTarifInsert').val() == ''){
              validasi('#txtJenisTarifInsert', 'Harus Diisi!');
            }
            if($('#select[name="tipe_tindakan_id"]').val() == ''){
              validasi('#select[name="tipe_tindakan_id"]', 'Harus Diisi!');
            }
            if($('#txtBahanHabisPakaiInsert').val() == ''){
              validasi('#txtBahanHabisPakaiInsert', 'Harus Diisi!');
            }
            if($('#txtBiayaInsert').val() == ''){
              validasi('#txtBiayaInsert', 'Harus Diisi!');
            }
            if($('#txtJasaDokterInsert').val() == ''){
              validasi('#txtJasaDokterInsert', 'Harus Diisi!');
            }
          } else {

            var param = $('#insert_jt_form').serializeArray();

            $.post('tarifs', param, function(result) {

            result = JSON.parse(result);

              if(result.jenis_tarif_id != '0'){
                
                  $('#modalInsertJenisTarif').modal('hide');

                    var temp = '<tr>';

                    biaya = uang(biaya);
                    jasa_dokter = uang(jasa_dokter);

                    temp += '<td><div>' + result.jenis_tarif_id + '</div></td>';
                    temp += '<td><div>' + jenis_tarif + '</div></td>';
                    temp += '<td><div>' + tipe_tindakan + '</div></td>';
                    temp += '<td class="text-right"><div>' + biaya + '</div></td>';
                    temp += '<td class="text-right"><div>' + 'Rp. ,-' + '</div></td>';
                    temp += '<td class="displayNone"><div>' + jasa_dokter + '</div></td>';
                    temp += '<td class="displayNone"><div>' + uang( bahanHabisPakai ) + '</div></td>';
                    temp += '<td class="displayNone"><div>' + tipe_tindakan_id + '</div></td>';
                    temp += '<td class="displayNone"><div>' + bhp_items + '</div></td>';
                    temp += '<td class="displayNone"><div>' + result.jenis_tarif_id + '</div></td>';
                    temp += '<td class="displayNone"><div>' + asuransi_id + '</div></td>';
                    temp += "<td nowrap><div><form method='post' action='{!! url('tarifs/" + result.id + "')!!}'><input type=\"hidden\" value=\"DELETE\" name=\"_method\"><input type=\"hidden\" name=\"_token\" value=\"<?php echo csrf_token(); ?>\">";
                    temp += "<a href=\"#\" class=\"btn btn-success btn-sm\" data-toggle=\"modal\" data-target=\""
                    temp += "#modalUpadteJenisTarif\" onclick=\"editRow(this)\">edit</a> ";
                    temp += "<input type='submit' value='hapus' class='btn btn-danger btn-sm' onclick='return confirm(\"Anda yakin mau menghapus " + result.jenis_tarif_id + " - " + jenis_tarif +  " dari Tarif?\")' /></div></td>";
                    temp += "</form></tr>";

                    $('#table_tarif tbody').prepend(temp)
                    $('#table_tarif tbody tr:first-child').find('div').closest('td').addClass('yellow');
                    $('#table_tarif tbody tr:first-child').find('div').hide().slideDown('500', function() {
                        $(this).closest('td').addClass('loaded');
                    });;
                 }
            });
          }
      }
      function submitJT_update(){
        var jenis_tarif = $('#txtJenisTarifUpdate').val();
        var tipe_tindakan_id = $('#ddlTipeTindakanUpdate').val();
        var tipe_tindakan = $('#ddlTipeTindakanUpdate option:selected').text();
        var bahan_habis_pakai = $('#txtBahanHabisPakaiUpdate').val();
        var biaya = $('#txtBiayaUpdate').val();
        var jasa_dokter = $('#txtJasaDokterUpdate').val();
        var jenis_tarif_id = $('#txtJenisTarifIdUpdate').val();
        var asuransi_id = $('#txtAsuransiIdUpdate').val();
        var bhp_items = $('#bhp_items_update').val();
        
       console.log('jenis_tarif = ' + jenis_tarif);
       console.log('tipe_tindakan_id = ' + tipe_tindakan_id);
       console.log('tipe_tindakan = ' + tipe_tindakan);
       console.log('bahan_habis_pakai = ' + bahan_habis_pakai);
       console.log('biaya = ' + biaya);
       console.log('jasa_dokter = ' + jasa_dokter);
       console.log('jenis_tarif_id = ' + jenis_tarif_id);
       console.log('asuransi_id = ' + asuransi_id);
       console.log('bhp_items = ' + bhp_items);

          if(
            $('#txtJenisTarifUpdate').val() == '' ||
            $('#ddlTipeTindakanUpdate').val() == '' ||
            $('#txtBahanHabisPakaiUpdate').val() == '' ||
            $('#txtBiayaUpdate').val() == '' ||
            $('#txtJasaDokterUpdate').val() == '')
          {
            if($('#txtJenisTarifUpdate').val() == ''){
              validasi('#txtJenisTarifUpdate', 'Harus Diisi!');
            }
            if($('#ddlTipeTindakanUpdate').val() == ''){
              validasi('#ddlTipeTindakanUpdate', 'Harus Diisi!');
            }
            if($('#txtBahanHabisPakaiUpdate').val() == ''){
              validasi('#txtBahanHabisPakaiUpdate', 'Harus Diisi!');
            }
            if($('#txtBiayaUpdate').val() == ''){
              validasi('#txtBiayaUpdate', 'Harus Diisi!');
            }
            if($('#txtJasaDokterUpdate').val() == ''){
              validasi('#txtJasaDokterUpdate', 'Harus Diisi!');
            }
          } else {

            var jenis_tarif_id = $('#txtJenisTarifIdUpdate').val()  ;
              $.ajax({
                url: '{{ url("update/tarifs") }}',
                type: 'POST',
                data: {
                  'jenis_tarif'       : jenis_tarif,
                  'tipe_tindakan_id'  : tipe_tindakan_id,
                  'biaya'             : biaya,
                  'bahan_habis_pakai' : bahan_habis_pakai,
                  'jasa_dokter'       : jasa_dokter,
                  'bhp_items'         : bhp_items,
                  'jenis_tarif_id'    : jenis_tarif_id,
                  'asuransi_id'       : asuransi_id
                }
              })
              .done(function(result) {
                  result = JSON.parse(result);
                  if(result.jenis_tarif_id != '0'){
                    
                    biaya = uang(biaya);
                    jasa_dokter = uang(jasa_dokter);
                    bahan_habis_pakai = uang(bahan_habis_pakai);
                    if(bahan_habis_pakai == ''){
                        bahan_habis_pakai = '0';
                    }

                    console.log('biaya = ' + biaya);
                    console.log('bahan_habis_pakai = ' + bahan_habis_pakai);
                    var biaya_total = parseInt(biaya) + parseInt(bahan_habis_pakai);
                    console.log('biaya_total = ' + biaya_total);
                    $('#modalUpadteJenisTarif').modal('hide');
                      var $edit = $('#table_tarif tbody tr:nth-child(' + row_index + ')');
                      
                      $('#table_tarif tbody tr:nth-child(' + row_index + ')').find('td').find('div').slideUp('500', function(){
                            $edit.find('td:nth-child(1)').find('div').html(result.jenis_tarif_id);
                            $edit.find('td:nth-child(2)').find('div').html(jenis_tarif);
                            $edit.find('td:nth-child(3)').find('div').html(tipe_tindakan);
                            $edit.find('td:nth-child(4)').find('div').html(biaya);
                            $edit.find('td:nth-child(5)').find('div').html(uang('0'));
                            $edit.find('td:nth-child(6)').find('div').html(jasa_dokter);
                            $edit.find('td:nth-child(7)').find('div').html(bahan_habis_pakai);
                            $edit.find('td:nth-child(8)').find('div').html(tipe_tindakan_id);
                            $edit.find('td:nth-child(9)').find('div').html(bhp_items);
                            $edit.find('td:nth-child(10)').find('div').html(result.jenis_tarif_id);
                            $edit.find('td:nth-child(11)').find('div').html(asuransi_id);
                            $edit.find('td').removeClass('loaded').addClass('yellow');
                            $edit.find('td').find('div').slideDown('500', function(){
                                $edit.find('td').removeClass('yellow').addClass('loaded');                                                              
                            });                                                              
                      });
                  }
              })
              .fail(function() {
                console.log("error");
              });
          }
      }
</script>
@stop
