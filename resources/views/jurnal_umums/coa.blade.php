@extends('layout.master')
@section('title') 
Klinik Jati Elok | Coa belum di set
@stop
@section('page-title') 
 <h2>Jurnal Umum</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
         <strong>Coa belum di set</strong>
      </li>
</ol>
@stop
@section('head') 
	<style type="text/css" media="all">
		.nowrap {

			white-space : nowrap;
		}
		.padding {
			padding-bottom : 14px;
		}
	</style>
@stop
@section('content')


<div class="modal fade" id="coa_baru" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Coa Baru</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('kelompok_coa_id'))has-error @endif">
				      {!! Form::label('kelompok_coa_id', 'Kelompok Coa', ['class' => 'control-label']) !!}
                      {!! Form::select('kelompok_coa_id', $kelompokCoaList , null, ['class' => 'form-control form-coa', 'id'=>'kelompok_coa_id']) !!}
				      @if($errors->has('kelompok_coa_id'))<code>{{ $errors->first('kelompok_coa_id') }}</code>@endif
				  </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('coa_id'))has-error @endif">
				    {!! Form::label('coa_id', 'Kode COA', ['class' => 'control-label']) !!}
                      {!! Form::text('coa_id' , null, ['class' => 'form-control form-coa', 'id'=>'kode_coa', 'disabled' => 'disabled']) !!}
				    @if($errors->has('coa_id'))<code>{{ $errors->first('coa_id') }}</code>@endif
				  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				  <div class="form-group @if($errors->has('coa'))has-error @endif">
				    {!! Form::label('coa', 'Keterangan Coa', ['class' => 'control-label']) !!}
                      {!! Form::text('coa' , null, ['class' => 'form-control form-coa', 'id'=>'keterangan_coa', 'disabled' => 'disabled']) !!}
				    @if($errors->has('coa'))<code>{{ $errors->first('coa') }}</code>@endif
				  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <button class="btn btn-success btn-block" type="button" id="submit_coa" onclick="submitCoa();return false;">Submit</button>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <button class="btn btn-danger btn-block" type="button" id="cancel_coa" onclick=" $('#coa_baru').modal('hide');return false;">Cancel</button>
              </div>
          </div>
      </div>
      <div class="modal-footer">
         <table class="table table-bordered table-condensed">
             <thead>
                 <tr>
                     <th>Coa</th>
                     <th>Keterangan Coa</th>
                 </tr>
             </thead>
             <tbody id="coa_list">
             </tbody>
         </table>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                  <h3>Coa Pengeluaran</h3>
                </div>
                <div class="panelRight">
                    <button class="btn btn-success" type="button" onclick=" $('#coa_baru').modal('show');return false;">Coa Baru</button>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th class="key hide">Key</th>
                        <th class="hide key">Id</th>
                        <th>Tanggal</th>
                        <th>Petugas</th>
                        <th>Akun </th>
						<th>Nilai</th>
                        <th>Chart Of Account</th>
                    </tr>
                </thead>
                <tbody>
					@foreach($pengeluarans as $k=>$ju)
						<tr class="kuitansi">
							<td>Kuitans : </td>
							<td colspan="3"> <img src="{{ url('img/belanja/lain/'. $ju->faktur_image) }}" class="img-rounded upload"> </td>
							<td>{{ $ju->faktur_image }}</td>
						</tr>
						<tr class="rowTr">
						  <td class="hide field_id">{!! $ju->jurnal_umum_id !!}</td>
						  <td class="hide key">{!! $k !!}</td>
						  <td>
							  {!! $ju->tanggal !!} <br />
							  Jurnalable type : <br />
							  {!! $ju->jurnalable_type !!} <br />
							  Jurnalable id : <br />
							  {!! $ju->jurnalable_id !!}
						  </td>
						  <td>{!! $ju->nama_staf !!}</td>
						  <td class="keterangan">{!! $ju->nama !!}</td>
						  <td class="uang">{!! $ju->nilai !!}</td>
						  <td>
							  {!! Form::select('coa', $bebanCoaList, null, ['class' => 'form-control rq selectpick kode_coa', 'onchange' => 'coaChange(this); return false;', 'data-live-search' => 'true']) !!}
						  </td> 
						</tr>
                    @endforeach
                </tbody>
            </table>
		  </div>
      </div>
