@extends('layout.master')

@section('title') 
Klinik Jati Elok | Nurse Station

@stop
@section('head')
    <style>

    </style>
@stop
@section('page-title') 
<h2>Nurse Station</h2>
  <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Nurse Station</strong>
      </li>
  </ol>
@stop
@section('content') 
<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $antrianpolis->count() !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover" id="tableAsuransi">
                  <thead>
                    <tr>
						<th>id</th>
                    	<th>Antrian</th>
						<th>Asuransi</th>
						<th>Pasien</th>
						<th>Jam</th>
						<th>Tanggal</th>
						<th class="displayNone">poli</th>
						<th class="displayNone">pasien_id</th>
						<th class="displayNone">staf_id</th>
                        <th class="displayNone">asuransi_id</th>
						<th class="hide">image_url</th>
						<th class="">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($antrianpolis) > 0)
                    	@foreach ($antrianpolis as $antrianpoli)
                		<tr>
    						<td>{!! $antrianpoli->id !!}</td>
    	                   	<td>{!! $antrianpoli->antrian!!}</td>
							<td>{!! $antrianpoli->asuransi->nama !!}</td>
    						<td>{!! $antrianpoli->pasien->nama!!}</td>
    						<td>{!! $antrianpoli->jam!!}</td>
    						<td>{!! $antrianpoli->tanggal!!}</td>
    						<td class="displayNone">{!! $antrianpoli->poli !!}</td>
    						<td class="displayNone">{!! $antrianpoli->pasien_id !!}</td>
    						<td class="displayNone">{!! $antrianpoli->staf_id !!}</td>
                            <td class="displayNone">{!! $antrianpoli->asuransi_id !!}</td>
    						<td class="hide">{!! $antrianpoli->pasien->image !!}?{{ time() }}</td>
    	                	<td>
        						{!! Form::open(['url' => 'antrianpolis/' . $antrianpoli->id, 'method' => 'delete'])!!}
        							<a href=\"#\" class="btn btn-primary btn-xs" onclick="rowEntry(this);return false;" data-toggle="modal" data-target="#exampleModal">Proses</a>
                                    {!! Form::hidden('alasan', null, ['class' => 'alasan', 'id' => 'alasan_hapus' . $antrianpoli->id])!!}
                                    {!! Form::hidden('pasien_id', $antrianpoli->pasien_id, ['class' => 'form-control'])!!}
                                    <button type="button" class="btn btn-danger btn-xs" onclick="alas(this);return false;">Delete</button>
        							{!! Form::submit('Delete', [
                                    'class' => 'btn btn-danger btn-xs hide submit', 
                                    'onclick' => 'return confirm("Anda yakin ingin menghapus pasien ' . $antrianpoli->id . ' - ' . $antrianpoli->pasien->nama . '")', 
									'id' => 'submitDelete' . $antrianpoli->id
                                    ]) !!}
        						{!! Form::close() !!}
    	                	</td>
                            <td class="hide">



                                {!! App\Classes\Yoga::datediff($antrianpoli->pasien->tanggal_lahir, date('Y-m-d')) !!}
                            </td>
                    	</tr>
                    	@endforeach
                    @else 
                    <tr>
                        <td class="displayNone"></td>
                        <td colspan="6" class="text-center">Tidak ada data untuk ditampilkan :p</td>
                        <td class="displayNone" colspan="5"></td>
                    </tr>
                    @endif
                </tbody>
            </table>
      </div>
