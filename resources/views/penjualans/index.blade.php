@extends('layout.master')

@section('title') 
Klinik Jati Elok | Entri Jual Obat

@stop
@section('page-title') 
<h2>Penjualan Obat Tanpa Resep</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Penjualan Tanpa Resep</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="row">
  {!! Form::open(['url' => 'penjualans', 'method' =>'post'])!!}
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <div class="form-group @if($errors->has('staf_id')) has-error @endif">
      {!! Form::label('staf_id', 'Petugas') !!}
      {!! Form::select('staf_id', $stafs, null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true'])!!}
      @if($errors->has('staf_id'))
          <code>
              {{ $errors->first('staf_id') }}
          </code>
      @endif
    </div>
  </div>
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <div class="form-group">
        {!! Form::label('tanggal', 'Tanggal') !!}
        {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control tanggal rq']) !!}
      </div>
  </div>
</div>
<br>
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                </div>
                <div class="panelRight bold">
                  <span class="">Total : </span><span class="uang " id="totalHargaObat">0</span>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover" id="tableEntriBeli" nowrap>
                  <thead>
                    <tr>
                       <th>No</th>
                       <th>Merek Obat</th>
                       <th class="displayNone">Harga Beli</th>
                       <th>Harga Jual</th>
                       <th>Exp Date</th>
                       <th>Jumlah</th>
                       <th nowrap>Harga Item</th>
                       <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2">{!! Form::select('merek_id', $mereks, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true', 'id' => 'ddl_merek_id', 'onchange' => 'ddlChange(this)'])!!}</td>
                       <td class="displayNone"><input type="text" id="txt_harga_beli" class="form-control" placeholder="harga beli"/></td>
                       <td><input type="text" id="txt_harga_jual" class="form-control" placeholder="harga jual" disabled/></td>
                       <td><input type="text" id="txt_exp_date" class="form-control tanggal" placeholder="exp date" disabled/></td>
                       <td><input type="text" id="txt_jumlah" class="form-control" placeholder="jumlah"/></td>
                       <td colspan="2"><button type="button" id="btn_Action" class="btn btn-primary btn-sm btn-block" onclick="input(this);return false;">input</buttomn></td>
                    </tr>
                </tfoot>
            </table>
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <button class="btn btn-primary btn-lg btn-block" type="button" onclick="dummySubmit();return false;">Submit</button>
                  {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-block btn-primary hide', 'id'=>'submit'])!!} 
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="" class="btn btn-lg btn-block btn-danger">Cancel</a>
              </div>
            </div>
            <div class="hide form-group @if($errors->has('tempBeli')) has-error @endif">
                {!! Form::label('tempBeli', 'Barang Belanjaan') !!}
                {!! Form::textarea('tempBeli' , null, ['class' => 'form-control rq', 'id' => 'tempBeli']) !!}
                @if($errors->has('tempBeli'))
                  <code>
                      {{ $errors->first('tempBeli') }}
                  </code>
                @endif
            </div>
          {!! Form::close()!!}
      </div>
</div>
@stop
@section('footer') 
  <script>
    var data=[];
    var dataTambah='';
    var lanjut = true;

    $(document).ready(function() {
      if ($('#tempBeli').val() == '' || $('#tempBeli').val == '[]') {
      } else {
        data = $('#tempBeli').val();
        data = $.parseJSON(data);
        viewData(data);
      }
      $('#btn_Action').keypress(function(e) {
        var key = e.keyCode || e.which;

        if (key == 9){
          $(this).click();
          return false
        }
      });
    });

    function input(control) {
        if (
          $('#ddl_merek_id').val() == '' ||
          $('#txt_exp_date').val() == '' ||
          $('#txt_harga_jual').val() == '' ||
          $('#txt_jumlah').val() == ''
        ){
          if($('#ddl_merek_id').val() == ''){
            validasi('#ddl_merek_id', 'Harus Diisi!!');
          }
          if($('#txt_exp_date').val() == ''){
            validasi('#txt_exp_date', 'Harus Diisi!!');
          }
          if($('#txt_harga_jual').val() == ''){
            validasi('#txt_harga_jual', 'Harus Diisi!!');
          }
          if($('#txt_jumlah').val() == ''){
            validasi('#txt_jumlah', 'Harus Diisi!!');
          }
        } else {

            var merek = $(control).closest('tr').find('td:nth-child(1) select option:selected').text();
            var ddl_value = $(control).closest('tr').find('td:nth-child(1) select').val();
            var harga_jual = $(control).closest('tr').find('td:nth-child(3) input').val();
            var exp_date = $(control).closest('tr').find('td:nth-child(4) input').val();
            var jumlah = $(control).closest('tr').find('td:nth-child(5) input').val();

            var merek_id = getMerekId(ddl_value);
            var sediaan = getSediaan(ddl_value);

            dataTambah = {
              'merek' : merek,
              'merek_id' : merek_id,
              'harga_jual' : harga_jual,
              'exp_date' : exp_date,
              'jumlah' : jumlah
            };

            var merek_bool = false;
            for (var i = 0; i < data.length; i++) {
              if(data[i].merek_id == merek_id){
                merek_bool = true;
                break;
              }
            };

              if(merek_bool){
                var r = confirm('Merek yang sama sudah pernah dimasukkan, lanjutkan?');
                if (r) {
                  lanjut = true;    
                } else{
                  lanjut = false;
                };
              }

              if (lanjut) {
                submitInput();
              };

              lanjut = true;


      }
    }

    function viewData(dataf){
      var temp = '';
      var total = 0;
      for (var i = 0; i < dataf.length; i++) {

        var biaya = parseInt(dataf[i].harga_jual) * parseInt(dataf[i].jumlah);
        temp += '<tr>';
        temp += '<td nowrap>' + (i + 1) + '</td>';
        temp += '<td nowrap>' + dataf[i].merek + '</td>';
        temp += '<td nowrap class="uang displayNone">' + dataf[i].harga_beli + '</td>';
        temp += '<td nowrap class="uang">' + dataf[i].harga_jual + '</td>';
        temp += '<td nowrap>' + dataf[i].exp_date + '</td>';
        temp += '<td nowrap class="jumlah">' + dataf[i].jumlah + '</td>';
        temp += '<td nowrap class="uang">' + biaya + '</td>';
        temp += '<td nowrap><a href="#" class="btn btn-danger btn-xs" onclick="rowDel(' + i + ');return false;">hapus</a></td>';
        temp += '</tr>';

        total += biaya;

      };

      clearForm();

      $('#tableEntriBeli tbody').html(temp);
      $('#tempBeli').val(JSON.stringify(dataf));
      $('#totalHargaObat').html(total);

      $('.uang').each(function() {
          var number = $(this).html();
          number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
          $(this).html('Rp. ' + number + ',-');
      });
      
      $('.jumlah').each(function() {
          var number = $(this).html();
          number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
          $(this).html(number);
      });
      return false;
    }

    function rowDel(control){

        data.splice(control, 1);
        viewData(data);

    }
    function ddlChange(control){
      control = $(control).val();
      control = $.parseJSON(control);

      var merek_id = control.merek_id;
      var harga_jual = control.harga_jual;
      var exp_date = control.exp_date;

      exp_date = exp_date.split('-');
      exp_date = exp_date[2] + '-' + exp_date[1] + '-' + exp_date[0]

      var harga_beli = control.harga_beli;

      $('#txt_harga_beli').val(harga_beli);
      $('#txt_harga_jual').val(harga_jual);
      $('#txt_exp_date').val(exp_date);

    }
    function getMerekId(control){
      control = $.parseJSON(control);
      return control.merek_id;
    }
    function getHargaBeli(control){
      control = $.parseJSON(control);
      return control.harga_beli;
    }
    function getExpDate(control){
      control = $.parseJSON(control);
      return control.exp_date;
    }
    function getSediaan(control){
      control = $.parseJSON(control);
      return control.sediaan;
    }
    function confSubmit(selector, message){
        var r = confirm(message);
        if (r) {
          lanjut = true;
        } else {
          lanjut = false;
          $(selector).focus();
        }
    }

    function submitInput(){
      data[data.length] = dataTambah;
      viewData(data); 
    }

    function clearForm() {

      $('#ddl_merek_id').val('').selectpicker('refresh');
      $('#txt_exp_date').val('');
      $('#txt_harga_beli').val('');
      $('#txt_harga_jual').val('');
      $('#txt_jumlah').val('');

      $('#ddl_merek_id').closest('td').find('.btn-white').focus();
    }

    function dummySubmit(){
        if(validatePass()){
          $('#submit').click();
        }
    }
  </script>
@stop