</div>
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-info hide">
			<div class="panel-heading">
				<div class="panel-title">Daftar AC</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Merek</th>
								<th>Keterangan Penempatan AC</th>
								<th colspan="3" class="hide"> Daftar AC</th>
							</tr>
						</thead>
						<tbody id="daftar_ac">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


@if(count( $pendapatans ) > 0)
	<div class="panel panel-primary">
		  <div class="panel-heading">
				<div class="panel-title">
					<div class="panelLeft">
					  <h3>Coa Pendapatan Lain</h3>
					</div>
				</div>
		  </div>
		  <div class="panel-body">
			  <div class="table-responsive">
				<table class="table borderless table-condensed">
					<thead>
						<tr>
							<th class="hide field_id">id</th>
							<th class="hide key">key</th>
							<th>Pendapatan</th>
							<th>Petugas</th>
							<th>Keterangan</th>
							<th>Nilai</th>
							<th>Chart Of Account</th>
							
						</tr>
					</thead>
					<tbody>
						@if(count($pendapatans) > 0)
							@foreach($pendapatans as $k=>$ju)
								<tr class="rowTr">
								  <td class="hide field_id">{!! $ju->jurnal_umum_id !!}</td>
								  <td class="hide key">{!! $k !!}</td>
								  <td>{!! $ju->sumber_uang !!}</td>
								  <td>{!! $ju->nama_staf !!}</td>
								  <td>{!! $ju->keterangan !!}</td>
								  <td class="uang">{!! $ju->nilai !!}</td>
								  <td>
									   {!! Form::select('coa', $pendapatanCoaList, null, ['class' => 'form-control selectpick', 'onchange' => 'coaChange(this); return false;', 'data-live-search' => 'true']) !!}
								  </td>
								</tr>
							@endforeach
						@else
							<td class="text-center" colspan="7">Tidak ada data untuk ditampilkan :p</td>
						@endif
					</tbody>
				</table>
			  </div>
			  
		  </div>
	</div>
@endif
<div id="serviceAc">
	@include('jurnal_umums.serviceAc')
</div>
<div id="serviceAc2">
	@include('jurnal_umums.serviceAc', ['kedua' => true])
</div>
{!! Form::open(['url' => 'jurnal_umums/coa']) !!}
{!! Form::text('route', $route, ['class' => 'form-control hide']) !!}
{!! Form::textarea('temp', json_encode($jurnalumums), ['class' => 'hide form-control', 'id' => 'temp']) !!}
{!! Form::textarea('peralatanTemp', '[]', ['class' => 'hide form-control', 'id' => 'peralatanTemp']) !!}
{!! Form::textarea('serviceAcTemp', '[]', ['class' => 'hide form-control', 'id' => 'serviceAcTemp']) !!}
  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <button class="btn btn-success btn-lg btn-block" type="button" onclick="dummySubmit();return false;">Submit</button>
      <button class="btn btn-success btn-lg btn-block hide" id="submit" type="submit">Submit</button>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <a href="{{ url('jurnal_umums') }}" class="btn btn-danger btn-lg btn-block">Cancel</a>
    </div>
  </div>
{!! Form::close() !!}
<div id="formPeralatan2" class="hide">
	@include('jurnal_umums.formCoa', ['kedua' => true ])
</div>
<div id="formPeralatan" class="hide">
	@include('jurnal_umums.formCoa', ['kedua' => false ])
</div>
<div id="formAc" class="hide">
	@include('jurnal_umums.formAc')
</div>
<div id="formAc2" class="hide">
	@include('jurnal_umums.formAc', ['kedua' => true])
