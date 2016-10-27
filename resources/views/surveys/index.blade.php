@extends('layout.master')

@section('title') 
Klinik Jati Elok | Asuransi

@stop
@section('head')
    <link href="{!! asset('css/print.css') !!}" rel="stylesheet" media="print">
@stop
@section('page-title') 
<h2>List Semua Asuransi</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('antriankasirs')}}">Antrian Kasir</a>
      </li>
      <li class="active">
          <strong>Survey</strong>
      </li>
</ol>
@stop
@section('content') 
	{!! Form::open([
		'url' => 'update/surveys', 
		'method' => 'post', 
		'files' => true, 
		'autocomplete' => 'off'
	])!!}
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                          <div class="panel-heading">
                                <h3 class="panel-title">Obat</h3>
                          </div>
                          <div class="panel-body">

                            <table class="table table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th>Merek Obat</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Biaya</th>
                                    </tr>
                                </thead>
                                <tbody id="tblResep">
                                    @foreach ($reseps as $resep)
                                        <tr>
                                            <td nowrap>
                                                {!!$resep['merek_obat']!!}
                                            </td>
                                            <td nowrap>
                                               {!! $resep['jumlah'] !!} 
                                            </td>
                                            <td nowrap class="uang">
                                                @if($periksa->asuransi->tipe_asuransi == 5)
                                                    @if($resep['fornas'] == '0')
                                                        {!! $resep['harga_jual'] * $periksa->asuransi->kali_obat !!}
                                                    @else 
                                                        0            
                                                    @endif                
                                                @else
                                                    {!! $resep['harga_jual'] * $periksa->asuransi->kali_obat !!}
                                                @endif                
                                            </td>
                                            <td nowrap class="uang">
                                                @if($periksa->asuransi->tipe_asuransi == 5)
                                                    @if($resep['fornas'] == '0')
                                                        {!! $resep['jumlah'] * $resep['harga_jual'] * $periksa->asuransi->kali_obat !!}
                                                    @else
                                                        0
                                                    @endif
                                                @else
                                                    {!! $resep['jumlah'] * $resep['harga_jual'] * $periksa->asuransi->kali_obat !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td nowrap class="displayNone"></td>
                                        <td nowrap colspan="4" class="text-right"><h2>Total Biaya Obat : <span class="uang">{!!$biayatotal!!}</span></td>
                                    </tr>
                                </tfoot>
                            </table>

                          </div>
                    </div>
                    <div class="panel panel-danger">
                          <div class="panel-heading">
                                <h3 class="panel-title">PASTIKAN RESEP DOKTER SAMA</h3>
                          </div>
                          <div class="panel-body">
                                {!! $periksa->terapi_htmll!!}
                               @if (!empty($periksa->resepluar))
                                   <hr>
                                   <p>Resep ditebut di apotek di Luar :</p>
                                   {!! $periksa->resepluar !!}
                               @endif
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                     <a href="#" id="dummySubmit" class="btn btn-primary btn-lg btn-block" onclick="submitPage();return false">Submit</a>
                                    <input type="submit" name="submit" value="lanjutkan" class="btn btn-info btn-block btn-lg hide" id="submitthis" />
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    
                                    <a href="#" class="btn btn-danger btn-lg btn-block">Cancel</a>
                                </div>
                            </div>
                          </div>
                    </div>
					@if($periksa->rujukan && $periksa->asuransi_id == '32')
					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-title">Panel Rujukan</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
										{!! Form::label('image', 'Gambar Rujukan') !!}
										{!! Form::file('image') !!}
										@if (isset($periksa->rujukan) && $periksa->rujukan->image)
											<p> {!! HTML::image(asset($periksa->rujukan->image), null, ['class'=>'img-rounded upload']) !!} </p>
											@else
												<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
											@endif
										{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
									</div>
								</div>
							</div>
						</div>
					</div>
                    @endif
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                      <div class="panel-body">
                            @include('fotoPasien', ['pasien' => $periksa->pasien])
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <td>Periksa ID : </td>
                                        <td>{!! $periksa->id !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Pembayaran</td>
                                        <td>{!! $periksa->asuransi->nama !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                      </div>
                </div>
				
                <div class="panel panel-info">
                      <div class="panel-heading">
                            <div class="text-right">
                                <span class="bold">Total : </span><span class="bold total"></span>
                            </div>
                      </div>
                      <div class="panel-body">
                        <table class="tblTerapi" width="100%">
                            <thead>
                                <tr>
                                    <th>Jenis Tarif</th>
                                    <th>Biaya</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <th colspan="2">{!! Form::select('slcTindakan', $tindakans, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true', 'id' => 'slcTindakan'])!!}</th>
                                    <th><button type="button" class="btn btn-success btn-sm" onclick="insertTindakan(this)">input</button></th>
                                </tr>
                            </thead>
                            <tbody id="tarif">

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td><label for="" class="form-control total" id=""></label></td>
                                </tr>
                                @if($periksa->asuransi_id == 0)
                                    <tr class="hide">
                                        <td>Dibayar Asuransi</td>
                                        <td><input type="text" autocomplete="off"  dir="rtl" class="form-control uangInput" id="dibayar_asuransi" name="dibayar_asuransi" onkeyup="asuransiKeyup(this)" value="0"></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>Dibayar Asuransi</td>
                                        <td><input type="text" autocomplete="off"  dir="rtl" class="form-control uangInput" id="dibayar_asuransi" name="dibayar_asuransi" onkeyup="asuransiKeyup(this)" value="{!! $dibayar !!}"></td>
                                    </tr>
                                @endif
                                @if($periksa->asuransi_id == 0)
                                    <tr class="hide">
                                @else
                                    <tr>
                                @endif
                                    <td>Dibayar Pasien</td>
                                    <td><input type="text" autocomplete="off"  dir="rtl" class="form-control uang" id="dibayar_pasien" name="dibayar_pasien" readonly /></td>
                                </tr>
                                <tr>
                                    <td>Pembayaran</td>
                                    <td>
                                        <input type="text" autocomplete="off"  dir="rtl" class="form-control uangInput" id="pembayaran_pasien" onkeyup="pembayaranKeyup(this)" name="pembayaran"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kembalian</td>
                                    <td>
                                        <input type="text" autocomplete="off"  dir="rtl" class="form-control uang" id="kembalian_pasien" name="kembalian" readonly/>
                                    </td>
                                </tr> 
                            </tfoot>
                        </table>
                        {!! Form::textarea('sebelum', $periksa->transaksi, ['class' => 'hide', 'id' => 'sebelum'])!!}
                        {!! Form::textarea('tarif', $periksa->transaksi, ['class' => 'hide', 'id' => 'txtTarif'])!!}
                        {!! Form::text('periksa_id', $periksa->id, ['class' => 'displayNone', 'id' => 'periksa_id'])!!}
                      </div>
                </div>
            </div>
        </div>
    {!! Form::close()!!}
<button type="button" class="btn btn-info hide" id="print" onclick="testPrint();return false;">klik</button>
<div class="row" id="content-print">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box title-print text-center">
            <h1>Klinik Jati Elok</h1>
            <h5>
                Komplek Bumi Jati Elok Blok A I No. 7, Jl. Raya Legok - Parung Panjang km. 3, Malangnengah, Pagedangan, Tangerang, Banten
                Telp : 021 5977529  
            </h5>
        </div>
       <hr> 
       <div class="box">
           <table>
               <tbody>
                   <tr>
                       <td>Nama Pasien</td>
                       <td>:</td>
                       <td>{{ $periksa->pasien->nama }}</td>
                   </tr>
                   <tr>
                       <td>Tanggal</td>
                       <td>:</td>
                       <td>{{App\Classes\Yoga::updateDatePrep(  $periksa->tanggal  )}}</td>
                   </tr>
                   <tr>
                       <td>Jam Datang</td>
                       <td>:</td>
                       <td>{{ $periksa->jam }}</td>
                   </tr>
                  <tr>
                      <td>Nomor Kuitansi</td>
                      <td>:</td>
                      <td>{{ $periksa->id }}
                  </tr> 
               </tbody>
           </table>
          <hr> 
       </div>
        <div>
            <table class="table table-condensed">
                <tbody id="transaksi-print">
                </tbody>
                <tfoot>
                    <tr class="border-top">
                        <td class="">Total:</td>
                        <td>:</td>
                        <td class="uang text-right" id="biaya-print"></td>
                    </tr>
                    @if($periksa->asuransi_id != 0)
                    <tr>
                        <td nowrap>
                            Dibayar Asuransi
                        </td>
                        <td>:</td>
                        <td class="uang text-right" id="dibayarAsuransi-print">

                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>
                            Pembayaran
                        </td>
                        <td>:</td>
                        <td class="uang text-right" id="pembayaran-print">

                        </td>
                    </tr>
                    <tr>
                        <td>
                            Kembalian
                        </td>
                        <td>:</td>
                        <td class="uang text-right" id="kembalian-print">

                        </td>
                    </tr>

                </tfoot>
            </table>
           <hr> 
<div class="text-center footer box">
    Semoga Lekas Sembuh
</div>
.
        </div>
        </div>
        </div>
@stop
@section('footer') 
<script>
    var base = '{{ url("/") }}';
</script>
<script src="{{ url('js/fotozoom.js') }}" type="text/javascript"></script>
{!! HTML::script('js/togglepanel.js')!!}
@if($periksa->rujukan)
    {!! HTML::script('js/plugins/webcam/photo.js')!!}
@endif
	<script>
    var totalBiaya = 0;
    var totalAwal = 0;

    var data = $('#txtTarif').val();
    data = JSON.parse(data);

    $(document).ready(function() {
		$(window).bind('beforeunload', function(e){
			alert('dada');
		});
        viewTarif(data);
        totalAwal = totalHarga();
        $('.tabelTerapi2 td').click(function(e) {
            $(this).css('color', 'red');
            $(this).append(' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>');
        });

        var dibayar_asuransi_awal = $('#dibayar_asuransi').val();
        asuransiKeyup2(dibayar_asuransi_awal, '#dibayar_pasien');

        formatUangIni();

    });

    function rowDel(control){
        
        data.splice($(control).val(), 1);
        viewTarif(data);
    }

    function viewTarif(data){

        var temp = '';
        var total = 0;

        for (var i = 0; i < data.length; i++) {
            temp += '<tr>';
            temp += '<td><label>' + data[i].jenis_tarif + '</label></td>';
            temp += '<td><input class="form-control money" dir="rtl" autocomplete="off" value="' + data[i].biaya + '" id="txt' + data[i].jenis_tarif.replace(/ /g, '') + i + '" onkeyup="inputTarif(this);" /></td>';
            if(data[i].jenis_tarif == 'Biaya Obat'){
                temp += '<td class="text-center"><button type="button" class="btn btn-danger btn-xs" disabled="disabled" value="' + i + '" onclick="rowDel(this)">hapus</button></td>';
                temp += '<tr>';
            }else{
                temp += '<td class="text-center"><button type="button" class="btn btn-danger btn-xs" value="' + i + '" onclick="rowDel(this)">hapus</button></td>';
                temp += '<tr>';
            }
        }

        total = totalHarga();

        $('#tarif').html(temp);
        temp = JSON.stringify(data);
        $('#txtTarif').val(temp);

        var dibayar_asuransi = parseInt(clean( $('#dibayar_asuransi').val() ));
        console.log('view_tarif dibayar asuransi' + dibayar_asuransi);
        if(dibayar_asuransi == ''){
            dibayar_asuransi = 0;
        }
        console.log('total = ' + total);
        totalBiaya = parseInt(total);
        console.log('totalBiaya = ' + totalBiaya);
 
       $('.total').html(totalBiaya);

        if(dibayar_asuransi == ''){
            $('#dibayar_pasien').val(totalBiaya);
        } else {
            $('#dibayar_pasien').val(parseInt(totalBiaya) - parseInt(dibayar_asuransi));
        }

        var id = $('#dibayar_pasien').attr('id');
        rupiahDibayarPasien("#" + id);
        $('#dibayar_asuransi').focus();

        $('.money').autoNumeric('init', {
            aSep: '.',
            aDec: ',', 
            aSign: 'Rp. ',
            vMin: 0,
            mDec: 0
        });

        $('.total').each(function() {
            var number = $(this).html();
            number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
            $(this).html('Rp. ' + number);
        });

        formatUangIni();

         


    }

    function insertTindakan(control){

        var value = $(control).closest('tr').find('select').val();
        var jenis = $(control).closest('tr').find('select option:selected').text();
        value = JSON.parse(value);

        var biaya = value.biaya;
        var periksa_id = $('#periksa_id').html();
        var tarif_id = value.tarif_id;
        var keterangan = null;
        var jenis_tarif = jenis;
        var jenis_tarif_id = value.jenis_tarif_id;

        data[data.length] = {
            'biaya' : biaya,
            'jenis_tarif' : jenis_tarif,
            'jenis_tarif_id' : jenis_tarif_id
        }
        viewTarif(data);
    }



    function asuransiKeyup(control){
        var dibayar_asuransi = $(control).val();
        var BHP = 0;

        dibayar_asuransi = clean(dibayar_asuransi);

        if($('#txtBHP').val() == '0' || $('#txtBHP').val() == undefined || $('#txtBHP').val() == null ){
            BHP = 0;
        } else {
            BHP = $('#txtBHP').val();
        }

        if(dibayar_asuransi == ''){
            dibayar_asuransi = 0;
        }
        
        $('#dibayar_pasien').val(parseInt(totalBiaya) - parseInt(dibayar_asuransi));
        var dibayar_pasien_baru = $('#dibayar_pasien').val();
        if (dibayar_pasien_baru > 0) {
            $('#pembayaran_pasien').removeAttr('readonly');
        } else if ( dibayar_pasien_baru == 0  ){
            $('#pembayaran_pasien')
            .val(0)
            .attr('readonly', 'readonly');
            rupiahDibayarPasien('#pembayaran_pasien');
            $('#kembalian_pasien').val(0).attr('readonly', 'readonly');;
            rupiahDibayarPasien('#kembalian_pasien');
        } else {
            $('#pembayaran_pasien')
            .val(0)
            .attr('readonly', 'readonly');
        } 
        rupiahDibayarPasien(control);
        rupiahDibayarPasien('#dibayar_pasien');
        formatUangIni();

    }

    function pembayaranKeyup(control){
        var pembayaran = $(control).val();
        pembayaran = cleanUangIni(pembayaran);
        var dibayar_pasien = clean($('#dibayar_pasien').val());
        console.log('dibayar_pasien = ' + $('#dibayar_pasien').val());
        console.log('dibayar_pasien = ' + dibayar_pasien);
        console.log('pembayaran = ' + pembayaran);
        if(pembayaran == ''){
            pembayaran = 0;
        }
        $('#kembalian_pasien').val(parseInt(pembayaran) - parseInt(dibayar_pasien));
        rupiahDibayarPasien(control);
        rupiahDibayarPasien('#kembalian_pasien');
    }

    function dummyClick()
    {
        if($('#dibayar_asuransi').val() == ''){
            validasi('#dibayar_asuransi', 'harus diisi walau dengan 0');
        } else {
            $('input[type="submit"]').click();
        }
    }

    function updateTotal(data){
        var temp = '';
        var total = 0;

        total = totalHarga();

        totalBiaya = parseInt(total);

        temp = JSON.stringify(data);
        $('#txtTarif').val(temp);
        var bhp = $('#txtBHP').val();

        var dibayar_asuransi = parseInt($('#dibayar_asuransi').val());
        if(dibayar_asuransi == ''){
            dibayar_asuransi = 0;
        }
 
       $('.total').html(total);

        var dibayar_asuransi = $('#dibayar_asuransi').val();

        console.log('number dibayar asuransi = ' + dibayar_asuransi);
        console.log('number dibayar total = ' + total);
        if(dibayar_asuransi == ''){
            $('#dibayar_pasien').val(total);
        } else {
            $('#dibayar_pasien').val(parseInt(total) - parseInt(clean( dibayar_asuransi )));
        }
        console.log($('#dibayar_pasien').val());
        rupiahDibayarPasien('#dibayar_pasien');


        $('.total').each(function() {
            var number = $(this).html();
            console.log('number before = ' + number);
            number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
            number = 'Rp. ' + number;
            console.log('number after = ' + number);
            $(this).html(number);
        });
        formatUangIni();
         
    }

    function totalHarga(){
        var total = 0;
        for (var i = 0; i < data.length; i++) {
            total += parseInt(data[i].biaya);
        }
        return total;
    }

    function submitPage(){
        var submit = true;
        var dibayar_pasien = $('#dibayar_pasien').val();
        dibayar_pasien = cleanUang(dibayar_pasien);
        var pembayaran_pasien = $('#pembayaran_pasien').val();
        var pembayaran_pasien_clean = cleanUang(pembayaran_pasien);

        $('.tabelTerapi2 td').each(function(e) {
            if($(this).css('color') !='rgb(255, 0, 0)' ){
                submit = false;
                return false;
            }
        });
        if(submit){
            if($('#dibayar_asuransi').val() == ''){
                alert('Asuransi harus diisi walaupun dengan angka 0 ..');
                validasi('#dibayar_asuransi', 'harus diisi walau dengan 0');
            }else if(dibayar_pasien > 0 && pembayaran_pasien == '' ){
                alert('Pembayaran harus diisi walaupun dengan angka 0 ..');
                validasi('#pembayaran_pasien', 'harus diisi walau dengan 0');
            }else if( parseInt( dibayar_pasien ) > parseInt( pembayaran_pasien_clean ) ) {
                alert('Pembayaran Pasien tidak benar');
                validasi('#pembayaran_pasien', 'Pembayaran Pasien tidak benar');
            }else { 
                $('#print').click();
                $('.btn').attr('disabled','disabled');

            }
        } else {
           alert('Mohon Periksa / Cek ulang apakah obat yang akan diberikan sesuai dengan resep!');
        }
    }

    function inputTarif(control) {
      var bhp = $(control).val();
      bhp = clean(bhp);
      var i = $(control).closest('tr').find('button').val();

      if(bhp == ''){
            bhp = 0;
      }

      $('.total').html(parseInt(totalAwal)+parseInt(bhp));
      data[i].biaya = String(bhp);
      updateTotal(data);
    }

    function clean(num) {

        var num = num.replace(/\./g, "");
        num = num.substring(3);
        return num;

    }


    function asuransiKeyup2(control, choose){

        dibayar_asuransi = clean(control);

        if($('#txtBHP').val() == '0' || $('#txtBHP').val() == undefined || $('#txtBHP').val() == null ){
            BHP = 0;
        } else {
            BHP = $('#txtBHP').val();
        }

        if(dibayar_asuransi == ''){
            dibayar_asuransi = 0;
        }
        
        $('#dibayar_pasien').val(parseInt(totalBiaya) - parseInt(dibayar_asuransi));
        rupiahDibayarPasien(choose);
        formatUangIni();

    }

    function testPrint(){
        var dibayar_pasien = cleanUang($('#dibayar_pasien').val());
        var biaya = 0;
        if (dibayar_pasien != 0) {
            var json = $('#txtTarif').val();
            var MyArray = $.parseJSON(json);
            var temp = '';

            for (var i = 0; i < MyArray.length; i++) {
                temp += '<tr>';
                temp += '<td>' + MyArray[i].jenis_tarif + '</td>'
                temp += '<td>:</td>';
                temp += '<td class="uang text-right">' + MyArray[i].biaya + '</td>';
                temp += '</tr>';

                biaya += parseInt( MyArray[i].biaya );
            }

            var pembayaran = $('#pembayaran_pasien').val();
            var kembalian = $('#kembalian_pasien').val();
            var dibayar_asuransi = cleanUang( $('#dibayar_asuransi').val() );
            console.log('dibayar asuransi =   +++' + dibayar_asuransi);

            if(dibayar_asuransi > 0){
                $('#dibayarAsuransi-print').html(dibayar_asuransi);
            } else {
                $('#dibayarAsuransi-print').closest('tr').addClass('hide');
            }
            
            $('#transaksi-print').html(temp);
            $('#biaya-print').html(biaya);
            $('#pembayaran-print').html(pembayaran +  ',-');
            $('#kembalian-print').html(kembalian +  ',-');
            formatUangIni();
            $('#submitthis').click();

        } else {
            $('#transaksi-print').html('');
            $('#biaya-print').html('');
            $('#submitthis').click();
        }
    
    }
function formatUangIni(){
    $('.uang:not(:contains("Rp."))').each(function() {
        var number = $(this).html();
        number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
        $(this).html('Rp. ' + number);
    });
}

function cleanUangIni(uang){
    uang = uang.replace(/\./g,'');
    uang = uang.split(" ")[1];
    if (uang == 0) {
        uang = 0;
    }
    return uang;
}


</script>
@stop
