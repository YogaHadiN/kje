@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Pembayaran

@stop
@section('page-title') 
<h2>Laporan Pembayaran Asuransi {!! $asuransi !!}</h2>
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
<div class="row">
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Pembayaran</div>
            </div>
            <div class="panel-body">
                {!! Form::open(['url'=>'pendapatans/pembayaran/asuransi', 'method'=> 'post']) !!} 
                    {!! Form::textarea('temp', json_encode( $pembayarans ), ['class' => 'form-control', 'id' => 'pembayarans']) !!} 
                    {!! Form::hidden('mulai', $mulai, ['class' => 'form-control']) !!} 
                    {!! Form::hidden('akhir', $akhir, ['class' => 'form-control']) !!} 
                <div class="form-group hide">
                    {!! Form::label('asuransi_id', 'Staf') !!}
                    {!! Form::text('asuransi_id' , $asuransi_id, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('piutang', 'Piutang') !!}
                  {!! Form::text('Piutang' , null, ['class' => 'form-control', 'disabled'=>'disabled', 'id'=>'piutang']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('dibayar', 'Pembayaran') !!}
                    {!! Form::text('dibayar', null, ['class' => 'form-control rq', 'id' => 'pembayaran']) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="button" onclick="submitPage();return false;">Submit</button>
                    {!! Form::submit('Bayar', ['class' => 'btn btn-success hide', 'id'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panelLeft">
            <div class="panel-title">Detail Pembayaran</div>
        </div>
        <div class="panelRight">
            <a class="btn btn-success" href="#" onclick="cekAll();return false;">Cek Semua</a>
            <a class="btn btn-danger" href="#" onclick="resetAll();return false;">Reset Semua</a>
        </div>
    </div>
    <div class="panel-body">
        <div class-"table-responsive">
            <table class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th>ID PERIKSA</th>
                        <th>Nama Pasien</th>
                        <th>Piutang</th>
                        <th>Sudah Dibayar</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table_temp">
                </tbody>
            </table>
        </div>
    </div>
</div>
    


@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    $(function () {
        view();
    });
function cek(control){
//    var uang = 'Rp. 25.000,-'
//    console.log( cleanUang(uang) );
    var sudah_dibayar = $(control).closest('tr').find('td:nth-child(4)').html();
    var piutang = $(control).closest('tr').find('td:nth-child(3)').html();
    sudah_dibayar = cleanUang(sudah_dibayar.trim());
    piutang = cleanUang(piutang.trim());
    var akan_dibayar = parseInt(piutang) - parseInt(sudah_dibayar);
    var key = $(control).val();

    var Array = $('#pembayarans').val();
    Array = JSON.parse(Array);
    console.log(Array);
    Array[key].akan_dibayar = akan_dibayar;
    $('#pembayarans').val(JSON.stringify(Array));
    view();
}
function reset(control){
    var key = $(control).val();
    var Array = $('#pembayarans').val();
    Array = $.parseJSON(Array);
    Array[key].akan_dibayar = 0;
    $('#pembayarans').val(JSON.stringify(Array));
    view();
}
function cekAll(){
    var Array = $('#pembayarans').val();
    Array = $.parseJSON(Array);
    console.log(Array);
    for (var i = 0; i < Array.length; i++) {
        var piutang = Array[i].piutang;
        var sudah_dibayar = Array[i].pembayaran;
        var akan_dibayar = parseInt(piutang) - parseInt(sudah_dibayar);
        Array[i].akan_dibayar = akan_dibayar;
    };
    $('#pembayarans').val(JSON.stringify(Array));
    view();
}
function view(){
    let MyArray = $('#pembayarans').val();
    MyArray = $.parseJSON(MyArray);
    var temp = '';
    var akan_dibayar = 0;
    for (var i = 0; i < MyArray.length; i++) {
        temp += '<tr>';
        temp += '<td>' + MyArray[i].periksa_id + '</td>';
        temp += '<td>' + MyArray[i].nama_pasien + '</td>';
        temp += '<td class="uang">' + MyArray[i].piutang + '</td>';
        temp += '<td class="uang">' + MyArray[i].pembayaran + '</td>';
        temp += '<td><input class="form-control" value="' + MyArray[i].akan_dibayar + '" /></td>';
        if(MyArray[i].piutang - MyArray[i].pembayaran < 1){
        var status = '<div class="alert-success">';
        status += 'Sudah Lunas';
        status += '</div>';
        } else {
        var status = '<div class="alert-danger">';
        status += 'Belum Lunas';
        status += '</div>';
        }

        
        temp += '<td>' + status + '</td>';
        temp += '<td><button class="btn btn-sm btn-primary" onclick="cek(this);return false;" type="button" value="' + i + '">Cek</button> ';
        temp += '<button class="btn btn-sm btn-warning" onclick="reset(this);return false;" type="button" value="' + i + '">Reset</button></td>';
        temp += '</tr>';
        akan_dibayar += MyArray[i].akan_dibayar;
    };
    $('#table_temp').html(temp);
    $('#piutang').val(akan_dibayar);

    formatUang();
}
function resetAll(){
    var Array = $('#pembayarans').val();
    Array = $.parseJSON(Array);
    console.log(Array);
    for (var i = 0; i < Array.length; i++) {
        Array[i].akan_dibayar = 0;
    };
    $('#pembayarans').val(JSON.stringify(Array));
    view();
}

function submitPage(){
    if(validatePass()){
     $('#submit').click();
    }
     
}


</script>
@stop

