@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Jumlah Pasien

@stop
@section('head')
    <link href="{!! asset('css/print.css') !!}" rel="stylesheet" media="print">
@stop
@section('page-title') 

 <h2>Laporan Harian</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Jumlah Pasien</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-info">
              <div class="panel-heading">
                  <div class="panelLeft">
                        Ringkasan Jumlah Pasien Menurut Asuransi 
                      Periode {{ App\Models\Classes\Yoga::updateDatePrep($mulai) }}  s/d {{ App\Models\Classes\Yoga::updateDatePrep($akhir)  }}
                  </div>
              </div>
              <div class="panel-body">
				  <div class="table-responsive">
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th>Nama Asuransi</th>
									<th>Jumlah</th>
								</tr>
							</thead>
							<tbody>
							@if (count($jumlah) > 0)
							@foreach ($jumlah as $jm)
								<tr>
									<td>{!! $jm->nama_asuransi !!}</td>
									<td>{!! $jm->jumlah !!}</td>
								</tr>
							@endforeach
							@else
								<tr>
									<td colspan="2" class="text-center">Tidak ada data untuk ditampilkan :p</td>
								</tr>
							@endif

							</tbody>
							<tfoot>
								<tr>
									<th>Total</th>
									<th>{{ $total }}</th>
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

