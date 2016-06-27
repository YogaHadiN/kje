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
                  <div class="form-group">
                      {!! Form::label('kelompok_coa_id', 'Kelompok Coa') !!}
                      {!! Form::select('kelompok_coa_id', $kelompokCoaList , null, ['class' => 'form-control form-coa', 'id'=>'kelompok_coa_id']) !!}
                  </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                      {!! Form::label('coa_id', 'Kode Coa') !!}
                      {!! Form::text('coa_id' , null, ['class' => 'form-control form-coa', 'id'=>'kode_coa', 'disabled' => 'disabled']) !!}
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                      {!! Form::label('coa', 'Keterangan Coa') !!}
                      {!! Form::text('coa' , null, ['class' => 'form-control form-coa', 'id'=>'keterangan_coa', 'disabled' => 'disabled']) !!}
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
            <table class="table borderless table-condensed">
                <thead>
                    <tr>
                        <th class="hide">Id</th>
                        <th>Tanggal</th>
                        <th>Akun </th>
                        <th>Nilai</th>
                        <th>Chart Of Account</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurnalumums as $ju)
                      @if($ju['jurnalable_type'] == 'App\FakturBelanja')
                          @foreach ($ju->jurnalable->pengeluaran as $penge)
                              @if(empty( $penge->coa_id ))
                                <tr>
                                  <td class="hide field_id">{!! $ju->id !!}</td>
                                  <td>{!! $ju->tanggal !!}</td>
                                  <td>{!! $penge->bukanObat->nama !!}</td>
                                  <td class="uang">{!! $ju->nilai !!}</td>
                                  <td>
                                      {!! Form::select('coa', $bebanCoaList, null, ['class' => 'form-control rq selectpick kode_coa', 'onchange' => 'coaChange(this); return false;', 'data-live-search' => 'true']) !!}
                                  </td>
                                </tr>
                              @endif
                          @endforeach
                      @endif
                    @endforeach
                </tbody>
            </table>
      </div>
</div>

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                  <h3>Coa Pendapatan Lain</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table borderless table-condensed">
                <thead>
                    <tr>
                        <th class="hide field_id">id</th>
                        <th>Tanggal</th>
                        <th>Pendapatan</th>
                        <th>Biaya</th>
                        <th>Chart Of Account</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurnalumums as $ju)
                      @if($ju['jurnalable_type'] == 'App\Pendapatan')
                        <tr>
                          <td class="hide field_id">{!! $ju->id !!}</td>
                          <td>{!! App\Classes\Yoga::updateDatePrep($ju->tanggal) !!}</td>
                          <td>{!! $ju->jurnalable->pendapatan !!}</td>
                          <td class="uang">{!! $ju->nilai !!}</td>
                           <td>
                               {!! Form::select('coa', $pendapatanCoaList, null, ['class' => 'form-control selectpick', 'onchange' => 'coaChange(this); return false;', 'data-live-search' => 'true']) !!}
                          </td>
                          <td>{!! $ju->jurnalable->keterangan !!}</td>
                          <td>
                            <a href="#" class="btn btn-info btn-xs btn-block">Detail</a>
                          </td>
                        </tr>
                      @endif
                    @endforeach
                </tbody>
            </table>
      </div>
</div>
{!! Form::open(['url' => 'jurnal_umums/coa']) !!}
{!! Form::textarea('temp', json_encode($jurnalumums), ['class' => 'form-control', 'id' => 'temp']) !!}
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
@stop
@section('footer') 

<script>
    $(function () {
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
    console.log('id = ' + id);
    var data = JSON.parse($('#temp').val());
    for (var i = 0; i < data.length; i++) {
      if (data[i].id == id) {
        data[i].coa_id = $(control).val();
        break;
      }
    }

    var string = JSON.stringify(data);
    $('#temp').val(string);
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

               $('select.kode_coa').html(temp).selectpicker('refresh');
               $('select.kode_coa').each(function(){
                    if( $(this).val() == '' ){
                        $(this).html(temp).selectpicker('refresh');
                    } else {
                        $(this).append('<option value="' + coa_id + '">' + coa + '</option>').selectpicker('refresh');
                    }
                    
               });

               $('#coa_baru').modal('hide');
           }
       );
   }
    
</script>

@stop
