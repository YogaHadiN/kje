@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Pembayaran

@stop
@section('page-title') 
<h2>Laporan Pembayaran {!! $asuransi !!}</h2>
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
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="panel-title">Pembayaran</div>
            </div>
            <div class="panel-body">
                {!! Form::open(['url'=>'pendapatans/pembayaran/asuransi', 'method'=> 'post']) !!} 
                    {!! Form::textarea('temp', json_encode( $pembayarans ), ['class' => 'form-control hide', 'id' => 'pembayarans']) !!} 
                    {!! Form::hidden('mulai', $mulai, ['class' => 'form-control']) !!} 
                    {!! Form::hidden('akhir', $akhir, ['class' => 'form-control']) !!} 
                <div class="form-group hide">
                    {!! Form::label('asuransi_id', 'Staf') !!}
                    {!! Form::text('asuransi_id' , $asuransi_id, ['class' => 'form-control']) !!}
                </div>
				<div class="form-group @if($errors->has('staf_id'))has-error @endif">
				  {!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
                  {!! Form::select('staf_id', App\Classes\Yoga::stafList() , null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true', 'id'=>'staf_id']) !!}
				  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
				</div>
                @if (\Auth::id() == 28)
					<div class="form-group @if($errors->has('coa_id'))has-error @endif">
					  {!! Form::label('coa_id', 'Akun Kas Tujuan', ['class' => 'control-label']) !!}
                      {!! Form::select('coa_id', $kasList, null, ['class' => 'form-control rq', 'id'=>'kasList']) !!}
					  @if($errors->has('coa_id'))<code>{{ $errors->first('coa_id') }}</code>@endif
					</div>
                @else
                    <div class="form-group">
                      {!! Form::label('coa_id', 'Akun Kas Tujuan') !!}
                      {!! Form::select('coa_id', $kasList, 110000, ['class' => 'form-control rq', 'id'=>'kasList', 'readonly' => 'readonly']) !!}
					  @if($errors->has('coa_id'))<code>{{ $errors->first('coa_id') }}</code>@endif
					</div>
                @endif
                
				<div class="form-group @if($errors->has('tanggal_dibayar'))has-error @endif">
				  {!! Form::label('tanggal_dibayar', 'Tanggal Dibayar', ['class' => 'control-label']) !!}
                  {!! Form::text('tanggal_dibayar' , null, ['class' => 'form-control tanggal rq']) !!}
				  @if($errors->has('tanggal_dibayar'))<code>{{ $errors->first('tanggal_dibayar') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('dibayar'))has-error @endif">
				  {!! Form::label('dibayar', 'Dibayar Sebesar', ['class' => 'control-label']) !!}
                  {!! Form::text('dibayar' , null, ['class' => 'form-control rq', 'id'=>'piutang']) !!}
				  @if($errors->has('dibayar'))<code>{{ $errors->first('dibayar') }}</code>@endif
				</div>
                <div class="form-group">
                    <button class="btn btn-success btn-lg btn-block" type="button" onclick="submitPage();return false;">Bayar</button>
                    {!! Form::submit('Bayar', ['class' => 'btn btn-success hide', 'id'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Informasi</div>
            </div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <tr>
                                <td>Nama Asuransi</td>
                                <td class="text-right"> {{ $asuransi }}</td>
                            </tr>
                            <tr>
                                <td>Mulai</td>
                                <td class="text-right"> {{ App\Classes\Yoga::updateDatePrep( $mulai ) }}</td>
                            </tr>
                            <tr>
                                <td>Akhir</td>
                                <td class="text-right"> {{ App\Classes\Yoga::updateDatePrep( $akhir ) }}</td>
                            </tr>
                            <tr>
                                <td> Total Piutang </td>
                                <td id="piutang_total" class="uang"></td>
                            </tr>
                            <tr>
                                <td>Sudah Dibayat Total</td>
                                <td id="sudah_dibayar_total" class="uang"></td>
                            </tr>
                            <tr>
                                <td>Belum Dibayat Total</td>
                                <td id="belum_dibayar_total" class="uang"></td>
                            </tr>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 <div class="panel panel-danger">
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
                <tbody id="table_temp2">
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
    var temp2 = '';
    var akan_dibayar = 0;
    var piutang_total = 0;
    var sudah_dibayar_total = 0;
    var belum_dibayar_total = 0;
    for (var i = 0; i < MyArray.length; i++) {
        if(MyArray[i].piutang - MyArray[i].pembayaran < 1){

            piutang_total += MyArray[i].piutang;
            sudah_dibayar_total += MyArray[i].pembayaran;
            belum_dibayar_total += MyArray[i].piutang - MyArray[i].pembayaran;
            temp += '<tr>';
            temp += '<td>' + MyArray[i].periksa_id + '</td>';
            temp += '<td>' + MyArray[i].nama_pasien + '</td>';
            temp += '<td class="uang">' + MyArray[i].piutang + '</td>';
            temp += '<td class="uang">' + MyArray[i].pembayaran + '</td>';
            temp += '<td class="hide"><input class="form-control" value="' + MyArray[i].akan_dibayar + '" /></td>';
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
            temp += '<td class="hide"><button class="btn btn-sm btn-primary" onclick="cek(this);return false;" type="button" value="' + i + '">Cek</button> ';
            temp += '<button class="btn btn-sm btn-warning" onclick="reset(this);return false;" type="button" value="' + i + '">Reset</button></td>';
            temp += '</tr>';
            akan_dibayar += parseInt( MyArray[i].akan_dibayar );

        } else {
        
            piutang_total += MyArray[i].piutang;
            sudah_dibayar_total += MyArray[i].pembayaran;
            belum_dibayar_total += MyArray[i].piutang - MyArray[i].pembayaran;
            temp2 += '<tr>';
            temp2 += '<td>' + MyArray[i].periksa_id + '</td>';
            temp2 += '<td>' + MyArray[i].nama_pasien + '</td>';
            temp2 += '<td class="uang">' + MyArray[i].piutang + '</td>';
            temp2 += '<td class="uang">' + MyArray[i].pembayaran + '</td>';
            temp2 += '<td><input class="form-control angka2 akan_dibayar" value="' + MyArray[i].akan_dibayar + '" onkeyup="akanDibayarKeyup(this);return false;" /></td>';
            if(MyArray[i].piutang - MyArray[i].pembayaran < 1){
            var status = '<div class="alert-success">';
            status += 'Sudah Lunas';
            status += '</div>';
            } else {
            var status = '<div class="alert-danger">';
            status += 'Belum Lunas';
            status += '</div>';
            }
            temp2 += '<td>' + status + '</td>';
            temp2 += '<td><button class="btn btn-sm btn-primary" onclick="cek(this);return false;" type="button" value="' + i + '">Cek</button> ';
            temp2 += '<button class="btn btn-sm btn-warning" onclick="reset(this);return false;" type="button" value="' + i + '">Reset</button></td>';
            temp2 += '</tr>';
            akan_dibayar += parseInt( MyArray[i].akan_dibayar );

        }

    };
    $('#table_temp').html(temp);
    $('#table_temp2').html(temp2);
    $('#piutang').val(akan_dibayar);
    $('#piutang_total').html(piutang_total);
    $('#belum_dibayar_total').html(belum_dibayar_total);
    $('#sudah_dibayar_total').html(sudah_dibayar_total);
    $('#dibayar_sebesar').html(akan_dibayar);
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

    if(validatePass() && $('#piutang').val() > 0 && $('#staf_id').val() != '' ){
         $('#submit').click();
    } else if($('#piutang').val() < 1 ){
        alert('Nilai yang dibayarkan harus lebih besar dari 0');
    }

     
}
function akanDibayarKeyup(control){

	var before = $(control).val();
	$(control).val(parseInt(before) || '');
	if ( $(control).val() == '' ) {
		$(control).val('0')
	}

	var jumlahAkanDibayar =0;
	$('.akan_dibayar').each(function(){
		 jumlahAkanDibayar += parseInt( $(this).val() );
	});
	$('#piutang').val(jumlahAkanDibayar); 
	console.log("jumlahAkanDibayar");
	console.log(jumlahAkanDibayar);

	var tempJson = $('#pembayarans').val();
	var tempArray = JSON.parse(tempJson);

	var i = $(control).closest('tr').find('.btn-primary').val();

	tempArray[i].akan_dibayar = $(control).val();

	$('#pembayarans').val( JSON.stringify(tempArray) );
}




</script>
@stop