</div>
{!! Form::textarea('formAcInput', null, ['class' => 'form-control hide' , 'id' => 'formAcInput']) !!}	
{!! Form::textarea('formAcInput2', null, ['class' => 'form-control hide' , 'id' => 'formAcInput2']) !!}	
{!! Form::textarea('formPeralatan2', null, ['class' => 'form-control hide' , 'id' => 'formInputPeralatan2']) !!}	
{!! Form::textarea('formServiceAcInput', null, ['class' => 'form-control hide' , 'id' => 'formServiceAcInput']) !!}	
{!! Form::textarea('formServiceAcInput2', null, ['class' => 'form-control hide' , 'id' => 'formServiceAcInput2']) !!}	
@stop
@section('footer') 
<script>
    $(function () {
		$('#formAcInput').val( $('#formAc').html() );
		$('#formAc').remove();
		$('#formAcInput2').val( $('#formAc2').html() );
		$('#formAc2').remove();

		$('#formServiceAcInput').val( $('#serviceAc').html() );
		$('#serviceAc').remove();
		$('#formServiceAcInput2').val( $('#serviceAc2').html() );
		$('#serviceAc2').remove();
		$('#formInputPeralatan2').val( $('#formPeralatan2').html() );
		$('#coa_baru').on('show.bs.modal', function(){
			resetModal();
		});
        $('#kode_coa').keyup(function(e){
             var key = e.keyCode || e.which;
             $.get('{{ url('jurnal_umums/coa_list') }}',
                     { 'coa_id' : $('#kode_coa').val()
                     },
                 function (data, textStatus, jqXHR) {
                     data = $.parseJSON(data);
                     var temp = '';
                    for (var i = 0; i < data.length; i++) {
                         temp += '<tr>';
                         temp += '<td class="text-left">' + data[i].id + '</td>';
                         temp += '<td class="text-left">' + data[i].coa + '</td>';
                         temp += '</tr>';
                    };
                    console.log(' length = ' + $('#kode_coa').val().length);
                    if(data.length < 1 && $('#kode_coa').val().length > 5){
                        $('#keterangan_coa').removeAttr('disabled');
                    } else {
                      $('#keterangan_coa').attr('disabled', 'disabled');
                    }
                     $('#coa_list').html(temp);
                 }
             );
             var pre = $('#kelompok_coa_id').val();
             var length = pre.length;
             var pre_id = $(this).val().substring(0,length);
             console.log('pre id = ' + pre_id);
             if( pre_id != $('#kelompok_coa_id').val() ){
                 $(this).val($('#kelompok_coa_id').val());
             }
        });
        $('#keterangan_coa').keyup(function(e){
              var key = e.keyCode || e.which;
             $.get('{{ url('jurnal_umums/coa_keterangan') }}',
                     { 'keterangan' : $('#keterangan_coa').val()
                     },
                 function (data, textStatus, jqXHR) {
                     data = $.parseJSON(data);
                     var temp = '';
                    for (var i = 0; i < data.length; i++) {
                         temp += '<tr>';
                         temp += '<td class="text-left">' + data[i].id + '</td>';
                         temp += '<td class="text-left">' + data[i].coa + '</td>';
                         temp += '</tr>';
                    };
                    if(data.length > 0){
                      $('#submit_coa').attr('disabled', 'disabled');
                    } else {
                        $('#submit_coa').removeAttr('disabled');
                    }
                      
                     $('#coa_list').html(temp);
                 }
             );
        });

        $('#kelompok_coa_id').change(function(){
             var pre = $(this).val();

             if(pre == ''){
                  $('#kode_coa').attr('disabled', 'disabled');
             } else {
                  $('#kode_coa').removeAttr('disabled');
             }
             
             $('#kode_coa').val(pre);
        });
    });
  function coaChange(control){

    var id              = $(control).closest('tr').find('.field_id').html();
    var data            = JSON.parse($('#temp').val());
    for (var i          = 0; i < data.length; i++) {
      if (data[i].id   == id) {
        data[i].coa_id  = $(control).val();
        break;
      }
    }
    var string = JSON.stringify(data);
    $('#temp').val(string);
	var key = $(control).closest('tr').find('.key').html();
	if( $(control).val() == '120001' ){ // jika yang dipilih adalah biaya operasional peralatan
		clearFormCoa(key, control, 'formPeralatan');
	} else if(  $(control).val() == '623433'  ) { // jika yang dipilih adalah biaya operasional serviceAc
		clearFormCoa(key, control, 'serviceAc');
	} else {// jika yang dipilih adalah biaya operasional serviceAc
		clearFormCoa(key, control);
	}
  }
  function dummySubmit(){
       var coa_id = $('#kode_coa').val();
       var kelompok_coa_id = $('#kelompok_coa_id').val();
       var coa = $('#keterangan_coa').val();
       var coa_id = $('#kode_coa').val();
       var kelompok_coa_id = $('#kelompok_coa_id').val();
       var coa = $('#keterangan_coa').val();
    if (validatePass()) {
      $('#submit').click();
    }
  }
   function submitCoa(){
       var coa_id = $('#kode_coa').val();
       var kelompok_coa_id = $('#kelompok_coa_id').val();
       var coa = $('#keterangan_coa').val();

       $.post('{{ url("jurnal_umums/coa_entry") }}',
               {
                    'coa_id':          coa_id,
                    'kelompok_coa_id': kelompok_coa_id,
                    'coa':             coa
               },
           function (data, textStatus, jqXHR) {
                var val = $.parseJSON(data);
                var temp = '';
               for(var j in val){
                   temp += "<option value='" + j + "'>" + val[j] + '</option>';
                }

               $('select.kode_coa').each(function(){
                    if( $(this).val() == '' ){
						$(this).html(temp)
								.val('')
								.selectpicker('refresh');
                    } else {
                        $(this).append('<option value="' + coa_id + '">' + coa + '</option>').selectpicker('refresh');
                    }
               });

               $('#coa_baru').modal('hide');
           }
       );
   }
	function coa_tindakan_insert(control){
		 
		var jenis_tarif_id = $(control).closest('tr').find('td:first-child').html();
		var i = $(control).attr('data-key');

	}
	function resetModal(){
		 $('#coa_baru').find('input,select,textarea').val('');
	}
	
	function nomorFakturKeyup(control){
		var key = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
		var value = $(control).val();
		var peralatanTemp = parsePeralatanTemp();
		peralatanTemp[ key ][ 'nomor_faktur' ] = value;
		decodePeralatan(peralatanTemp)
	}
	function masaPakaiOnChange(control){
		var key = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
		var alatKey = $(control).closest('tr').find('.key').val();
		var value = $(control).val();

		var peralatanTemp = parsePeralatanTemp();
		var peralatan = $(control).closest('tr').find('.peralatan').val();
		var jumlah = $(control).closest('tr').find('.jumlah').val();
		peralatanTemp[ key ].alat[alatKey].masa_pakai = value;
		decodePeralatan(peralatanTemp)
		if( $(control).find(':selected').text() == 'AC / Pendingin Ruangan' ){
			formAc(control, jumlah);
		} else {
			var temp = parsePeralatanTemp();
			temp[key].alat[alatKey].ac = [];
			decodePeralatan(temp);
			viewAc(temp);
		}
		$(control).closest('tr').next().find('.keterangan').focus();
	}
	function updatePeralatanTemp(peralatanTemp){
		peralatanTemp = JSON.stringify(peralatanTemp);
		$('#peralatanTemp').val( peralatanTemp );
	}

	function parsePeralatanTemp(){
		var peralatanTemp = $('#peralatanTemp').val();
		return $.parseJSON(peralatanTemp);
	}
	function keteranganChange(control){
		var text = $(control).val();
		var temp = $('#peralatanTemp').val();
		temp = $.parseJSON(temp);
		var i = $(control).closest('tr').prev().prev().find('.key').html();
		temp[i].ac = text;
		temp = JSON.stringify( temp );
		$('#peralatanTemp').val( temp );

	}
	function tambahAc(control){
		formAc(control);
		var value = $(control).closest('tr').find('.key').val();
		value = parseInt( value ) +1;
		$(control).closest('tr').html();
		var i = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
		$(control).closest('tr').next().find('.key').val(value);
		$(control).closest('div').html('');
		var temp = parsePeralatanTemp();
		temp[i].ac[value] = {
			'merek' : '',
			'keterangan' : ''
		}
		decodePeralatan(temp);
	}
	function formAc(control, jumlah = 1){
		var temp = parsePeralatanTemp();
		var coa_key = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
		var alat_key =  $(control).closest('tr').find('.key').val();
		for (var i = 0; i < jumlah; i++) {
			temp[coa_key].alat[alat_key].ac[i]={
				'merek' : $(control).closest('tr').find('.peralatan').val(),
				'keterangan' : ''
			};
		}
		decodePeralatan(temp);
		viewAc(temp);
	}
	function hapusAc(control){
		 var action = $(control).closest('div').html();
		 $(control).closest('tr').prev().find('.action').html(action);
		 var i = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
		 console.log('i');
		 console.log(i);
		 var value = $(control).closest('tr').find('.key').val();
		 console.log('value');
		 console.log(value);

		 $(control).closest('tr').remove();
		 var temp = parsePeralatanTemp();
		 temp[i].ac.splice(value,1);
		 decodePeralatan(temp);
		
	}
	function acKeyUp( name, control ){
		 var coa_key = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
		 var alat_key = $(control).closest('tr').prevAll('tr.form_tambahan_peralatan:first').find('.key').val();
		 var key = $(control).closest('td').find('.key').val();
		 var temp = parsePeralatanTemp();
		 if(name == 'merek'){
			temp[coa_key].alat[alat_key].ac[key].merek = $(control).val();
		 } else if( name == 'keterangan' ){
			temp[coa_key].alat[alat_key].ac[key].keterangan = $(control).val();
		 }
		decodePeralatan(temp)
	}
	function decodePeralatan(temp){
		temp = JSON.stringify( temp );
		$('#peralatanTemp').val(temp);
	}
	function tambahAlat(control){
		 var formAlat = $('#formInputPeralatan2').val();
		 var html = '<tr class="form_tambahan_peralatan">';
			html += '<td colspan="5">';
			html += formAlat;
			html += '</td>';
			html += '</tr>';
		 $(control).closest('tr').after(html);
		 $(control).closest('tr').next().find('.peralatan').focus();
		 $(control).closest('.alat-action').addClass('hide');
		 $(control).closest('tr').next().find('.btn-danger').removeClass('hide');
		 var value = $(control).val();
		 $(control).closest('tr').next().find('.key').val( parseInt( value ) + 1 );
		 var coa_key = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
		 var alat_key = $(control).closest('tr').prevAll('tr.form_tambahan_peralatan:first').find('.key').val();
		 var temp = parsePeralatanTemp();
		 temp[coa_key].alat[temp[coa_key].alat.length] = {
			'peralatan' : '',
			'harga_satuan' : '',
			'jumlah' : '',
			'masa_pakai' : '',
			'ac' :[]
		 };
		 decodePeralatan(temp);
	}
	function kurangAlat(control){
		var alat_key = $(control).closest('tr').find('.key').val();
		var coa_key = coaKey(control);
		var temp = parsePeralatanTemp();
		temp[coa_key].alat.splice(alat_key, 1);
		decodePeralatan(temp);
		$(control).closest('tr').prev().find('.alat-action').removeClass('hide');
		$(control).closest('tr').addClass('hide');
	}
	function alatKeyUp( name, control ){
		var coa_key = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
		var alat_key = $(control).closest('tr').find('.key').val();
		var alat = parsePeralatanTemp();
		if( name == 'peralatan' ){
			alat[coa_key].alat[alat_key].peralatan = $(control).val();
		} else if ( name == 'harga_satuan' ){
			alat[coa_key].alat[alat_key].harga_satuan = $(control).val();
		} else if ( name == 'jumlah' ){
			alat[coa_key].alat[alat_key].jumlah = $(control).val();
			if( $(control).val() == '' ){
				$(control).closest('tr').find('.masa_pakai').attr('disabled', 'disabled').val('');
			} else {
				$(control).closest('tr').find('.masa_pakai').removeAttr('disabled');
			}
		}
		decodePeralatan(alat);
	}
	function viewAc(temp){
		var acs = [];
		for (var i = 0; i < temp.length; i++) {
			for (var o = 0; o < temp[i].alat.length; o++) {
				for (var u = 0; u < temp[i].alat[o].ac.length; u++) {
					acs[acs.length] = {
						'nomor_faktur' : temp[i].nomor_faktur,
						'merek' : temp[i].alat[o].ac[u].merek,
						'keterangan' : temp[i].alat[o].ac[u].keterangan,
						'coa_key' : i,
						'alat_key' : o,
						'ac_key' : u
					}
				}
			}
		}
		var table = '';
		for (var i = 0; i < acs.length; i++) {
			table += '<tr>'
				table += '<td class="merek"> ';
			table += '<strong>Merek : </strong> ';
			table += acs[i].merek + '<br />';
			table += '<strong>Nomor Faktur : </strong> ';
			table += acs[i].nomor_faktur + '<br />';
			table += '<strong>Transaksi baris ke : </strong> ';
			table += ( parseInt( acs[i].alat_key ) + 1 ) + '<br />';
			table += '</td>'
			table += '<td class="keterangan"><textarea class="form-control rq textareacustom" onkeyup="keteranganOnChange(this);return false;">' + acs[i].keterangan + '</textarea></td>'
			table += '<td class="coa_key hide">' + acs[i].coa_key + '</td>';
			table += '<td class="alat_key hide">' + acs[i].alat_key + '</td>';
			table += '<td class="ac_key hide">' + acs[i].ac_key + '</td>';
			table += '</tr>'
		}
		$('#daftar_ac').html(table);
		if( acs.length > 0 ){
			if($('#daftar_ac').closest('.panel-info').hasClass('hide')){
				$('#daftar_ac').closest('.panel-info').removeClass('hide').hide().fadeIn(500);
			}
		} else {
			if(!$('#daftar_ac').closest('.panel-info').hasClass('hide')){
				$('#daftar_ac').closest('.panel-info').fadeOut(500, function(){
					 $(this).addClass('hide').show();
				});
			}
		}
	}
	function keteranganOnChange(control){
		var coa_key = $(control).closest('tr').find('.coa_key').html();
		var alat_key = $(control).closest('tr').find('.alat_key').html();
		var ac_key = $(control).closest('tr').find('.ac_key').html();
		 
		var temp = parsePeralatanTemp();
		temp[coa_key].alat[alat_key].ac[ac_key].keterangan = $(control).val();
		decodePeralatan(temp);
	}
	function coaKey(control){
		 return $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
	}
	function serviceAc(control){
		var key = $(control).closest('tr').find('.key').html();
		var temp = $('#formServiceAcInput').val();
		var html = '<tr class="form-tambahan-serviceAc"><td colspan="5">';
		html += temp;
		html += '</td></tr>';
		$(control).closest('tr').after(html);
		$(control).closest('tr').next().hide().fadeIn(500, function(){
			$(control).closest('tr').next().find('.nomor_faktur_serviceAc').focus();
		});
		console.log('temp');
		console.log(temp);
		var array = parseServiceAc();
		var coa_key = $(control).closest('tr').find('.key').html();
		array[coa_key] = {
			'nomor_faktur' : '',
			'ac_id' : [],
		};
		encodeServiceAc(array);
	}
	function tambahServiceAc(control){
		var temp = $('#formServiceAcInput2').val();
		$(control).closest('.row').after(temp);
		$(control).closest('.row').next().find('.btn-danger').removeClass('hide');
		$(control).closest('.input-group').addClass('hide');
		var ac_id = $(control).val();
		var value = $(control).val();
		$(control).closest('.row').next().find('.key').val( parseInt( value ) + 1 );
		var coa_key = coaKey(control);
		var service_key = $(control).closest('.row').next().find('.key').val();
		var temp = parseServiceAc();
		temp[coa_key].ac_id[service_key] = '';
		encodeServiceAc(temp);

	}

	function kurangServiceAc(control){
		$(control).closest('.row').prev().find('.input-group').removeClass('hide');
		var coa_key = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
		var service_key = $(control).closest('.row').find('.key').val();
		var temp = parseServiceAc();
		console.log('coa_key');
		console.log(coa_key);
		console.log('service_key');
		console.log(service_key);
		console.log('temp');
		console.log(temp);
		temp[coa_key].ac_id.splice(service_key, 1);
		encodeServiceAc( temp );
		$(control).closest('.row').remove();
	}
	
	function selectServiceAcChange(control){

		var ac_id = $(control).val();
		var coa_key = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
		var service_key = $(control).closest('.row').find('.key').val();
		var temp = parseServiceAc();
		console.log('coa_key');
		console.log(coa_key);
		console.log('service_key');
		console.log(service_key);
		console.log('temp');
		console.log(temp);
		temp[coa_key].ac_id[service_key] = ac_id;
		encodeServiceAc(temp);
		 
	}
	function parseServiceAc(){
		 var json = $('#serviceAcTemp').val();
		 return $.parseJSON(json);
	}
	
	function encodeServiceAc(temp){
		console.log('temp');
		console.log(temp);
		temp = JSON.stringify(temp);
		$('#serviceAcTemp').val(temp);
	}
	function coaKey(control){
		return $(control).closest('tr').prevAll('.rowTr:first').find('.key').html();
	}