</div>
@include('antrianpolis.modalalasan')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Masukkan ke antrian</h4>
                </div>
                <div class="modal-body">
                    <form action="antrianperiksas" method="post">
                        <input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="namaPasien" id="lblNamaPasien" >Nama Pasien</label>
                                            <input type="text" class="form-control" id="namaPasien1" name="namaPasien">
                                            <input type="text" class="displayNone" name="pasien_id" id="ID_PASIEN">
                                            <input type="text" class="displayNone" name="tanggal" id="tanggal">
                                            <input type="text" class="displayNone" name="antrian_id" id="ID_ANTRIAN_POLI">
                                            <input type="text" class="displayNone" name="antrian" id="antrian">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 hide">
                                        <div class="form-group">
                                            <label for="jamDatang" id="lblJamDatang">Jam Datang</label>
                                            <label class="form-control" id="jamDatang1"></Label>
                                            <input type="text" class="displayNone" id="jamDatang"  name="jam"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="pembayaran" id="lblPembayaran">Pembayaran</label>
                                              {!!Form::select('asuransi_id', $asu, null, ['class' => 'form-control rq', 'id' => 'pembayaran1']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="dokter" id="lblDokter">Dokter</label><br />
                                            {!! Form::select('staf_id', $staf, null, ['id' => 'ddlDokter', 'class' => 'form-control rq']) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="poli" id="lblPoli">Poli</label><br />
        
                                            {!! Form::select('poli', App\Classes\Yoga::poliList(), null, ['id' => 'poli1', 'class' => 'form-control rq'])  !!}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="tekananDarah" id="lblTekananDarah">Tekanan Darah</label><br />
                                                <div class="input-group">
                                                    <input type="text" class="form-control " dir="rtl"  id="tekananDarah" placeholder="" name="tekanan_darah" aria-describedby="addonTekananDarah"/>
                                                    <span class="input-group-addon" id="addonTekananDarah">mmHg</span>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="namaPIC" id="lblBeratBadan">BeratBadan</label><br />
                                             <div class="input-group">
                                                <input type="text" class="form-control " dir="rtl" id="beratBadan" placeholder="" name="berat_badan" aria-describedby="addonBeratBadan"/>
                                                <span class="input-group-addon" id="addonBeratBadan">kg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="suhu" id="lblSuhu">Suhu</label><br />
                                             <div class="input-group">
                                                <input type="text" class="form-control " id="suhuTubuh" dir="rtl" placeholder="" name="suhu" aria-describedby="addonSuhuTubuh" />
                                                <span class="input-group-addon" id="addonSuhuTubuh">&#176;C</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="tinggiBadan" id="lblTinggiBadan">Tinggi Badan</label><br />
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="tinggiBadan" dir="rtl" placeholder="" name="tinggi_badan" aria-describedby="addonTinggiBadan" />
                                                <span class="input-group-addon" id="addonTinggiBadan">cm</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="kecelakaanKerja" id="lblKecelakaanKerja">Kecelakaan Kerja</label><br />
                                            <select class="form-control rq" id="kecelakaanKerja"  name="kecelakaan_kerja" >
                                                <option value="">-pilih-</option>
                                                <option value="1">-Ya-</option>
                                                <option value="0">-Bukan-</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="asisten" id="lblAsisten">Nama Asisten</label><br />
                                            {!! Form::select('asisten_id', $staf, null, ['class' => 'form-control selectpick rq', 'id' => 'asisten_id', 'data-live-search' => 'true']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="hamil" id="lblhamil">Kehamilan</label>
                                            {!! Form::select('hamil', App\Classes\Yoga::hamil(), null, ['class' => 'form-control rq:', 'id' => 'hamil']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row hide divAnc">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        @include('antrianpolis.gpa', [
                                            'g' => null,
                                            'p' => null,
                                            'a' => null
                                        ])
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label for="hpht" id="lblhamil">HPHT</label>
                                        {!! Form::text('hpht',  null, ['class' => 'form-control inputObs', 'id' => 'hpht']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 divAnc">
                                        <label for="hpht" id="lblhamil">Umur Kehamilan</label>
                                        {!! Form::text('umur_kehamilan',  null, ['class' => 'form-control inputObs', 'id' => 'umur_kehamilan']) !!}
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 hide" id="divUsg">
                                        <div class="form-group">
                                            {!! Form::label('perujuk') !!}
                                            {!! Form::select('perujuk_id', $perujuks_list, null, ['class' => 'form-control selectpick', 'id' => 'perujuk_id']) !!}
                                            <a class="" data-toggle="modal" href='#buat_perujuk'>Perujuk Belum Dibuat</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="pastikan">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div colspan="2" class="text-center"><h2 class="text-red">Pastikan Orang Yang Sama !</h2></div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                                <div colspan="2" class="text-center"><img src="" alt="" id="photo" width="400px" height="300px"></div>
                                            <div class="alert alert-info">
                                                 <h3 class="nama"></h3>
                                                <h3 id="usia"></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                           @include('peringatanbpjs', ['ns' => true])
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="buat_perujuk">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Buat Perujuk Baru</h4>
                                            </div>
                                            <div class="modal-body">
                                                @include('perujuks.form', ['submit' => 'Submit'])
                                            </div>
                                            <div class="modal-footer hide">
                                                <button type="button" class="btn btn-default">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <br>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <button type="button" class="btn btn-primary btn-block" id="dummySubmitButton" onclick="testSubmit();return false;">Submit</button>
                                        <input type="submit" name="submit" id="LinkButton1" class="btn btn-primary btn-block hide" value="Submit" />
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <a href="#" class="btn btn-danger block" onclick="$('#exampleModal').modal('hide');">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </form>
            </div>
        </div>

		<div class="modal fade" tabindex="-1" role="dialog" id="alert_prolanis">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Pastikan Nomor Telepon Benar</h4>
			  </div>
			  <div class="modal-body">
				  <h3>Pasien Adalah Golongan Program Lanjut Usia BPJS</h3>
				  <p>Mohon Pastikan kembali no telpon pasien yang bisa dihubungi</p>
				  <p>Saat ini yang terdaftar adalah :</p>
				  <h2 id="no_telp_pasien"></h2>
				  <p>Jika Nomor Telepon tersebut tidak benar / salah harap ganti dengan </p>
				  <p class='text-red'>Sebisa mungkin nomor telepon handphone yang bisa di SMS, bila format tidak benar misalnya kurang anka nol di depan, tolong dilengkapi dahulu</p>
			  </div>
			  <div class="modal-footer">
				  <div class="row">
				  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<a href="" id="redirect_update_pasien" class="btn btn-primary btn-block">Ganti Nomor Telepon Pasien</a>
				  	</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<button type="button" class="btn btn-danger btn-block" onclick="closeModal();">Nomor Telepon Pasien Sudah Benar</button>
					</div>
				  </div>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		


@stop
@section('footer') 
<script src="{{ url('js/togglepanel.js') }}" type="text/javascript"></script>
    {!! HTML::script('js/uk.js') !!}   
    <script>
        var base = "{{ url('/') }}";

        $('#G').keyup(function(e) {
            riwObsG();
        });

        uk('umur_kehamilan', 'hpht');


        $('#hamil').change(function(e) {
            if ($(this).val() == '1') {
                $('.divAnc').removeClass('hide').hide().fadeIn(500);
            } else if( $(this).val() == '0'){
                empty();
                $('.divAnc').fadeOut(500);
            }
        });

        $('#perujuk_submit').click(function(e) {
            var nama = $('#nama_perujuk').val();
            var alamat = $('#alamat_perujuk').val();
            var no_telp = $('#no_telp_perujuk').val();

            if(nama == ''){
                validasi('#nama_perujuk', 'Harus Diisi!!');
            } else {
                var param = {
                    'nama' : nama,
                    'alamat' : alamat,
                    'no_telp' : no_telp
                }

                console.log(param);

                $.post('{{ url("anc/perujx") }}', param, function(data) {
                    data = $.parseJSON(data);
                    console.log(data);
                    if (data.success == '1') {
                        alert('Bidan ' + nama + ' berhasil dimasukkan ke dalam database');
                        var temp = '<option value="' + data.id + '">' + nama + '</option>';
                        $('#perujuk_id').append(temp).val(data.id).selectpicker('refresh');
                        $('#buat_perujuk').modal('hide');
                    } else {
                        alert('gagal');
                    }
                });
            }

        });

        function rowEntry(control) {

            riwayat = [];
            var ID_PASIEN = $(control).closest('tr').find('td:nth-child(8)').html();
            var ID_POLI = $(control).closest('tr').find('td:nth-child(7)').html();
            var ID_STAF = $(control).closest('tr').find('td:nth-child(9)').html();
            var ID_ASURANSI = $(control).closest('tr').find('td:nth-child(10)').html();
            var namaPasien = $(control).closest('tr').find('td:nth-child(4)').html();
            var tanggal = $(control).closest('tr').find('td:nth-child(6)').html();
            var jam = $(control).closest('tr').find('td:nth-child(5)').html();
            var ID_ANTRIAN_POLI = $(control).closest('tr').find('td:first-child').html();
            var antrian = $(control).closest('tr').find('td:nth-child(2)').html();
            var image = $(control).closest('tr').find('td:nth-child(11)').html();
            var umur = $(control).closest('tr').find('td:last-child').html();

			$.get('{{url('antrianpolis/ajax/getGolonganProlanis')}}',
				{ 'pasien_id': ID_PASIEN },
				function (data) {
					data = $.trim(data);
					if(data == '0'){
					}else{
						 $('#alert_prolanis').modal('show');
						 $('#no_telp_pasien').html(data);
						 $('#redirect_update_pasien').prop('href', '{{ url("pasiens") }}' + '/' + ID_PASIEN + '/edit');
					}
				}
			);

            if (ID_ASURANSI == '32') {
                $('#pastikan').show();
                $.post('{{ url("pasiens/ajax/cekbpjskontrol") }}', {'pasien_id': ID_PASIEN, 'asuransi_id' : ID_ASURANSI}, function(data, textStatus, xhr) {
                      MyArray = $.parseJSON(data);
                      var data = MyArray.kode;
                      var tanggal = MyArray.tanggal;
                      if (tanggal == '') {
                        var text = 'GDS gratis untuk BPJS hanya untuk riwayat kencing manis atau usia > 50 tahun'
                      } else {
                        var text = 'Pasien sudah periksa GDS bulan ini tanggal ' + tanggal;
                      }
                      $('#karena').html(text)

                      if (data == '3') {
                        $('#cekBPJSkontrol').show();
                        $('#cekGDSBPJS').show();
                      } else if(data == '2'){
                        $('#cekBPJSkontrol').show();
                        $('#cekGDSBPJS').hide();
                      } else if(data == '1'){
                        $('#cekBPJSkontrol').hide();
                        $('#cekGDSBPJS').show();
                      } else {
                        $('#cekBPJSkontrol').hide();
                        $('#cekGDSBPJS').hide();
                      }
                });
                $('#lblKecelakaanKerja').html('Kecelakaan Kerja / Kecelakaan Lalu Lintas')
            } else {
                $('#cekBPJSkontrol').hide();
                $('#pastikan').hide();
                $('#lblKecelakaanKerja').html('Kecelakaan Kerja')
            }

            $('#usia').html(umur);
            $('#namaPasien1').val(namaPasien);
            $('.nama').html(namaPasien);
            $('#jamDatang1').html(jam);
            $('#jamDatang').val(jam);
            $('#pembayaran1 ').val(ID_ASURANSI);
            $('#ddlDokter').val(ID_STAF);
            $('#poli1').val(ID_POLI);
            $('#ID_PASIEN').val(ID_PASIEN);
            $('#tanggal').val(tanggal);
            $('#ID_ANTRIAN_POLI').val(ID_ANTRIAN_POLI);
            $('#antrian').val(antrian);
            $('#formfield').val(image);
            $('#photo').attr("src", "{{ url('/') }}"+image);

            empty();

            if (ID_POLI == 'usg') {
                if ($('#divUsg').hasClass('hide')) {
                    $('#divUsg').removeClass('hide');
                }
                $('.divAnc').each(function(index, el) {
                    if ($(this).hasClass('hide')) {
                        $(this).removeClass('hide');
                    }
                });
                $('#hamil').val('1');
            } else if (ID_POLI == 'anc'){
                $('.divAnc').each(function(index, el) {
                    if ($(this).hasClass('hide')) {
                        $(this).removeClass('hide');
                    }
                });
                if (!$('#divUsg').hasClass('hide')) {
                    $('#divUsg').addClass('hide');
                }
                $('#hamil').val('1');
            } else {
                $('.divAnc').each(function(index, el) {
                    if (!$(this).hasClass('hide')) {
                        $(this).addClass('hide');
                    }
                });
                if (!$('#divUsg').hasClass('hide')) {
                    $('#divUsg').addClass('hide');
                }
                $('#hamil').val('');
            }

        }

        function testSubmit(){
            if (!validatePass()) {

            } else if ($('#usg').val() == '1') {
                $('#ok').click();
            } else {
                $('#LinkButton1').click();
            }
        }

        function alas(control){
            $('.alasan').val('');
            var id = $(control).closest('tr').find('.alasan').attr('id');
            var submit_id = $(control).closest('tr').find('.submit').attr('id');
			console.log('id = ' + id);
			console.log('submit_id = ' + submit_id);
            $('#modal-alasan').modal('show');
            $('#modal-alasan').on('shown.bs.modal', function(){
                $('#alasan_textarea').val('').focus(); 
            });
            $('#alasan_id').val(id);
            $('#submit_id').val(submit_id);
        }

        function hapusSajalah(){
            var id = $('#alasan_id').val();
            var submit_id = $('#submit_id').val();
            console.log('id = ' + id);
            $('#' + id).val($('#alasan_textarea').val());
            $('#' + submit_id).click();
        }

        
        function testSubmit2(){

            $('#LinkButton1').click();

        }

        function getOption(){

            $.post('{{ url("perujuk") }}', { }, function(data) {
                data = $.parseJSON(data);
                var temp = '<option value="" selected>-Pilih Perujuk-</option>';
                for (var i = 0; i < data.length; i++) {
                    temp += '<option value="' + data[i].id + '">' + data[i].nama + '</option>';
                }
                $('#perujuk_id').html(temp);
                $('#perujuk_id').selectpicker('refresh');
            })

        }

        function riwObsG(){
            if ($('#G').val() != '' && $('#G').val() < 10) {
                var pasien_id = $('#ID_PASIEN').val();
                var G = $('#G').val();
              $.post(base+'/anc/registerhamil', {'G': G, 'pasien_id' : pasien_id}, function(data) {
                if (data != '') {
                    $('#hpht').val(data.hpht).attr('readonly', 'readonly');
                    $('#umur_kehamilan').val(data.uk).attr('readonly', 'readonly');
                    $('#P').val(data.p).attr('readonly', 'readonly');
                    $('#A').val(data.a).attr('readonly', 'readonly');
                }
              });
            } else {
              $('.gpa2').val('').removeAttr('readonly');
              $('.inputObs').val('').removeAttr('readonly');
            }
        }

        function empty(){
            $('.gpa').val('');
            $('.inputObs').val('');
            $('#perujuk_id').val('');
        }

        function ubahKKKLL(){
            $('#kecelakaanKerja').val('1');
            $('#dummySubmitButton').click();
        }
		function closeModal(){
			 $('#alert_prolanis').modal('hide');
		}
    </script>

@stop
