@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Kasir
@stop
@section('page-title') 
 <h2>Kasir</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Kasir</strong>
      </li>
</ol>
@stop
@section('content') 
<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">

            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Pemeriksaan <strong>{!!$pasien->id!!} - {!!$pasien->nama!!}</strong> Saat Ini</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        @if($pasien->periksa->count() == 0)
                            <p class="text-center">Tidak ada Riwayat untuk ditampilkan / Pasien adalah pasien baru</p>
                        @else
							<div class="table-responsive">
								<table class="table table-condensed">
									<thead>
										<tr>
											<th>Tanggal</th>
											<th>Status</th>
											<th>Terapi</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												{!! $periksa->tanggal !!} <br><br>
												<strong>Pemeriksa :</strong><br>
												{!! $periksa->staf->nama !!} <br>
												<strong>ID Periksa : </strong>
												<span id="periksa_id">{!!$periksa->id!!}</span><br>
												<strong>Pembayaran : </strong>
												<span id="periksa_id">{!!$periksa->asuransi->nama !!}</span>
											</td>
											<td>
												<strong>Anamnesa :</strong> <br>
												{!! $periksa->anamnesa !!} <br>
												<strong>Pemeriksaan Fisik, Penunjang dan Tindakan :</strong> <br>
												{!! $periksa->pemeriksaan_fisik !!} <br>
												{!! $periksa->pemeriksaan_penunjang !!}<br>
												<strong>Diagnosa :</strong> <br>
												{!! $periksa->diagnosa->diagnosa !!} - {!! $periksa->diagnosa->icd10->diagnosaICD !!}
											</td>
											<td>{!! $periksa->terapi_html !!}</td>
										</tr>
									</tbody>
								</table>
							</div>
                        @endif

                    </div>
                </div>
            </div>
            </div>
            {!! Form::open(['url' => 'kasir/submit', 'method' => 'post', 'autocomplete' => 'off'])!!}
                {!! Form::text('periksa_id', $periksa->id, ['class' => 'hide'])!!}

            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-warning">
                      <div class="panel-heading">
                           <div class="panelLeft">
                                <h3>Edit Resep</h3>
                          </div>
                           <div class="panelRight">
                                <a href="{!! url('pdfs/status/' . $periksa->id ) !!}" class="btn btn-success" target="_blank" >Lihat Resep</a>
                          </div>
                      </div>
                          <div class="panel-body">
							  <div class="table-responsive">
								<table class="table table-condensed table-hover">
									<thead>
										<tr>
											<th class="hide">key/th>
											<th>Merek Obat</th>
											<th>Signa</th>
											<th>Jumlah</th>
											<th>Satuan</th>
											<th>Biaya</th>
											<th class="hide">id</th>
										</tr>
									</thead>
									<tbody id="tblResep">
										@foreach ($terapis as $key => $terapi)
											<tr>
												<td class="hide">{!! $key !!}</td>
												<td>
													<select name="" id="ddlMerekChange" class="form-control" onchange="ddlOnChange(this);return false;">
														@foreach ($terapi->merek->rak->formula->merek_banyak as $ky => $mrk_id)
															@if ($mrk_id == $terapi['merek_id'])
																<option value='{!! $mereks->find($mrk_id)->merek_jual !!}' selected>{!!$mereks->find($mrk_id)->merek !!}</option>
															@else
																<option value='{!! $mereks->find($mrk_id)->merek_jual !!}'>{!!$mereks->find($mrk_id)->merek !!}</option>
															@endif
														@endforeach
													</select>
												</td>
												<td>
												   {!! $terapi->signa !!} 
												</td>
												<td>
													<div class="input-group spinner"><label class="form-control">{!! $terapi->jumlah !!}</label><div class="input-group-btn-vertical"><button class="btn btn-white" onclick="tambah(this);" type="button"><i class="fa fa-caret-up"></i></button><button class="btn btn-white" onclick="kurang(this);" type="button"><i class="fa fa-caret-down"></i></button></div></div>
												</td>
												<td class='uang'>
													@if($periksa->asuransi->tipe_asuransi_id == 5)
														@if($terapi->merek->rak->fornas == '0')
															{!! App\Models\Classes\Yoga::kasirHargaJual($terapi, $periksa)!!}
														@else
															0     
														@endif      
													@else
														{!! App\Models\Classes\Yoga::kasirHargaJual($terapi, $periksa)!!}
													@endif
												</td>
												<td class='uang'>
													@if($periksa->asuransi->tipe_asuransi_id == 5)
														@if($terapi->merek->rak->fornas == '0')
														{!! App\Models\Classes\Yoga::kasirHargaJualItem($terapi->merek->rak->harga_jual, $periksa)!!}
														@else
															0    
														@endif      
													@else
														{!! App\Models\Classes\Yoga::kasirHargaJualItem($terapi->merek->rak->harga_jual, $periksa)!!}
													@endif      
												</td>
												<td class="hide">{!! $terapi->id !!}</td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<td class="text-right" colspan='5'><strong><h2>Total Biaya Obat : <span class="uang" id='biaya'>{!!$biayatotal !!}</span></h2></strong></td>
										</tr>
									</tfoot>
								</table>
							  </div>
                            {!! Form::textarea('resep', $resepjson, ['class' => 'form-control', 'id' => 'txtTerapiTemp'])!!}
                          </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <button type="button" class="btn btn-success btn-block btn-lg" id="dummySubmit" onclick="dummyClick()">Submit</button>
                            {!! Form::submit('Submit', ['class' => 'btn btn-success btn-block btn-lg displayNone'])!!}
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                            <a href="{!! url('antriankasirs') !!}"  class="btn btn-danger btn-block btn-lg">Cancel</a>
                        </div>
                    </div>
                </div>
            <div class="col-lg-4">

                <div class="panel panel-info">
                      <div class="panel-heading">
                            <h3 class="panel-title">Petunjuk : </h3>
                      </div>
                      <div class="panel-body">
                            Pada Halaman ini tugas Anda adalah menyesuaikan merek dengan asuransi / cara pembayaran, dan sesuai dengan plafon / maksimal pembayaran asuransi. <br><br><strong>Khusus untuk Asuransi BPJS </strong>, pilih obat yang paling murah harganya..
                            <br><br>Sesuaikan juga jumlah dengan asuransi yang dimiliki. Merubah jumlah obat dalam bentuk puyer dan add sirup tidak diperbolehkan
                            <br><br>
                            Klik tombol <strong>Lihat Resep</strong> untuk melihat dan mencetak resep yang telah disesuaikan dengan pembayaran. <br><br>
                            Setelah obat disesuaikan dan status telah dicetak, klik tombol <strong>Stubmit</strong> langkah selanjutnya adalah halaman <strong> qualiy control dan survey </strong> sebelum pasien selesai.
                      </div>
                </div>


                <div class="panel panel-info hide">
                      <div class="panel-heading">
                            <h3 class="panel-title">Tarif</h3>
                      </div>
                      <div class="panel-body">
						  <div class="table-responsive">
							<table class="table table-condensed table-hover">
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
										<td><label for="" class="form-control" id="txtTotal"></label></td>
									</tr>
									<tr>
										<td>Dibayar Asuransi</td>
										<td><input type="text" class="form-control" id="dibayar_asuransi" name="dibayar_asuransi" onkeyup="asuransiKeyup(this)" value="0"></td>
									</tr>
									<tr>
										<td>Dibayar Pasien</td>
										<td><input class="form-control" id="dibayar_pasien" name="dibayar_pasien" disable>
									</tr>
								</tfoot>
							</table>
						  </div>
                        {!! Form::textarea('tarif', $transaksi, ['class' => 'displayNone', 'id' => 'txtTarif'])!!}
                      </div>
                </div>

            </div>
            </div>
            {!! Form::close()!!}
