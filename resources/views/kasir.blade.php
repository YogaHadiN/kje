@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Kasir
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
    
<input type="hidden" id="asuransi_id" value="{{ $periksa->asuransi_id }}">
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
                                <td id='terapih'>{!! $periksa->terapi_html !!}
                                   @if (!empty($periksa->resepluar))
                                       <hr>
                                       <p>Resep ditebut di apotek di Luar :</p>
                                       {!! $periksa->resepluar !!}
                                   @endif
                                   
                                </td>
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-info">
                          <div class="panel-heading">
                                <h3 class="panel-title">Petunjuk : </h3>
                          </div>
                          <div class="panel-body">
                                Pada Halaman ini tugas Anda adalah menyesuaikan merek dengan asuransi / cara pembayaran, dan sesuai dengan plafon / maksimal pembayaran asuransi. <br /><strong>Khusus untuk Asuransi BPJS </strong>, pilih obat yang paling murah harganya..
                                <br />Sesuaikan juga jumlah dengan asuransi yang dimiliki. Merubah jumlah obat dalam bentuk puyer dan add sirup tidak diperbolehkan
                                <br />
                                Klik tombol <strong>Lihat Resep</strong> untuk melihat dan mencetak resep yang telah disesuaikan dengan pembayaran. <br />
                                Setelah obat disesuaikan dan status telah dicetak, klik tombol <strong>Stubmit</strong> langkah selanjutnya adalah halaman <strong> qualiy control dan survey </strong> sebelum pasien selesai.
                          </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-warning">
                      <div class="panel-heading">
                           <div class="panelLeft">
                                <h3>Edit Resep</h3>
                          </div>
                      </div>
                          <div class="panel-body">
							  <div class="table-responsive">
								<table class="table table-condensed table-hover" id="antrian_apotek">
									<thead>
										<tr>
											<th class="hide">key/th>
											<th>Merek Obat</th>
											<th>Signa</th>
											<th>Jumlah</th>
											<th>Satuan</th>
											<th>Biaya</th>
											<th class="hide">jumlah</th>
											<th class="hide">id</th>
										</tr>
									</thead>
									<tbody id="tblResep">
										@foreach ($terapis as $key => $terapi)
											<tr>
												<td class="hide key">{!! $key !!}</td>
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
													<input type="text" class="form-control angka" onkeyup="jumalhEdit(this);return false;" value="{!! $terapi->jumlah !!}">
												</td>
												<td class='uang harga_satuan'>
													@if($periksa->asuransi_id == '32')
														@if($terapi->merek->rak->fornas == '0')
															{!! App\Models\Classes\Yoga::kasirHargaJual($terapi, $periksa)!!}
														@else
															0     
														@endif      
													@else
														{!! App\Models\Classes\Yoga::kasirHargaJual($terapi, $periksa)!!}
													@endif
												</td>
												<td class='uang totalItem total_satuan'>
													@if($periksa->asuransi->tipe_asuransi == 5)
														@if($terapi->merek->rak->fornas == '0')
														{!! App\Models\Classes\Yoga::kasirHargaJualItem($terapi, $periksa)!!}
														@else
															0    
														@endif      
													@else
														{!! App\Models\Classes\Yoga::kasirHargaJualItem($terapi, $periksa)!!}
													@endif      
												</td>
												<td class="hide jumlah">{!! $terapi->jumlah !!}</td>
												<td class="hide terapi_id">{!! $terapi->id !!}</td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											@if($periksa->asuransi->tipe_asuransi == 4)
												@if($plafon < 0)
													<td class="red"> Plafon kurang <br> : {{ $plafon }}</td>
													<td class="text-right" colspan='4'><strong><h2>Total Biaya Obat : <span class="uang" id='biaya'>{!!$biayatotal !!}</span></h2></strong></td>
												@else
													  <td class="text-right" colspan='5'><strong><h2>Total Biaya Obat : <span class="uang" id='biaya'>{!!$biayatotal !!}</span></h2></strong></td>
												@endif
											@else 
												<td class="text-right" colspan='5'><strong><h2>Total Biaya Obat : <span class="uang" id='biaya'>{!!$biayatotal !!}</span></h2></strong></td>
											@endif
										</tr>
									</tfoot>
								</table>
							  </div>
                                @if (!empty($periksa->resepluar))
                                <hr>
                                <p>Resep ditebut di apotek di Luar :</p>
                                {!! $periksa->resepluar !!}
                                @endif
                          </div>
                    </div>
                   <div class="row">
                       <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						   {!! Form::textarea('terapi1', $periksa->terapii, ['class' => 'form-control hide', 'id' => 'terapi1']) !!}
                       </div>
                       <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                           {!! Form::textarea('terapi2', null, ['class' => 'form-control hide', 'id' => 'terapi2'])!!} 
                       </div>
                   </div>

				   @if( $periksa->asuransi_id == '32' && isset( $periksa->rujukan ) )
					   <div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<div class="panel-title">TACC</div>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group @if($errors->has('tacc'))has-error @endif">
											  {!! Form::label('tacc', 'Apakah Pilihan TACC keluar di rujukan Pcare?', ['class' => 'control-label']) !!}
											  {!! Form::select('tacc', [ 
												  null => ' - Pilih - ' , 
												  0    => 'Bukan Diagnosa TACC',
												  1    => 'Diagnosa adalah golongan TACC'
											  ],  $periksa->rujukan->tacc , ['class' => 'form-control', 'id' => 'tacc_muncul', 'onchange' => 'inputTaccChange();return false;']) !!}
											  @if($errors->has('tacc'))<code>{{ $errors->first('tacc') }}</code>@endif
											</div>
										</div>
									</div>
									<div class="row hide" id="inputTacc">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<h2>TACC</h2>
													<hr />
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('Time'))has-error @endif">
													  {!! Form::label('time_tacc', 'Time ( Alasan dari lama pennyakit yang mengharuskan pasien dirujuk )', ['class' => 'control-label']) !!}
													  {!! Form::textarea('time_tacc' , $periksa->rujukan->time, ['class' => 'form-control textareacustom', 'id' => 'time_tacc' ]) !!}
													  @if($errors->has('time_tacc'))<code>{{ $errors->first('Time') }}</code>@endif
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('Age'))has-error @endif">
													{!! Form::label('age_tacc', 'Age ( Alasan dari usia pasien yang mengharuskan pasien dirujuk )', ['class' => 'control-label' ]) !!}
													  {!! Form::textarea('age_tacc' , $periksa->rujukan->age, ['class' => 'form-control textareacustom', 'id' => 'age_tacc']) !!}
													  @if($errors->has('age_tacc'))<code>{{ $errors->first('Age') }}</code>@endif
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('complication_tacc'))has-error @endif">
													  {!! Form::label('complication_tacc', 'Complication ( Alasan dari faktor pemberat atau komplikasi yang mengharuskan pasien dirujuk )', ['class' => 'control-label']) !!}
													  {!! Form::textarea('complication_tacc' , $periksa->rujukan->complication, ['class' => 'form-control textareacustom', 'id' => 'complication_tacc' ]) !!}
													  @if($errors->has('complication_tacc'))<code>{{ $errors->first('compolication_tacc') }}</code>@endif
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('comorbidity_tacc'))has-error @endif">
													  {!! Form::label('comorbidity_tacc', 'Comorbidity ( Alasan dari Penyakit Penyerta yang mengharuskan pasien dirujuk )', ['class' => 'control-label']) !!}
													  {!! Form::textarea('comorbidity_tacc' , $periksa->rujukan->comorbidity, ['class' => 'form-control textareacustom', 'id' => 'comorbidity_tacc' ]) !!}
													  @if($errors->has('comorbidity_tacc'))<code>{{ $errors->first('comorbidity_tacc') }}</code>@endif
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					   </div>
				   @endif
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <button class="btn btn-success btn-block btn-lg" type="button" onclick="dummyClick();return false;">Submit</button>
                            {!! Form::submit('Submit', ['class' => 'btn btn-success btn-block btn-lg hide'])!!}
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                            <a href="{!! url('antriankasirs') !!}"  class="btn btn-danger btn-block btn-lg">Cancel</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @include('fotoPasien', ['pasien' => $periksa->pasien])
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close()!!}
@include('obat')
@stop
@section('footer') 
<script>
  var base = "{!! url('/') !!}";
