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
            <table class="table borderless table-condensed">
                <thead>
                    <tr>
                        <th class="key hide">Key</th>
                        <th class="hide id">Id</th>
                        <th>Tanggal</th>
                        <th>Petugas</th>
                        <th>Akun </th>
						<th>Nilai</th>
                        <th>Chart Of Account</th>
                    </tr>
                </thead>
                <tbody>
					@foreach($pengeluarans as $k=>$ju)
						<tr>
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
						<tr>
							<td>Kuitans : </td>
							<td colspan="3"> <img src="{{ url('img/belanja/lain/'. $ju->faktur_image) }}" class="img-rounded upload"> </td>
							<td>{{ $ju->faktur_image }}</td>
						</tr>
                    @endforeach
                </tbody>
            </table>
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
							<th>Pendapatan</th>
							<th>Petugas</th>
							<th>Keterangan</th>
							<th>Nilai</th>
							<th>Chart Of Account</th>
							
						</tr>
					</thead>
					<tbody>
						@if(count($pendapatans) > 0)
							@foreach($pendapatans as $ju)
								<tr>
								  <td class="hide field_id">{!! $ju->jurnal_umum_id !!}</td>
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
{!! Form::open(['url' => 'jurnal_umums/coa']) !!}
{!! Form::text('route', $route, ['class' => 'form-control hide']) !!}
{!! Form::textarea('temp', json_encode($jurnalumums), ['class' => 'form-control hide', 'id' => 'temp']) !!}
{!! Form::textarea('peralatanTemp', '[]', ['class' => 'form-control', 'id' => 'peralatanTemp']) !!}
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
<div id="formPeralatan" class="hide">
	<div class="row border-bottom">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="form-group @if($errors->has('nomor_faktur'))has-error @endif">
			  {!! Form::label('nomor_faktur', 'Nomor Faktur', ['class' => 'control-label']) !!}
			  {!! Form::text('nomor_faktur' , null, ['class' => 'form-control', 'onkeyup' => 'nomorFakturKeyup(this);return false;']) !!}
			  @if($errors->has('nomor_faktur'))<code>{{ $errors->first('nomor_faktur') }}</code>@endif
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="form-group @if($errors->has('masa_pakai'))has-error @endif">
			  {!! Form::label('masa_pakai', 'Golongan Peralatan', ['class' => 'control-label']) !!}
			  {!! Form::select('masa_pakai' , App\Classes\Yoga::masaPakai(), null, ['class' => 'form-control', 'onchange' => 'masaPakaiOnChange(this);return false;']) !!}
			  @if($errors->has('masa_pakai'))<code>{{ $errors->first('masa_pakai') }}</code>@endif
			</div>
		</div>
	</div>
</div>
@stop
@section('footer') 

<script>
    $(function () {

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
    var id = $(control).closest('tr').find('.field_id').html();
    var data = JSON.parse($('#temp').val());
    for (var i = 0; i < data.length; i++) {
      if (data[i].id == id) {
        data[i].coa_id = $(control).val();
        break;
      }
    }
    var string = JSON.stringify(data);
    $('#temp').val(string);
	var key = $(control).closest('tr').find('.key').html();
	if( $(control).val() == '120001' ){ // jika yang dipilih adalah biaya operasional peralatan

		var html = '<tr class="form_tambahan_peralatan"><td colspan="5">';
		html += $('#formPeralatan').html();	
		html += '</tr></td>';


		var peralatanTemp = $('#peralatanTemp').val();
		peralatanTemp = $.parseJSON(peralatanTemp);
		peralatanTemp[key] = { 
			'nomor_faktur' : '',
			'masa_pakai' : ''
		};
		updatePeralatanTemp(peralatanTemp);


		$(control).closest('tr').after(html);
		$(control).closest('tr').next().find('input[name="nomor_faktur"]').addClass('rq');
		$(control).closest('tr').next().find('select[name="masa_pakai"]').addClass('rq');
		$(control).closest('tr').next().hide().fadeIn(500);

	} else{
		var $next = $(control).closest('tr').next();
		if($next.hasClass('form_tambahan_peralatan')){
			$next.fadeOut(500, function (){
				 $next.remove();
				 var peralatanTemp = parsePeralatanTemp();
				 peralatanTemp.splice(key, 1);
				 updatePeralatanTemp(peralatanTemp);
			});
		}
		 
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
                    'coa_id' : coa_id,
                    'kelompok_coa_id' : kelompok_coa_id,
                    'coa' : coa
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
		alert(jenis_tarif_id);
		alert(i);

	}
	function resetModal(){
		 $('#coa_baru').find('input,select,textarea').val('');
	}
	
	function nomorFakturKeyup(control){
		var key = $(control).closest('tr').prev().find('.key').html();
		console.log('key');
		console.log(key);
		var value = $(control).val();
		var peralatanTemp = parsePeralatanTemp();
		peralatanTemp[ key ][ 'nomor_faktur' ] = value;
		updatePeralatanTemp(peralatanTemp)
	}
	function masaPakaiOnChange(control){
		var key = $(control).closest('tr').prev().find('.key').html();
		var value = $(control).val();
		var peralatanTemp = parsePeralatanTemp();
		peralatanTemp[ key ][ 'masa_pakai' ] = value;
		updatePeralatanTemp(peralatanTemp)
	}
	function updatePeralatanTemp(peralatanTemp){
		peralatanTemp = JSON.stringify(peralatanTemp);
		$('#peralatanTemp').val( peralatanTemp );
	}

	function parsePeralatanTemp(){
		var peralatanTemp = $('#peralatanTemp').val();
		return $.parseJSON(peralatanTemp);
	}

	
	
</script>

@stop