@if($periksa->asuransi->tipe_asuransi_id == '5')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @if($sudah)
          <div class="alert alert-danger">
            Pasien sudah pernah Periksa Gula Darah Bulan ini, <strong>jatah periksa Gula Darah BPJS sudah habis</strong>, lihat <a href="{!! url('periksas/' . $periksa->pasien_id) !!}" target="_blank">Riwayat Pemeriksaan</a> untuk memastikan
          </div>
        @else
          <div class="alert alert-success">
             Pasien belum periksa gula darah bulan ini, <strong>bisa periksa Gula Darah BPJS</strong> dengan syarat usia diatas 60 tahun ATAU memiliki riwayat Kencing Manis, lihat <a href="{!! url('periksas/' . $periksa->pasien_id) !!}" target="_blank">Riwayat Pemeriksaan</a> untuk memastikan, pemeriksaan ini tidak ada tambahan jasa untuk dokter
          </div>
        @endif
        </div>
    </div>
@endif
@include('obat')
@stop
@section('footer') 
<script>
  var base = "{!! url('/') !!}";
</script>
{!! HTML::script('js/informasi_obat.js')!!} 
<script>
    var totalBiaya = 0;
    var totalAwal = 0;

    var data = $('#txtTarif').val();
    data = JSON.parse(data);

    var dataResep = $('#txtTerapiTemp').val();
    dataResep = JSON.parse(dataResep);

    var dataAwal = $('#txtTerapiTemp').val();
    dataAwal = JSON.parse(dataAwal);

    $(document).ready(function() {
        viewTarif(data);
        totalAwal = totalHarga();
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
            temp += '<td><input class="form-control" dir="rtl" value="' +  + data[i].biaya + '" id="txt' + data[i].jenis_tarif.replace(" ", "") + '" /></td>';
            if(data[i].jenis_tarif == 'Biaya Obat'){
                temp += '<td><button type="button" class="btn btn-danger btn-sm" disabled="disabled" value="' + i + '" onclick="rowDel(this)">hapus</button></td>';
                temp += '<tr>';
            }else{
                temp += '<td><button type="button" class="btn btn-danger btn-sm" value="' + i + '" onclick="rowDel(this)">hapus</button></td>';
                temp += '<tr>';
            }
        }

        total = totalHarga();

        $('#tarif').html(temp);
        temp = JSON.stringify(data);
        $('#txtTarif').val(temp);

        var dibayar_asuransi = parseInt($('#dibayar_asuransi').val());
        if(dibayar_asuransi == ''){
            dibayar_asuransi = 0;
        }

        totalBiaya = parseInt(total);
 
       $('#txtTotal').html(totalBiaya);
        var dibayar_asuransi = $('#dibayar_asuransi').val();

        if(dibayar_asuransi == ''){
            $('#dibayar_pasien').val(totalBiaya);
        } else {
            $('#dibayar_pasien').val(parseInt(totalBiaya) - parseInt(dibayar_asuransi));
        }

        $('#dibayar_asuransi').focus();

        $('#txtBHP').keyup(function(event) {
            var bhp = $(this).val();

            if(bhp == ''){
                bhp = 0;
            }
            
            $('#txtTotal').html(parseInt(totalAwal)+parseInt(bhp));

            data[data.length -1].biaya = String(bhp);

            updateTotal(data);

        });

    }

    function ddlOnChange(control) {
        
        var js = $(control).val();
        // alert(js);
        var MyArray = JSON.parse(js);
        var merek_id = MyArray.merek_id;
        var rak_id = MyArray.rak_id;
        var formula_id = MyArray.formula_id;
        var harga_jual = MyArray.harga_jual;
        var id = $(control).closest('tr').find("td:last-child").html();
        var i = $(control).closest('tr').find('td:first-child').html();
        var param = {
            'merek_id' : merek_id,
            'id' : id
        };

        $.post(base + '/kasir/changemerek', param, function(data, textStatus, xhr) {
            data = $.trim(data);
            if (data == '1') {
                var merek = $(control).find('option:selected').text();
                dataResep[i].merek_id = String(merek_id);
                dataResep[i].rak_id = String(rak_id);
                dataResep[i].formula_id = String(formula_id);
                dataResep[i].merek_obat = merek;
                dataResep[i].harga_jual = harga_jual;
                $(control).closest('tr').find('td:nth-child(5)').html(harga_jual *{!! $periksa->asuransi->kali_obat  !!});
                $(control).closest('tr').find('td:nth-child(6)').html(harga_jual * dataResep[i].jumlah);

                var string = JSON.stringify(dataResep);

                $('#txtTerapiTemp').html(string);

                viewBiaya(i, control);

                updateTerapi();
            }
        });




    }

    function viewResepJson(dataResep, js){

        var MyArray = JSON.parse(js);
        var merek_id = MyArray.merek_id;
        var harga_jual = MyArray.harga_jual;

        var temp = '';

        $('selectpick').selectpicker('refresh');

        $('#tblResep').html(temp);
        $('#txtTerapiTemp').html(dataResep);


    }

    function tambah(control){
        var i = $(control).closest('tr').find('td:first-child').html();
        var n = $(control).closest('.spinner').find('label').html();

        if (n != dataAwal[i].jumlah) {
            n++;
            $(control).closest('.spinner').find('label').html(n);

            dataResep[i].jumlah = String(n);

            var string = JSON.stringify(dataResep);

            $('#txtTerapiTemp').html(string);

            viewBiaya(i, control);

        } else {
            $('#dibayar_asuransi').focus();
        }
        updateTerapi();

        
    }

    function kurang(control){

        var i = $(control).closest('tr').find('td:first-child').html();
        var n = $(control).closest('.spinner').find('label').html();


        if(n != 0){
            n--;
            $(control).closest('.spinner').find('label').html(n);

            dataResep[i].jumlah = String(n);

            var string = JSON.stringify(dataResep);

            $('#txtTerapiTemp').html(string);

            viewBiaya(i, control);
        } else {
            $('#dibayar_asuransi').focus();
        }
        updateTerapi();
    }

    function viewBiaya(i, control){
        var biayaItem
        if (dataResep[i].merek_id > 0) {
             biayaItem = dataResep[i].jumlah * dataResep[i].harga_jual * {!! $periksa->asuransi->kali_obat!!};
        } else {
             biayaItem = dataResep[i].jumlah * dataResep[i].harga_jual;
        }

        $(control).closest('tr').find('td:nth-child(6)').html(biayaItem);

        var biaya = totalHargaObat();

        $('#txtBiayaObat').val(biaya);
        $('#biaya').html(biaya);

        var jsonIndex = $('#txtBiayaObat').closest('tr').find('button').val();
        data[jsonIndex].biaya = biaya;
        viewTarif(data);

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

        data[data.length] = {
            'biaya' : biaya,
            'periksa_id' : String(periksa_id),
            'tarif_id' : String(tarif_id),
            'keterangan' : keterangan,
            'jenis_tarif' : jenis_tarif
        }
        viewTarif(data);
    }



    function asuransiKeyup(control){
        var dibayar_asuransi = $(control).val();
        var BHP = 0;

        if($('#txtBHP').val() == '0' || $('#txtBHP').val() == undefined || $('#txtBHP').val() == null ){
            BHP = 0;
        } else {
            BHP = $('#txtBHP').val();
        }

        if(dibayar_asuransi == ''){
            dibayar_asuransi = 0;
        }

        console.log('totalBiaya = ' + totalBiaya);
        console.log('dibayar_asuransi = ' + dibayar_asuransi);
        
        $('#dibayar_pasien').val(parseInt(totalBiaya) - parseInt(dibayar_asuransi));


    }

    function dummyClick()
    {
        if($('#dibayar_asuransi').val() == ''){
            validasi('#dibayar_asuransi', 'harus diisi walau dengan 0');
        } else {
            window.open("{!! url('pdfs/status/' . $periksa->id ) !!}");
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
 
       $('#txtTotal').html(total);
        var dibayar_asuransi = $('#dibayar_asuransi').val();

        if(dibayar_asuransi == ''){
            $('#dibayar_pasien').val(total);
        } else {
            $('#dibayar_pasien').val(parseInt(total) - parseInt(dibayar_asuransi));
        }
    }

    function totalHarga(){
        var total = 0;
        for (var i = 0; i < data.length; i++) {
            total += parseInt(data[i].biaya);
        }
        return total;
    }

    function totalHargaObat(){
        var biaya = 0;
        for (var i = 0; i < dataResep.length; i++) {
            if (dataResep[i].merek_id > 0) {
                biaya += dataResep[i].jumlah * dataResep[i].harga_jual * {!! $periksa->asuransi->kali_obat   !!};
            } else {
                biaya += dataResep[i].jumlah * dataResep[i].harga_jual;
            }
        }
        console.log('sebelum digenapkan = ' + biaya);
        var i = 0;
        var selisih = 0;
        do{
            i = i + 5000;
            selisih = i - biaya;
        }
        while(selisih <= 0)

        return i;
    }

    function updateTerapi(){

        var string = $('#txtTerapiTemp').html();
        $.post('{!! url("kasir/onchange") !!}', {'terapi': string, 'periksa_id' : "{!! $periksa->id !!}"}, function(data) {
            data = $.trim(data);
            if (data == '1') {
                console.log('Update berhasil');
            };
        });

        $('.uang:not(:contains("Rp"))').each(function() {
            var number = $(this).html();
            number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
            $(this).html('Rp. ' + number + ',-');
        });
    }


</script>

@stop
