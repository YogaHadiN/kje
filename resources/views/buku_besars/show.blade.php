@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buku Besar

@stop
@section('page-title') 
 <h2>List Buku Besar</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Buku Besar</strong>
      </li>
</ol>
@stop
@section('content') 
  <div class="panel panel-info">
    <div class="panel-heading">
		<h3 class="panel-title">
			<div class="panelLeft">
				Buku Besar : {{ $jurnalumums->first()->coa->coa }}
			</div>
		</h3>
    </div>
    <div class="panel-body">
      <table class="table table-bordered">
        <thead class="text-center light-bold">
          <tr>
            <td rowspan="2">No</td>
            <td rowspan="2">Tanggal</td>
            <td rowspan="2">Penjelasan</td>
            <td rowspan="2">Debet</td>
            <td rowspan="2">Kredit</td>
            <td colspan="2">Saldo</td>
          </tr>
          <tr>
            <td>Debet</td>
            <td>Kredit</td>
          </tr>
        </thead>
        <tbody>
          @foreach($jurnalumums as $k => $ju)

          <tr>
            <td>{{ $k + 1}}</td>
            <td>{{ $ju->tanggal }}</td>
            <td>{!! $ju->jurnalable->ketjurnal !!}</td>
            @if($ju->debit == 1)
            <td class="uang">
              {{ $ju->nilai }}
            @else
            <td>
            @endif
            </td>
            @if($ju->debit == 0)
            <td class="uang">
              {{ $ju->nilai }}
            @else
            <td>
            @endif
            </td>
            @if(App\Classes\Yoga::bukuBesarDebit($jurnalumums, $k) > 0)
            <td class="uang">
              {{ App\Classes\Yoga::bukuBesarDebit($jurnalumums, $k)}}
            @else
            <td>
            @endif
            </td>
            @if(App\Classes\Yoga::bukuBesarKredit($jurnalumums, $k) > 0)
            <td class="uang">
              {{ App\Classes\Yoga::bukuBesarKredit($jurnalumums, $k)}}
            @else
            <td>
            @endif
            </td>
          </tr>

          @endforeach
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
