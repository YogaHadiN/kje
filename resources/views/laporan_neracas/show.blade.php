@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Neraca

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
<div class="panel panel-info">
	<div class="panel-heading">
		<h1>
			Laporan Neraca Tahun 2016
		</h1>
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
					 @if($ju->total > 0)
						<tr>
							<td></td>
							<td>{{ $ju->id }} - {{ $ju->coa }}</td>
							<td class="uang">{{ $ju->total }}</td>
						</tr>
					@endif
				 @endforeach 
                <tr>
                  <td colspan="3"><h3>Tidak Lancar</h3></td>
                </tr>
				 @foreach($akunAktivaTidakLancar as $ju) 
					 @if($ju->total > 0)
						<tr>
							<td></td>
							<td>{{ $ju->id }} - {{ $ju->coa }}</td>
							<td class="uang">{{ $ju->total }}</td>
						</tr>
					@endif
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
					<tr>
					  <td></td>
					  <td>{{ $v->id }} - {{ $v->coa }}</td>
					  <td class="uang">{{ $v->total }}</td>
					</tr>
				 @endforeach 
                <tr>
                  <td colspan="3"><h3>Modal / Ekuitas</h3></td>
                </tr>
				 @foreach($akunModal as $v) 
					<tr>
					  <td></td>
					  <td>{{ $v->id }} - {{ $v->coa }}</td>
					  <td class="uang">{{ $v->total }}</td>
					</tr>
				 @endforeach 
					<tr>
					  <td></td>
					  <td>301999 - Laba Tahun Berjalan</td>
					  <td class="uang">{{ $laba_tahun_berjalan }}</td>
					</tr>
              </tbody>
            </table>
          </td>
        </tr>
		<tr>
			<td><h1 class="uang">{{ $total_harta }}</h1></td>
          <td><h1 class="uang">{{ $total_harta }}</h1></td>
		</tr>
      </tbody>
    </table>
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
