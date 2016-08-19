@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Laba Rugi

@stop
@section('page-title') 
 <h2>List Laporan Laba Rugi</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>List Laporan Laba Rugi</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
  <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
  <div class="panel panel-default">
    <div class="panel-body">
            <div id="header" class="text-center">
              <h3>KLINIK JATI ELOK</h3>
              <h4>Komplek bumi jati elok blok A 1 Nomor 7, jl. Raya legok - parung panjang km. 3, malangnengah,  pagedangan, Tangerang, Banten</h4>
            </div>
            <hr>
            <h3 class="text-center">LAPORAN LABA RUGI</h3>
            <h4 class="red text-center">Periode {{ $bulan }}-{{ $tahun }}</h4>
            <div class="content ">
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td colspan="5" class="light-bold">Pendapatan Usaha</td>
                  </tr>
                  @foreach($pendapatan_usahas as $pend)
                  <tr>
                    <td></td>
					<td colspan="2"><a href="{{ url('buku_besars/show?coa_id='. $pend['coa_id'] . '&bulan='. $bulan . '&tahun='. $tahun) }}">{{ $pend['coa'] }}</a></td>
                    <td class="uang">{{ abs($pend['nilai']) }}</td>
                    <td></td>
                  </tr>
                  @endforeach
                  <tr>
                    <td></td>
                    <td></td>
                    <td>Total Pendapatan Usaha</td>
                    <td></td>
                    <td class="uang">{{ App\Classes\Yoga::neracaLabaRugi($pendapatan_usahas)}}</td>
                  </tr>
                  <tr>
                    <td colspan="5" class="light-bold">Harga Pokok Penjualan</td>
                  </tr>
                  @foreach($hpps as $hpp)
                  <tr>
                    <td></td>
					<td colspan="2"><a href="{{ url('buku_besars/show?coa_id='. $hpp['coa_id'] . '&bulan='. $bulan . '&tahun='. $tahun) }}">{{ $hpp['coa'] }}</a></td>
                    <td class="uang">{{ abs($hpp['nilai']) }}</td>
                    <td></td>
                  </tr>
                  @endforeach
                  <tr>
                    <td></td>
                    <td></td>
                    <td>Total Harga Pokok Penjualan</td>
                    <td></td>
                    <td class="uang">({{ App\Classes\Yoga::neracaLabaRugi($hpps)}})</td>
                  </tr>
                  <tr class="red light-bold">
                    <td></td>
                    <td></td>
                    <td>Laba Rugi Kotor</td>
                    <td></td>
                    <td class="uang">{{ 
                      App\Classes\Yoga::neracaLabaRugi($pendapatan_usahas) - App\Classes\Yoga::neracaLabaRugi($hpps)
                    }}</td>
                  </tr>

                  <tr>
                    <td colspan="5" class="light-bold">Biaya Operasional</td>
                  </tr>
                  @foreach($biayas as $biaya)
                  <tr>
                    <td></td>
					<td colspan="2"><a href="{{ url('buku_besars/show?coa_id='. $biaya['coa_id'] . '&bulan='. $bulan . '&tahun='. $tahun) }}">{{ $biaya['coa'] }}</a></td>
                    <td class="uang">{{ abs($biaya['nilai']) }}</td>
                    <td></td>
                  </tr>
                  @endforeach
                  <tr>
                    <td></td>
                    <td></td>
                    <td>Total Biaya Operasional</td>
                    <td></td>
                    <td class="uang">({{ App\Classes\Yoga::neracaLabaRugi($biayas)}})</td>
                  </tr>
                  <tr class="red light-bold">
                    <td></td>
                    <td></td>
                    <td>Laba Rugi Kotor</td>
                    <td></td>
                    <td class="uang">{{ 
                      App\Classes\Yoga::neracaLabaRugi($pendapatan_usahas) - App\Classes\Yoga::neracaLabaRugi($hpps)
                      -  App\Classes\Yoga::neracaLabaRugi($biayas)
                    }}</td>
                  </tr>
                  <tr>
                    <td colspan="5" class="light-bold">Pendapatan Lain</td>
                  </tr>
                  @foreach($pendapatan_lains as $pend)
                  <tr>
                    <td></td>
					<td colspan="2"><a href="{{ url('buku_besars/show?coa_id='. $pend['coa_id'] . '&bulan='. $bulan . '&tahun='. $tahun) }}">{{ $pend['coa'] }}</a></td>
                    <td class="uang">{{ abs($pend['nilai']) }}</td>
                    <td></td>
                  </tr>
                  @endforeach
                  <tr>
                    <td></td>
                    <td></td>
                    <td>Total Pendapatan Lain</td>
                    <td></td>
                    <td class="uang">{{ App\Classes\Yoga::neracaLabaRugi($pendapatan_lains)}}</td>
                  <tr class="red light-bold">
                    <td></td>
                    <td></td>
                    <td>Laba Rugi Bersih</td>
                    <td></td>
                    <td class="uang">{{ 
                      App\Classes\Yoga::neracaLabaRugi($pendapatan_usahas) - App\Classes\Yoga::neracaLabaRugi($hpps)
                      -  App\Classes\Yoga::neracaLabaRugi($biayas) +  App\Classes\Yoga::neracaLabaRugi($pendapatan_lains)
                    }}</td>
                  </tr>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>
@stop
@section('footer') 
<script>
  function dummySubmit(){
    if (validatePass()) {
      $('#submit').click();
    }
  }
</script>

@stop
