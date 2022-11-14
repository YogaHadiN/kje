@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} |
                  Laporan Puskesmas Jumlah Ispa periode {{ App\Models\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Models\Classes\Yoga::updateDatePrep($akhir) }}
@stop
@section('head')
    <link href="{!! asset('css/print.css') !!}" rel="stylesheet" media="print">
@stop
@section('page-title') 

 <h2>Laporan Puskesmas Jumlah Ispa periode {{ App\Models\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Models\Classes\Yoga::updateDatePrep($akhir) }}
</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Puskesmas Jumlah Ispa periode {{ App\Models\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Models\Classes\Yoga::updateDatePrep($akhir) }}
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
				  <div class="table-responsive">
						<table class="table table-condensed table-hover">
							<tbody>
								@foreach ($data as $dt)
									<tr>
										<td>{{ $dt['keterangan'] }}</td>
										<td>{{ $dt['jumlah'] }}</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><h3>Pasien yang lain tidak ada data tanggal lahir</h3></td>
								</tr>
							</tfoot>
						</table>
				  </div>
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



