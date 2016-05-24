@extends('layout.master')

@section('title') 
Klinik Jati Elok | Kasir
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
                                        <td id='terapih'>{!! $periksa->terapi_html !!}</td>
                                    </tr>
                                </tbody>
                            </table>
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
                           <div class="panelRight">
                                <a href="{!! url('pdfs/status/' . $periksa->id ) !!}" class="btn btn-success" target="_blank" >Lihat Resep</a>
                          </div>
                      </div>
                          <div class="panel-body">
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
                                                <input type="text" class="form-control angka jumlah" value="{!! $terapi->jumlah !!}">
                                            </td>
                                            <td class='uang'>
                                                @if($periksa->asuransi_id == '32')
                                                    @if($terapi->merek->rak->fornas == '0')
                                                        {!! App\Classes\Yoga::kasirHargaJual($terapi, $periksa)!!}
                                                    @else
                                                        0     
                                                    @endif      
                                                @else
                                                    {!! App\Classes\Yoga::kasirHargaJual($terapi, $periksa)!!}
                                                @endif
                                            </td>
                                            <td class='uang totalItem'>
                                                @if($periksa->asuransi->tipe_asuransi == 5)
                                                    @if($terapi->merek->rak->fornas == '0')
                                                    {!! App\Classes\Yoga::kasirHargaJualItem($terapi, $periksa)!!}
                                                    @else
                                                        0    
                                                    @endif      
                                                @else
                                                    {!! App\Classes\Yoga::kasirHargaJualItem($terapi, $periksa)!!}
                                                @endif      
                                            </td>
                                            <td class="hide">{!! $terapi->jumlah !!}</td>
                                            <td class="hide">{!! $terapi->id !!}</td>
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
                    </div>
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
        var fornas = MyArray.fornas;
        var id = $(control).closest('tr').find("td:last-child").html();
        var i = $(control).closest('tr').find('td:first-child').html();
        var param = {
            'merek_id' : merek_id,
            'asuransi_id' : asuransi_id,
            'id' : id
        };

        $.post(base + '/kasir/changemerek', param, function(data, textStatus, xhr) {
            updateTerapi(data);
            if ({!! $periksa->asuransi_id !!} == '32') {
                if (fornas == 0) {
                    $(control).closest('tr').find('td:nth-child(5)').html(harga_jual *{!! $periksa->asuransi->kali_obat  !!});
                } else {
                    $(control).closest('tr').find('td:nth-child(5)').html('0');
                }
            } else {
                $(control).closest('tr').find('td:nth-child(5)').html(harga_jual *{!! $periksa->asuransi->kali_obat  !!});
                $(control).closest('tr').find('td:nth-child(6)').html(harga_jual *{!! $periksa->asuransi->kali_obat  !!} * jumlah);
            }
            hitungTotal();
            rupiah();
        });
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
            $(control).closest('tr').find('td:nth-child(6)').html(parseInt(n) * parseInt(harga));
            hitungTotal();
            rupiah();
        });
    }

    function updateTerapi(data){
        data = $.parseJSON(data);
        if (data.confirm == '1') {
            var terapi = data.terapi;
            $('#terapih').html(terapi);
        }
    }

    function rupiah(){
        $('.uang:not(:contains("Rp"))').each(function() {
            var number = $(this).html();
            number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
            $(this).html('Rp. ' + number + ' ,-');
        });
    }

    function dummyClick(){
        window.open("{!! url('pdfs/status/' . $periksa->id ) !!}");
        $('input[type="submit"]').click();
    }

    function hitungTotal(){
        var total = 0;
        $('.totalItem').each(function(index, el) {
            var string = $(this).html();
            string = parseInt(Number(string.replace(/[^0-9]+/g,"")));
            total += parseInt(string);
        });
        $('#biaya').html(rataAtas5000(total));
    }
</script>

@stop
