@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Laporan Neraca

@stop
@section('page-title') 
 <h2>List Laporan Neraca</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>List Laporan Neraca</strong>
      </li>
</ol>
@stop
@section('content') 

	{{--<div class="panel panel-info">--}}
		{{--<div class="panel-heading">--}}
			{{--<div class="panel-title">Variable</div>--}}
		{{--</div>--}}
		{{--<div class="panel-body">--}}
			{{--<div class="table-responsive">--}}
				{{--<table class="table table-hover table-condensed">--}}
					{{--<tbody>--}}
						{{--<tr>--}}
							{{--<td>$akunAktivaLancar</td>--}}
							{{--<td>{{ json_encode( $akunAktivaLancar ) }}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td>$akunHutang</td>--}}
							{{--<td>{{ json_encode( $akunHutang ) }}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td>$akunModal</td>--}}
							{{--<td>{{ json_encode( $akunModal ) }}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td>$laba_tahun_berjalan</td>--}}
							{{--<td>{{ $laba_tahun_berjalan }}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td>$akunAktivaTidakLancar</td>--}}
							{{--<td>{{ json_encode( $akunAktivaTidakLancar ) }}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td>$labaSebelumnya</td>--}}
							{{--<td>{{ App\Models\Classes\Yoga::buatrp( $labaSebelumnya )}}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td>$total_modal</td>--}}
							{{--<td>{{ App\Models\Classes\Yoga::buatrp( $total_modal ) }}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td>$total_hutang</td>--}}
							{{--<td>{{App\Models\Classes\Yoga::buatrp( $total_hutang ) }}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td>$total_harta</td>--}}
							{{--<td>{{ App\Models\Classes\Yoga::buatrp( $total_harta ) }}</td>--}}
						{{--</tr>--}}
					{{--</tbody>--}}
				{{--</table>--}}
			{{--</div>--}}
		{{--</div>--}}
	{{--</div>--}}
	




<div class="panel panel-info">
	<div class="panel-heading">
		<h1>
			Laporan Neraca Hingga Tanggal {{ $tanggal }}
		</h1>
		<div class="panelRight">
			<a class="btn btn-warning" href="{{ url('pdfs/laporan_neraca/' . $tanggal) }}"> Bentuk PDF</a>
		</div>
	</div>
  <div class="panel-body">

    <table class="table">
      <tbody>
        <tr>
          <td><h1>Harta / Aktiva</h1></td>
          <td><h1>Hutang / Liabilitas</h1></td>
        </tr>
        <tr>
          <td>
            <table class="table">
              <tbody>
                <tr>
                  <td colspan="3"><h3>Lancar</h3></td>
                </tr>
				 @foreach($akunAktivaLancar as $ju) 
					 @include('laporan_neracas.debitkredit')
				 @endforeach 
                <tr>
                  <td colspan="3"><h3>Tidak Lancar</h3></td>
                </tr>
				 @foreach($akunAktivaTidakLancar as $ju) 
					 @include('laporan_neracas.debitkredit')
				 @endforeach 
              </tbody>
            </table>
          </td>
          <td>
            <table class="table">
              <tbody>
                <tr>
                  <td colspan="3"><h3>Hutang</h3></td>
                </tr>
				 @foreach($akunHutang as $v) 
					 @if($ju['kredit'] - $ju['debit'] != 0)
						<tr>
						  <td></td>
						  <td>{{ $v['coa_id'] }} - {{ $v['coa'] }}</td>
						  <td class="text-right">{{$v['kredit'] - $v['debit'] }}</td>
						</tr>
					@endif
				 @endforeach 
                <tr>
                  <td colspan="3"><h3>Modal / Ekuitas</h3></td>
                </tr>
				 @foreach($akunModal as $v) 
						<tr>
						  <td></td>
						  <td>{{ $v['coa_id'] }} - {{ $v['coa'] }}</td>
							@if( $v['coa_id'] == 301000 )
							  <td class="text-right">{{ $v['kredit'] - $v['debit'] + $labaSebelumnya }}</td>
							@else
							  <td class="text-right">{{ $v['kredit'] - $v['debit'] }}</td>
							@endif
						</tr>
				 @endforeach 
					<tr>
					  <td></td>
					  <td>301999 - Laba Tahun Berjalan</td>
					  <td class="text-right">{{ $laba_tahun_berjalan }}</td>
					</tr>
              </tbody>
            </table>
          </td>
        </tr>
		<tr>
			<td class="text-right"><h1>{{ $total_harta }}</h1></td>
          <td class="text-right"><h1>{{ $total_liabilitas + $laba_tahun_berjalan }}</h1></td>

		</tr>
      </tbody>
    </table>
	<h3> Selisih = {{  abs( $total_harta - ( $total_liabilitas + $laba_tahun_berjalan )  ) }}</h3>
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
