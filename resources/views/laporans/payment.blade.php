@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Pembayaran

@stop
@section('page-title') 
 <h2>Laporan Pembayaran Asuransi {!! $asuransi->nama !!}</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Per Pembayaran</strong>
      </li>
</ol>
@stop
@section('content') 
<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="alert alert-success">
        <div class="row">
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              Mulai Tanggal
              <input type="text" class="form-control tanggal" id="tanggalMulai">
          </div>
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              Sampai Tanggal
              <input type="text" class="form-control tanggal" id="tanggalAkhir">
          </div>
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <br>
            <button class="btn btn-success" onclick='filter();return false;'>Filter</button>
          </div>
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <br>
              <button type="submit" class="btn btn-lg btn-primary btn-block" onclick="submit(); return false;">Bayar <span id="berapa"></span></button>
          </div>
        </div>
      </div>
  </div>
</div>
<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                      <div class="panel-heading">
                        <div class="panelLeft">
                            <h3 id="left"></h3>
                        </div>
                        <div class="panelRight">
                          <button type="button" class="btn btn-success" onclick="centant_semua();return false;">Centang Semua</button>
                        </div>
                      </div>
                      <div class="panel-body">
                        {!! Form::open(['url' => 'laporans/payment', 'method' => 'post'])!!}
                            {!! Form::textarea('temp', json_encode($periksas), ['class' => 'form-control hide', 'id' => 'temp'])!!}
                            {!! Form::text('biaya', null, ['class' => 'form-control hide', 'id' => 'biaya'])!!}
                            {!! Form::text('asuransi_id', $asuransi->id, ['class' => 'hide', 'id' => 'asuransi_id'])!!}
                            {!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit'])!!}
                        {!! Form::close() !!}
                            <table class="table table-bordered table-hover" id="tableAsuransi">
                                  <thead>
                                    <tr>
                                        <th class="hide">key</th>
                                        <th>id</th>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Nama Asuransi</th>
                                        <th>Piutang</th>
                                        <th>Piutang Sudah Dibayar</th>
                                        <th colspan="2">Action</th>
                                        <th class="hide">piutang_dibayar</th>
                                    </tr>
                                </thead>
                                <tbody id="ajax">
                                   

                                </tbody>
                                <tfoot>
                              
                                </tfoot>
                            </table>
                      </div>
                </div>
          </div>
      </div>
@stop
@section('footer') 

	<script>
  var base = '{{ url("/") }}';
  var MyArray = [];
  var biaya = 0;
  jQuery(document).ready(function($) {
    view();
  });
      function view(){
        MyArray = $('#temp').val();
        MyArray = $.parseJSON(MyArray);
        var temp = '';
        for (var i = 0; i < MyArray.length; i++) {
          temp += '<tr>';
          temp += '<td class="hide">' + i + '</td>';
          temp += '<td>' + MyArray[i].id + '</td>';
          temp += '<td>' + MyArray[i].tanggal + '</td>';
          temp += '<td>' + MyArray[i].nama + '</td>';
          temp += '<td>' + MyArray[i].nama_asuransi + '</td>';
          temp += '<td>' + MyArray[i].piutang + '</td>';
          temp += '<td><input class="form-control piutang_dibayar" value="' + MyArray[i].piutang_dibayar + '" onkeyup="keyup(this);return false;"/></td>';
          temp += '<td><button type="button" class="btn btn-danger btn-xs" onclick="reset(this);return false;">Reset</button></td>';
          temp += '<td><button type="button" class="btn btn-success btn-xs" onclick="bayar(this);return false;">Pay</button></td>';
          temp += '<td class="hide">' + MyArray[i].piutang_dibayar_awal + '</td>';
          temp += '</tr>';
        }

        if(MyArray.length < 1){
          temp += '<tr>';
          temp += '<td class="hide"></td>';
          temp += '<td colspan="8" class="text-center">Tidak ada data untuk ditampilkan :p</td>';
          temp += '<td class="hide"></td>';
          temp += '</tr>';
        }


        $('#ajax').html(temp).hide().fadeIn(500);
        hitung_bayar();
      }

      function centant_semua(){
        $('.piutang_dibayar').each(function(index, el) {
            var i = $(this).closest('tr').find('td:first-child').html();
            var dibayar = $(this).closest('tr').find('td:nth-child(6)').html();
            var dibayar_awal = $(this).closest('tr').find('td:last-child').html();
            biaya += parseInt(dibayar) - parseInt(dibayar_awal);
            $(this).val(dibayar);
            MyArray[i].piutang_dibayar = dibayar;
        });
        $('#temp').val(JSON.stringify(MyArray));
        hitung_bayar();
        
      }
      function keyup(control){
        var i = $(control).closest('tr').find('td:first-child').html();
        var dibayar = $(control).val();
        MyArray[i].piutang_dibayar = dibayar;
        // console.log(dibayar);
        $('#temp').val(JSON.stringify(MyArray));
        hitung_bayar();
      }
      function hitung_bayar(){
        var biaya = 0;
        var i = 0;
        $('.piutang_dibayar').each(function(index, el) {
            var dibayar_ini = $(this).val();
            var dibayar_awal_ini = $(this).closest('tr').find('td:last-child').html();
            biaya += parseInt(dibayar_ini) - parseInt(dibayar_awal_ini);
            i++;
        });
        $('#berapa').html('Rp. ' + biaya + ',-');
        $('#biaya').val(biaya);
        $('#left').html('Total : ' + i + ' data');
      }
      function submit(){
        $('#submit').click();
      }

      function filter() {
        var awal = $('#tanggalMulai').val();
        var akhir = $('#tanggalAkhir').val();

        if ((awal == '' && akhir != '' )|| (akhir == '' && awal != '')) {
          if (awal == '') {
            validasi('#tanggalMulai', 'Harus diisi!');
          }
          if (akhir == '') {
            validasi('#tanggalAkhir', 'Harus diisi!');
          }
        } else {
          var param = {
            'awal' : awal, 
            'akhir' : akhir,
            'id' : $('#asuransi_id').val()
          }
          $.post( base + '/laporans/ajax/filter', param, function(data) {
            $('#temp').fadeOut('500', function() {
              data = $.trim(data);
              $('#temp').val(data);
              view();
            });
          })
        }
      }

      function reset(control){
        var i = $(control).closest('tr').find('td:first-child').html();
        var awal = $(control).closest('tr').find('td:last-child').html();
        MyArray[i]['piutang_dibayar'] = awal;
        $('#temp').val(JSON.stringify(MyArray));
        $(control).closest('tr').find('input').val(awal);
        hitung_bayar();

        // alert($(control).closest('tr').find('input').val());
      }
      function bayar(control){
        var i = $(control).closest('tr').find('td:first-child').html();
        var awal = $(control).closest('tr').find('td:nth-child(6)').html();
        MyArray[i]['piutang_dibayar'] = awal;
        $('#temp').val(JSON.stringify(MyArray));
        $(control).closest('tr').find('input').val(awal);
        hitung_bayar();
        // alert($(control).closest('tr').find('input').val());
      }

  </script>
@stop