</script>
<script src="{!! url('js/fotozoom.js') !!}" type="text/javascript"></script>
{!! HTML::script('js/informasi_obat.js')!!} 
<script>
    var totalBiaya = 0;
    var totalAwal = 0;

    $(document).ready(function() {
		inputTaccChange();
        $('.jumlah').keyup(function(e) {
            var awal = $(this).closest('tr').find('td:nth-child(7)').html();
            var id = $(this).closest('tr').find('td:last-child').html();

            console.log('awal = ' + awal);
            console.log('id = ' + id);

            if (parseInt($(this).val()) > awal) {
                $(this).val(awal)
            } else if($(this).val() < 0){
                $(this).val('0');
            }

            var n = $(this).val();
            updateJumlah(id,n,this);

        });
    });

    function ddlOnChange(control) {
        var jumlah = $(control).closest('tr').find('input').val();
        var js = $(control).val();
        var MyArray = JSON.parse(js);
        var merek_id = MyArray.merek_id;
        var rak_id = MyArray.rak_id;
        var asuransi_id = $('#asuransi_id').val();
        var formula_id = MyArray.formula_id;
        var harga_jual = MyArray.harga_jual;
        var harga_beli = MyArray.harga_beli;
        var fornas = MyArray.fornas;
        var id = $(control).closest('tr').find(".terapi_id").html();
        var i = $(control).closest('tr').find('.key').html();
		var data = parseTerapi();


        console.log(jumlah);
        console.log(js);
        console.log(MyArray);
        console.log(merek_id);
        console.log(rak_id);
        console.log(asuransi_id);
        console.log(formula_id);
        console.log(harga_jual);
        console.log(harga_beli);
        console.log(fornas);
        console.log(id);
        console.log(i);
		console.log(data);

		data[i].merek_id = merek_id;
		data[i].harga_beli_satuan = harga_beli;
		data[i].harga_jual_satuan = harga_jual * {{ $periksa->asuransi->kali_obat }};
		encodeTerapi(data,harga_jual,control,jumlah);
		console.log('ddlOnChange');
    }

    function tambah(control){
        var id = $(control).closest('tr').find("td:last-child").html();
        var awal = $(control).closest('tr').find('td:nth-child(7)').html();
        var n = $(control).closest('.spinner').find('label').html();
        if (n != awal) {
            n++;
            updateJumlah(id,n,control);
        } 
    }
    function kurang(control){
        var id = $(control).closest('tr').find("td:last-child").html();
        var n = $(control).closest('.spinner').find('label').html();
        if(n != 0){
            n--;
            updateJumlah(id,n,control);
        }
    }

    function updateJumlah(id,n,control){
        $.post('/kasir/updatejumlah', {'id': id, 'jumlah' : n }, function(data, textStatus, xhr) {
            updateTerapi(data);
            var harga = $(control).closest('tr').find('td:nth-child(5)').html();
            harga = Number(harga.replace(/[^0-9]+/g,""))
            $(control).closest('tr').find('.total_satuan').html(parseInt(n) * parseInt(harga));
            hitungTotal();
            rupiah();
        });
    }

    function updateTerapi(data){
        data = $.parseJSON(data);
        if (data.confirm == '1') {
            var terapi = data.terapi;
            $('#terapih').html(terapi);
            $('#terapi2').val(JSON.stringify( data.terapiJson )); 
        }
    }

    function rupiah(){
        $('.uang:not(:contains("Rp"))').each(function() {
            var number = $(this).html();
            number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
            $(this).html('Rp. ' + number + ',-');
        });
    }

    function dummyClick(){
		if( $('#inputTacc').length > 0 && ( $('#tacc_muncul').val() == '' || $('#tacc_muncul').val() ==  null ) ){
			alert('Apakah pilihan Tacc keluar pada rujukan? Mohon diisi dengan benar');
			validasi('#tacc_muncul', 'Harus diisi!');

		} else if( $('#inputTacc').length > 0 && $('#tacc_muncul').val() == '1' && ( 
			( $('#time_tacc').val() == '' || $('#time_tacc').val() == null   ) &&
			( $('#age_tacc').val() == '' || $('#age_tacc').val() == null   ) &&
			( $('#complication_tacc').val() == '' || $('#complication_tacc').val() == null   ) &&
			( $('#comorbidity_tacc').val() == '' || $('#comorbidity_tacc').val() == null   )
						
		) ){
			validateWarning( '#time_tacc' );
			validateWarning( '#age_tacc' );
			validateWarning( '#complication_tacc' );
			validateWarning( '#comorbidity_tacc' );
		} else {
			$('input[type="submit"]').click();
		}
    }

    function hitungTotal(){
        var total = 0;
        $('.totalItem').each(function(index, el) {
            var string = $(this).html();
            string = parseInt(Number(string.replace(/[^0-9]+/g,"")));
            total += parseInt(string);
        });
		@if($periksa->poli != 'estetika')
			$('#biaya').html(rataAtas5000(total));
		@else
			$('#biaya').html(total);
		@endif
    }

	function inputTaccChange(){
		if( $('#tacc_muncul').val() == '' || $('#tacc_muncul').val() == null || $('#tacc_muncul').val() ==  '0' ){
			$('#inputTacc').removeClass('hide');
			$('#inputTacc').slideUp('500');
			$('#tacc_muncul').closest('.panel').find('textarea').val('');

		} else {
			$('#inputTacc').removeClass('hide');
			$('#inputTacc').hide();
			$('#inputTacc').slideDown('500');
		}
		 
	}
	function validateWarning(selector){
		if( $(selector).val() == '' || $(selector).val() == null   ){
			validasi(selector, 'Harus Diisi');
		}
	}
	function parseTerapi(){
		var temp = $('#terapi1').val();
		return $.parseJSON(temp);
	}
	function encodeTerapi(temp, harga_jual, control, jumlah){
		var temp = JSON.stringify(temp);
		$('#terapi1').val(temp);
		$('#terapi2').val(temp);
		if ({!! $periksa->asuransi_id !!} == '32') {
			if (fornas == 0) {
				$(control).closest('tr').find('.harga_satuan').html(harga_jual *{!! $periksa->asuransi->kali_obat  !!});
			} else {
				$(control).closest('tr').find('.harga_satuan').html('0');
			}
		} else {
			$(control).closest('tr').find('.harga_satuan').html(harga_jual *{!! $periksa->asuransi->kali_obat  !!});
			$(control).closest('tr').find('.total_satuan').html(harga_jual *{!! $periksa->asuransi->kali_obat  !!} * jumlah);
		}
		hitungTotal();
		rupiah();
	}

	function jumalhEdit(control){
		var i = $(control).closest('tr').find('.key').html();
		var harga_jual = hargaJual(control);
		var awal = $(control).closest('tr').find('.jumlah').html();
		var id = $(control).closest('tr').find('.terapi_id').html();

		if (parseInt($(control).val()) > awal) {
			var jumlah = awal;
		} else if($(control).val() < 0){
			var jumlah = 0;
		} else {
			var jumlah = $(control).val();
		}
		$(control).val(jumlah);
		
		var data = parseTerapi();
		data[i].jumlah = jumlah;
		encodeTerapi(data, harga_jual, control, jumlah);
	}
	function hargaJual(control){
		var MyArray = $(control).closest('tr').find('select').val();
		MyArray = $.parseJSON(MyArray);
		return MyArray.harga_jual;
	}
	
	
</script>


@stop