function clearFormCoa(key, control, next = null){
	if( $(control).closest('tr').nextUntil('.kuitansi').length > 0 && next != null ){
		$(control).closest('tr').nextUntil('.kuitansi').fadeOut(500, function(){
			$(this).remove();
			var peralatanTemp = parsePeralatanTemp();
			peralatanTemp.splice(key, 1);
			updatePeralatanTemp(peralatanTemp);
			var temp = parseServiceAc();
			temp.splice(key, 1);
			encodeServiceAc(temp);
			if( next == 'serviceAc' ){
				serviceAc(control);
			} else if ( next == 'formPeralatan' ){
				formPeralatan(key, control)
			}
		});
	} else {
		if( next == 'serviceAc' ){
			serviceAc(control);
		} else if ( next == 'formPeralatan' ){
			formPeralatan(key, control)
		}
	}
}
function formPeralatan(key, control){
	 
		var html = '<tr class="form_tambahan_peralatan"><td colspan="5">';
		html += $('#formPeralatan').html();	
		html += '</tr></td>';

		var peralatanTemp = $('#peralatanTemp').val();
		peralatanTemp = $.parseJSON(peralatanTemp);

		peralatanTemp[key]= {
			'nomor_faktur' : '',
			'alat' : []
		};
		peralatanTemp[key].alat[0] = { 

			'peralatan' : '',
			'harga_satuan' : '',
			'jumlah' : '',
			'masa_pakai' : '',
			'ac' :[]

		};

		updatePeralatanTemp(peralatanTemp);

		$(control).closest('tr').after(html);
		$(control).closest('tr').next().find('input[name="nomor_faktur"]').addClass('rq');
		$(control).closest('tr').next().find('select[name="masa_pakai"]').addClass('rq');
		$(control).closest('tr').next().hide().fadeIn('500', function(){
			$(control).closest('tr').next().find('.nomor_faktur').focus();
		});
}
function nomorFakturServiceAcKeyup(control){
	var coa_key = $(control).closest('tr').prevAll('tr.rowTr:first').find('.key').html();
	var service_key = $(control).closest('.row').next().find('.key').val();
	var temp = parseServiceAc();
	temp[coa_key].nomor_faktur = $(control).val();
	encodeServiceAc(temp);
}








</script>

@stop
