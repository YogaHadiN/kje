@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Tarif
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
		  <div class="table-responsive">
				<table class="table table-striped table-bordered DT" id="table_tarif" >
					<thead>
						<tr>
							<th>jenis tarif id</th>
							<th>Jenis Tarif</th>
							<th>Tipe Tindakan</th>
							<th >Biaya</th>
							<th>Jasa Dokter</th>
							<th class="displayNone">tipe_tindakan_id</th>
							<th class="displayNone">tipe_laporan_admedika_id</th>
							<th class="displayNone">bhp_items</th>
							<th class="displayNone">Murni Jasa Dokter</th>
							<th class="displayNone">asuransi_id</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($tarifs as $tarif)
							<tr>
								<td class="jenis_tarif_id"><div>{!!$tarif->jenis_tarif_id!!}</div></td>
								<td class="jenis_tarif"><div>{!!$tarif->jenisTarif->jenis_tarif!!}</div></td>
								<td class="tipe_tindakan"> <div>{!! $tarif->tipeTindakan->tipe_tindakan !!}</div> </td>
								<td class="biaya"><div class="uang">{!!$tarif->biaya!!}</div></td>
								<td class="jasa_dokter"><div class="uang">{!!$tarif->jasa_dokter!!}</div></td>
								<td class="hide tipe_tindakan_id"><div>{!!$tarif->tipe_tindakan_id!!}</div></td>
								<td class="hide tipe_laporan_admedika_id"><div>{!!$tarif->jenisTarif->tipe_laporan_admedika_id!!}</div></td>
								<td class="hide bhp_items"><div>{!!$tarif->jenisTarif->bhp!!}</div></td>
								<td class="hide murni_jasa_dokter"><div>{!!$tarif->jenisTarif->murni_jasa_dokter!!}</div></td>
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
					
					<div class="form-group @if($errors->has('jenis_tarif'))has-error @endif">
					  {!! Form::label('jenis_tarif', 'Jenis Tarif', ['class' => 'control-label']) !!}
                      {!! Form::text('jenis_tarif', null, ['class' => 'form-control', 'id' => 'txtJenisTarifInsert'])!!}
					  @if($errors->has('jenis_tarif'))<code>{{ $errors->first('jenis_tarif') }}</code>@endif
					</div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					
					<div class="form-group @if($errors->has('tipe_tindakan_id'))has-error @endif">
					  {!! Form::label('tipe_tindakan_id', 'Tipe Tindakan', ['class' => 'control-label']) !!}
                      {!! Form::select('tipe_tindakan_id', $tipeTindakans, '1', ['class' => 'form-control'])!!}
					  @if($errors->has('tipe_tindakan_id'))<code>{{ $errors->first('tipe_tindakan_id') }}</code>@endif
					</div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					
					<div class="form-group @if($errors->has('biaya'))has-error @endif">
					  {!! Form::label('biaya', 'Biaya', ['class' => 'control-label']) !!}
                      {!! Form::text('biaya', null, ['class' => 'form-control angka', 'id' => 'txtBiayaInsert'])!!}
					  @if($errors->has('biaya'))<code>{{ $errors->first('biaya') }}</code>@endif
					</div>
                </div>
            </div>
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group @if($errors->has('jasa_dokter'))has-error @endif">
					  {!! Form::label('jasa_dokter', 'Jasa Dokter', ['class' => 'control-label']) !!}
                      {!! Form::text('jasa_dokter', null, ['class' => 'form-control angka', 'id' => 'txtJasaDokterInsert'])!!}
					  @if($errors->has('jasa_dokter'))<code>{{ $errors->first('jasa_dokter') }}</code>@endif
					</div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group @if($errors->has('tipe_laporan_admedika_id'))has-error @endif">
					  {!! Form::label('tipe_laporan_admedika_id', 'Tipe Laporan Admedika', ['class' => 'control-label']) !!}
					  {!! Form::select('tipe_laporan_admedika_id', [ null => '-Pilih-' ] + App\TipeLaporanAdmedika::pluck('tipe_laporan_admedika', 'id')->all(),null, ['class' => 'form-control', 'id' => 'tipe_laporan_admedika_id'])!!}
					  @if($errors->has('tipe_laporan_admedika_id'))<code>{{ $errors->first('tipe_laporan_admedika_id') }}</code>@endif
					</div>
                </div>
              </div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group @if($errors->has('murni_jasa_dokter'))has-error @endif">
						{!! Form::label('murni_jasa_dokter', 'Apakah ini Murni Jasa Dokter atau campuran dengan bahan / obat?', [
							'class' => 'control-label'
						]) !!}
						{!! Form::select('murni_jasa_dokter', App\Models\Classes\Yoga::pilihan('Murni'), null, array(
							'class'         => 'form-control murni_jasa_dokter',
							'id'         => 'murni_jasa_dokter_create'
						))!!}
					  @if($errors->has('murni_jasa_dokter'))<code>{{ $errors->first('murni_jasa_dokter') }}</code>@endif
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
								<div class="table-responsive">
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
								</div>
                                    {!! Form::textarea('bhp_items', null, ['class' => 'form-control hide', 'id' => 'bahan_habis_pakai'])!!}
                            </div>
                          </div>                      
                  </div>
              </div>
			</div>
		</div>
      </div>
	<div class="modal-footer">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<button class="btn btn-primary btn-lg btn-block" type="button" onclick="submitJT(this);return false;">Insert</button>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<button class="btn btn-danger btn-lg btn-block" type="button" data-dismiss="modal" onclick="">Cancel</button>
			</div>
		</div>
	</div>
	{!! Form::close()!!}
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
					<div class="form-group @if($errors->has('jenis_tarif'))has-error @endif">
					  {!! Form::label('jenis_tarif', 'Jenis Tarif', ['class' => 'control-label']) !!}
                      {!! Form::text('jenis_tarif', null, ['class' => 'form-control', 'id' => 'txtJenisTarifUpdate'])!!}
					  @if($errors->has('jenis_tarif'))<code>{{ $errors->first('jenis_tarif') }}</code>@endif
					</div>
                </div>
            </div>
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('tipe_tindakan_id'))has-error @endif">
				    {!! Form::label('tipe_tindakan_id', 'Tipe Tindakan', ['class' => 'control-label']) !!}
                    {!! Form::select('tipe_tindakan_id', $tipeTindakans, null, ['class' => 'form-control selectpick', 'id' => 'ddlTipeTindakanUpdate'])!!}
				    @if($errors->has('tipe_tindakan_id'))<code>{{ $errors->first('tipe_tindakan_id') }}</code>@endif
				  </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  
				  <div class="form-group @if($errors->has('biaya'))has-error @endif">
				    {!! Form::label('biaya', 'Biaya', ['class' => 'control-label']) !!}
                      {!! Form::text('biaya', null, ['class' => 'form-control angka', 'id' => 'txtBiayaUpdate'])!!}
				    @if($errors->has('biaya'))<code>{{ $errors->first('biaya') }}</code>@endif
				  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('jasa_dokter'))has-error @endif">
				    {!! Form::label('jasa_dokter', 'Jasa Dokter', ['class' => 'control-label']) !!}
                      {!! Form::text('jasa_dokter', null, ['class' => 'form-control angka', 'id' => 'txtJasaDokterUpdate'])!!}
                      {!! Form::text('jenis_tarif_id', null, ['class' => 'displayNone', 'id' => 'txtJenisTarifIdUpdate'])!!}
                      {!! Form::text('asuransi_id', null, ['class' => 'displayNone', 'id' => 'txtAsuransiIdUpdate'])!!}
				    @if($errors->has('jasa_dokter'))<code>{{ $errors->first('jasa_dokter') }}</code>@endif
				  </div>
              </div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group @if($errors->has('tipe_laporan_admedika_id'))has-error @endif">
					  {!! Form::label('tipe_laporan_admedika_id', 'Tipe Laporan Admedika', ['class' => 'control-label']) !!}
					  {!! Form::select('tipe_laporan_admedika_id', [ null => '-Pilih-' ] + App\TipeLaporanAdmedika::pluck('tipe_laporan_admedika', 'id')->all(),null, ['class' => 'form-control', 'id' => 'tipe_laporan_admedika_id_update'])!!}
					  @if($errors->has('tipe_laporan_admedika_id'))<code>{{ $errors->first('tipe_laporan_admedika_id') }}</code>@endif
					</div>
                </div>
            </div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group @if($errors->has('murni_jasa_dokter'))has-error @endif">
						{!! Form::label('murni_jasa_dokter', 'Apakah ini Murni Jasa Dokter atau campuran dengan bahan / obat?', ['class' => 'control-label']) !!}
						{!! Form::select('murni_jasa_dokter', App\Models\Classes\Yoga::pilihan('Murni'), null, array(
							'class' => 'form-control murni_jasa_dokter',
							'id'    => 'murni_jasa_dokter_update'
						))!!}
					  @if($errors->has('murni_jasa_dokter'))<code>{{ $errors->first('murni_jasa_dokter') }}</code>@endif
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
								<div class="table-responsive">
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
								</div>
                                  {!! Form::textarea('bhp_items', null, ['class' => 'form-control hide', 'id' => 'bhp_items_update'])!!}
                            </div>
                          </div>                      
                  </div>
              </div>
		</div>
	</div>
	<div class="modal-footer">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<button class="btn btn-primary btn-lg btn-block" type="button" onclick="submitJT_update(this);return false;">Update</button>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<button class="btn btn-danger btn-lg btn-block" type="button" data-dismiss="modal" >Cancel</button>
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

  $(document).ready(function() {
    $('.btn-success').keypress(function(e) {
      var key = e.keyCode || e.which;
      if(key == 9 || 13){
        $(this).click();
      }
      return false;
    });
	$('#modalInsertJenisTarif').on('show.bs.modal', function(){
		 $('#modalInsertJenisTarif input').val('');
		 $('#modalInsertJenisTarif select').val('');
		 $('#modalInsertJenisTarif textarea').val('[]');
		 $('#modalInsertJenisTarif #ajax1').html('');
		 data = [];
		 $('#modalInsertJenisTarif #tipe_tindakan_id').val('1');
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
        var murni_jasa_dokter = $(control).closest('tr').find('.murni_jasa_dokter div').html();
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
        $('#ddlTipeTindakanUpdate').val(tipe_tindakan_id).selectpicker('refresh');
        $('#txtBiayaUpdate').val(biaya);
        $('#txtJasaDokterUpdate').val(jasaDokter);
        $('#txtJenisTarifIdUpdate').val(jenis_tarif_id);
        $('#txtAsuransiIdUpdate').val(asuransi_id);
        $('#tipe_laporan_admedika_id_update').val(tipe_laporan_admedika_id);
        $('#murni_jasa_dokter_update').val(murni_jasa_dokter);

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
		  "merek" : {
			  'merek' : merek
		  },
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

      function submitJT(control){
        var jenis_tarif = $('#txtJenisTarifInsert').val();
        var tipe_tindakan_id = $('#tipe_tindakan_id').val();
		var murni_jasa_dokter = $(control).closest('.modal').find('select.murni_jasa_dokter').val();
        var tipe_tindakan = $('#tipe_tindakan_id option:selected').text();
        var bahanHabisPakai = $('#txtBahanHabisPakaiInsert').val();
        var biaya = $('#txtBiayaInsert').val();
        var jasa_dokter = $('#txtJasaDokterInsert').val();
        var jenis_tarif_id = $('#txtJenisTarifIdInsert').val();
        var tipe_laporan_admedika_id = $('#tipe_laporan_admedika_id').val();
        var asuransi_id = '0';
        var bhp_items = $('#bahan_habis_pakai').val();

		console.log('jenis_tarif = ' + jenis_tarif) ;
		console.log('tipe_tindakan_id = ' + tipe_tindakan_id) ;
		console.log('tipe_tindakan = ' + tipe_tindakan) ;
		console.log('bahanHabisPakai = ' + bahanHabisPakai) ;
		console.log('biaya = ' + biaya) ;
		console.log('jasa_dokter = ' + jasa_dokter) ;
		console.log('jenis_tarif_id = ' + jenis_tarif_id) ;
		console.log('asuransi_id = ' + asuransi_id) ;
		console.log('bhp_items = ' + bhp_items) ;

          if(
            $('#txtJenisTarifInsert').val() == '' ||
            $('select[name="tipe_tindakan_id"]').val() == '' ||
            $('#txtBiayaInsert').val() == '' ||
            murni_jasa_dokter == '' ||
            $('#tipe_laporan_admedika_id').val() == '' ||
            $('#txtJasaDokterInsert').val() == '') 
          {
            if($('#txtJenisTarifInsert').val() == ''){
              validasi('#txtJenisTarifInsert', 'Harus Diisi!');
            }
            if($('#select[name="tipe_tindakan_id"]').val() == ''){
              validasi('#select[name="tipe_tindakan_id"]', 'Harus Diisi!');
            }
            if($('#tipe_laporan_admedika_id').val() == ''){
              validasi('#tipe_laporan_admedika_id', 'Harus Diisi!');
            }
            if($('#txtBiayaInsert').val() == ''){
              validasi('#txtBiayaInsert', 'Harus Diisi!');
            }
            if( murni_jasa_dokter == ''){
              validasi('#murni_jasa_dokter_create', 'Harus Diisi!');
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
                    temp += '<td class="jenis_tarif_id"><div>' + result.jenis_tarif_id + '</div></td>';
                    temp += '<td class="jenis_tarif"><div>' + jenis_tarif + '</div></td>';
                    temp += '<td class="tipe_tindakan"><div>' + tipe_tindakan + '</div></td>';
                    temp += '<td class="biaya uang"><div>' + biaya + '</div></td>';
                    temp += '<td class="jasa_dokter"><div class="uang">' + jasa_dokter + '</div></td>';
                    temp += '<td class="displayNone tipe_tindakan_id"><div class="uang">' + tipe_tindakan_id + '</div></td>';
                    temp += '<td class="displayNone tipe_laporan_admedika_id"><div>' + tipe_laporan_admedika_id + '</div></td>';
                    temp += '<td class="displayNone bhp_items"><div>' + JSON.stringify( result.bhp_items ) + '</div></td>';
					temp += '<td class="displayNone murni_jasa_dokter"><div>' + murni_jasa_dokter + '</div></td>'; 
					temp += '<td class="displayNone"><div>0</div></td>';
                    temp += "<td nowrap><div><form method='post' action='{!! url('tarifs/" + result.id + "')!!}'><input type=\"hidden\" value=\"DELETE\" name=\"_method\"><input type=\"hidden\" name=\"_token\" value=\"<?php echo csrf_token(); ?>\">";
                    temp += "<a href=\"#\" class=\"btn btn-success btn-sm\" data-toggle=\"modal\" data-target=\""
                    temp += "#modalUpadteJenisTarif\" onclick=\"editRow(this)\">edit</a> ";
                    temp += "<input type='submit' value='hapus' class='btn btn-danger btn-sm' onclick='return confirm(\"Anda yakin mau menghapus " + result.jenis_tarif_id + " - " + jenis_tarif +  " dari Tarif?\")' /></div></td>";
                    temp += "</form></tr>";

					console.log(temp);

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
        var biaya = $('#txtBiayaUpdate').val();
        var jasa_dokter = $('#txtJasaDokterUpdate').val();
        var murni_jasa_dokter = $('#murni_jasa_dokter_update').val();
        var jenis_tarif_id = $('#txtJenisTarifIdUpdate').val();
        var asuransi_id = $('#txtAsuransiIdUpdate').val();
        var tipe_laporan_admedika_id = $('#tipe_laporan_admedika_id_update').val();
        var bhp_items = $('#bhp_items_update').val();
        
       console.log('jenis_tarif = ' + jenis_tarif);
       console.log('tipe_tindakan_id = ' + tipe_tindakan_id);
       console.log('tipe_tindakan = ' + tipe_tindakan);
       console.log('tipe_laporan_admedika_id_update = ' + tipe_laporan_admedika_id);
       console.log('biaya = ' + biaya);
       console.log('jasa_dokter = ' + jasa_dokter);
       console.log('jenis_tarif_id = ' + jenis_tarif_id);
       console.log('asuransi_id = ' + asuransi_id);
       console.log('bhp_items = ' + bhp_items);

          if(
            $('#txtJenisTarifUpdate').val() == '' ||
            $('#ddlTipeTindakanUpdate').val() == '' ||
            $('#tipe_laporan_admedika_id_update').val() == '' ||
            $('#txtBiayaUpdate').val() == '' ||
            murni_jasa_dokter == '' ||
            $('#txtJasaDokterUpdate').val() == '')
          {
            if($('#txtJenisTarifUpdate').val() == ''){
              validasi('#txtJenisTarifUpdate', 'Harus Diisi!');
            }
            if($('#ddlTipeTindakanUpdate').val() == ''){
              validasi('#ddlTipeTindakanUpdate', 'Harus Diisi!');
            }
            if($('#tipe_laporan_admedika_id_update').val() == ''){
              validasi('#tipe_laporan_admedika_id_update', 'Harus Diisi!');
            }
            if( murni_jasa_dokter == ''){
              validasi('#murni_jasa_dokter_update', 'Harus Diisi!');
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
                  'jenis_tarif':              jenis_tarif,
                  'tipe_tindakan_id':         tipe_tindakan_id,
                  'biaya':                    biaya,
                  'jasa_dokter':              jasa_dokter,
                  'bhp_items':                bhp_items,
                  'tipe_laporan_admedika_id': tipe_laporan_admedika_id,
                  'jenis_tarif_id':           jenis_tarif_id,
                  'murni_jasa_dokter':        murni_jasa_dokter,
                  'asuransi_id':              asuransi_id
                }
              })
              .done(function(result) {
                  result = JSON.parse(result);
                  if(result.jenis_tarif_id != '0'){
                    
                    biaya = uang(biaya);
                    jasa_dokter = uang(jasa_dokter);

                    console.log('biaya = ' + biaya);
                    var biaya_total = parseInt(biaya) + parseInt(bahan_habis_pakai);
                    console.log('biaya_total = ' + biaya_total);
                    $('#modalUpadteJenisTarif').modal('hide');
                      var $edit = $('#table_tarif tbody tr:nth-child(' + row_index + ')');
                      
                      $('#table_tarif tbody tr:nth-child(' + row_index + ')').find('td').find('div').slideUp('500', function(){
                            $edit.find('.jenis_tarif_id').find('div').html(result.jenis_tarif_id);
                            $edit.find('.jenis_tarif').find('div').html(jenis_tarif);
                            $edit.find('.tipe_tindakan').find('div').html(tipe_tindakan);
                            $edit.find('.biaya').find('div').html(biaya);
                            $edit.find('.jasa_dokter').find('div').html(jasa_dokter);
                            $edit.find('.tipe_tindakan_id').find('div').html(tipe_tindakan_id);
                            $edit.find('.murni_jasa_dokter').find('div').html(murni_jasa_dokter);
							$edit.find('.tipe_laporan_admedika_id').find('div').html(tipe_laporan_admedika_id);
                            $edit.find('.bhp_items').find('div').html(bhp_items);
                            $edit.find('.asuransi_id').find('div').html(asuransi_id);
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
