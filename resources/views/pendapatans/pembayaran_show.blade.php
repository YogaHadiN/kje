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
                <h1>Dokter {{ $nama_staf }}</h1>
                {!! Form::open(['url'=>'pengeluarans/bayardokter/bayar', 'method'=> 'post']) !!} 
                    {!! Form::hidden('mulai', $mulai, ['class' => 'form-control']) !!} 
                    {!! Form::hidden('akhir', $akhir, ['class' => 'form-control']) !!} 
                <div class="form-group hide">
                    {!! Form::label('asuransi_id', 'Staf') !!}
                    {!! Form::text('asuransi_id' , $id, ['class' => 'form-control']) !!}
                </div>
                <!--<div class="form-group">-->
                    <!--{!! Form::label('hutang', 'Jasa Dokter') !!}-->
                    <!--{!! Form::text('hutang' , $total, ['class' => 'form-control', 'readonly' => 'readonly']) !!}-->
                <!--</div>  -->
                <div class="form-group">
                    {!! Form::label('dibayar', 'Pembayaran') !!}
                    {!! Form::text('dibayar', null, ['class' => 'form-control', 'id' => 'pembayaran']) !!}
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
        </div>
    </div>
    <div class="panel-body">
        <div class-"table-responsive">
            <table class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th>ID PERIKSA</th>
                        <th>Nama Pasien</th>
                        <th>Tunai</th>
                        <th>Piutang</th>
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
{!! Form::open(['url'=>'pendapatans/pembayaran/asuransi', 'method'=> 'post']) !!} 

{!! Form::textarea('temp', json_encode( $pembayarans ), ['class' => 'form-control', 'id' => 'pembayarans']) !!} 
    
    
{!! Form::close() !!}



@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    $(function () {
        let MyArray = $('#pembayarans').val();
        MyArray = $.parseJSON(MyArray);
        let temp = '';
        for (var i = 0; i < MyArray.length; i++) {
            temp += '<tr>';
            temp += '<td>' + MyArray[i].periksa_id + '</td>';
            temp += '<td>' + MyArray[i].nama_pasien + '</td>';
            temp += '<td class="uang">' + MyArray[i].tunai + '</td>';
            temp += '<td class="uang">' + MyArray[i].piutang + '</td>';

            if(MyArray[i].pembayaran == null){
               var pembayaran = 0;  
            }else{
               var pembayaran = MyArray[i].pembayaran;  
            }
            temp += '<td><input class="form-control" value="' + pembayaran + '" /></td>';
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
            temp += '<td><a href="#" class="btn btn-xs btn-primary" onclick="cek(this);return false;">Cek</a> ';
            temp += '<a href="#" class="btn btn-xs btn-warning" onclick="reset(this);return false;">Reset</a></td>';
            temp += '</tr>';
        };
        $('#table_temp').html(temp);
        formatUang();
    });
function cek(control){
    alert('cek');
}
function reset(control){
    alert('reset');
}
function cekAll(control){
    alert('cekAll');
}

</script>
@stop

