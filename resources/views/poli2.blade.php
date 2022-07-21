@extends('layout.master')

@section('title') 
    {{ env("NAMA_KLINIK") }} | Poli {!! ucfirst($antrianperiksa->poli->poli)!!}
@stop
@section('head')
  
  <style></style>

@stop
@section('page-title') 
    <h2>RUANG PERIKSA Poli {!! ucfirst($antrianperiksa->poli->poli)!!}</h2>
     <ol class="breadcrumb">
          <li>
              <a href="{!! url('laporans')!!}">Home</a>
          </li>
          <li>
              <a href="{!! url('ruangperiksa/' . $antrianperiksa->poli->poli)!!}">Poli {!! ucfirst($antrianperiksa->poli->poli) !!}</a>
          </li>
          <li class="active">
              <strong>Ruang Periksa</strong>
          </li>
    </ol>
@stop
@section('content') 
@include('before') {!! Form::open(['url' => 'periksas', 'method' => 'post', 'id' => 'submitPeriksa', 'autocomplete' => 'on'])!!}
      @include('form', [
          'pemeriksaan_awal'             => $pemeriksaan_awal,
          'transaksi'                    => $transaksiusg, 
          'berat_badan'                  => $antrianperiksa->berat_badan, 
          'sudah'                        => $sudah, 
          'adatindakan'                  => $adatindakan, 
          'penunjang'                    => $penunjang, 
          'terapiArray'                  => '[]',
          'presentasi'                   => 'kepala tunggal hidup intrauterine',
          'BPD_w'                        => null,
          'BPD_d'                        => null,
          'LTP'                          => null,
          'FHR'                          => null,
          'AC_w'                         => null,
          'AC_d'                         => null,
          'EFW'                          => null,
          'FL_w'                         => null,
          'FL_d'                         => null,
          'Sex'                          => null,
          'Plasenta'                     => 'fundus grade 2 -3 tidak menutupi jalan lahir',
          'total_afi'                    => null,
          'kesimpulan'                   => null,
          'saran'                        => 'periksa hamil 4 minggu lagi',
          'uk'                           => null,
          'tb'                           => $antrianperiksa->tinggi_badan,
          'jumlah_janin'                 => null,
          'nama_suami'                   => null,
          'bb_sebelum_hamil'             => null,
          'tanggal_lahir_anak_terakhir'  => null,
          'golongan_darah'               => null,
          'rencana_penolong'             => null,
          'rencana_tempat'               => null,
          'rencana_pendamping'           => null,
          'rencana_transportasi'         => null,
          'rencana_pendonor'             => null,
          'g'                            => $antrianperiksa->g,
          'p'                            => $antrianperiksa->p,
          'a'                            => $antrianperiksa->a,
          'td'                           => $antrianperiksa->tekanan_darah,
          'bb'                           => $antrianperiksa->berat_badan,
          'tfu'                          => null,
          'lila'                         => null,
          'djj'                          => null,
          'register_hamil_id'            => null,
          'pasien_id'                    => null,
          'status_imunisasi_tt_id'       => '1',
          'buku'                         => '3',
          'refleks_patela'               => '6',
          'kepala_terhadap_pap_id'       => '7',
          'presentasi_id'                => '2',
          'riwayat_kehamilan_sebelumnya' => '[]',
          'catat_di_kia'                 => '1',
          'hpht'                         => App\Models\Classes\Yoga::updateDatePrep($antrianperiksa->hpht)
      ])
{!! Form::close()!!}

@include('after')
@stop
@section('footer') 
<script>
var base = '{!! url('/') !!}';
console.log(base);
</script>
{!! HTML::script('js/allpoli.js')!!} 
<script>
    afiCount();

            $('#cg').combogrid({
				panelWidth:800,
				url: '{{ url("test/getmereks") }}',
				idField:'id',
				textField:'merek',
				mode:'remote',
				fitColumns:true,
				columns:[[
					{field:'merek',title:'Merek',width:100},
					{field:'stok',title:'Stok',width:20},
					{field:'komposisi',title:'Komposisi',align:'left',width:80},
					{field:'aturan_minum',title:'Aturan Minum',align:'left',width:80},
					{field:'fornas',title:'Fornas',align:'left',width:60}
				]]
			});
//                  $('.textbox-text').keypress(function(e){
//                      console.log('keyup');
//                      var key = e.keyCode || e.which;
//                      if(key == '9'){
//                           var text = $('table.datagrid-btable tbody tr:first-child td:first-child div').html();
//                           $(this).val(text);
//                      }
//                      
//                  });
//                  var x=[];
//                  for (var i in window){
//                      x.push(i)
//                  };
//                  console.dir(window);
            //console.log(x.join("\\"));

        function get_value(){
            alert($('#cg').combogrid('getValue'));
        }
        function get_text(){
            alert($('#cg').combogrid('getText'));
        }
</script>
@stop


