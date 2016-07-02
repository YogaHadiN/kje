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
<div class="panel panel-default">
  <div class="panel-body">

    <table class="table">
      <tbody>
        <tr>
          <td>Harta / Aktiva</td>
          <td>Hutang / Liabilitas</td>
        </tr>
        <tr>
          <td>
            <table class="table">
              <tbody>

                <tr>
                  <td colspan="3">Lancar</td>
                </tr>
                {{-- @foreach($jurnalumums as $ju) --}}
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                {{-- @endforeach --}}
                <tr>
                  <td colspan="3">Tidak Lancar</td>
                </tr>
                {{-- @foreach($jurnalumums as $ju) --}}
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                {{-- @endforeach --}}
              </tbody>
            </table>
          </td>
          <td>
            <table class="table">
              <tbody>
                <tr>
                  <td colspan="3">Hutang</td>
                </tr>
                {{-- @foreach() --}}
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                {{-- @endforeach --}}
                <tr>
                  <td colspan="3">Modal / Ekuitas</td>
                </tr>
                {{-- @foreach() --}}
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                {{-- @endforeach --}}
              </tbody>
            </table>
          </td>
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