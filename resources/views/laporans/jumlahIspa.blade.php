@extends('layout.master')

@section('title') 
Klinik Jati Elok |
                  Laporan Puskesmas Jumlah Ispa periode {{ App\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Classes\Yoga::updateDatePrep($akhir) }}

@stop
@section('head')
    <link href="{!! asset('css/print.css') !!}" rel="stylesheet" media="print">
@stop
@section('page-title') 

 <h2>Laporan Puskesmas Jumlah Ispa periode {{ App\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Classes\Yoga::updateDatePrep($akhir) }}
</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Puskesmas Jumlah Ispa periode {{ App\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Classes\Yoga::updateDatePrep($akhir) }}
</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-info">
              <div class="panel-heading">

                  Detail

              </div>
              <div class="panel-body">
                    <table class="table table-condensed table-hover">
                        <tbody>
                            @foreach ($data as $dt)
                                <tr>
                                    <td>{{ $dt['keterangan'] }}</td>
                                    <td>{{ $dt['jumlah'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
              </div>
        </div>
    </div>
</div>
@stop
@section('footer') 
	
<script type="text/javascript" charset="utf-8">
    function printStruk(control){
        alert( $(control).closest('tr').find('.periksa_id').html() );
    }
    
</script>
@stop



