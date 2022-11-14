@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Laporan Puskesmas Jumlah Diare periode {{ App\Models\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Models\Classes\Yoga::updateDatePrep($akhir) }}

@stop
@section('head')
    <link href="{!! asset('css/print.css') !!}" rel="stylesheet" media="print">
@stop
@section('page-title') 

 <h2>Laporan Puskesmas Jumlah Diare periode {{ App\Models\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Models\Classes\Yoga::updateDatePrep($akhir) }}
</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Puskesmas Jumlah Diare periode {{ App\Models\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Models\Classes\Yoga::updateDatePrep($akhir) }}
</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-info">
              <div class="panel-heading">
                  Laporan Puskesmas Jumlah Diare periode {{ App\Models\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Models\Classes\Yoga::updateDatePrep($akhir) }}
              </div>
              <div class="panel-body">
				  <div class="table-responsive">
						<table class="table table-condensed table-hover">
							<tbody>
								<tr>
									<td>Jumlah Diare 0 - 6 bulan Laki-laki</td>
									<td>{{ $jumlahDiare_0_5_L }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 0 - 6 bulan Perempuan</td>
									<td>{{ $jumlahDiare_0_5_P }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 6 - 12 bulan Laki-laki</td>
									<td>{{ $jumlahDiare_6_12_L }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 6 - 12 bulan Perempuan</td>
									<td>{{ $jumlahDiare_6_12_P }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 1 - 5 tahun Laki-laki</td>
									<td>{{ $jumlahDiare_1_4_L }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 1 - 5 tahun Perempuan</td>
									<td>{{ $jumlahDiare_1_4_P }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 5 - 9 Tahun Laki-laki</td>
									<td>{{ $jumlahDiare_5_9_L }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 5 - 9 Tahun Perempuan</td>
									<td>{{ $jumlahDiare_5_9_P }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 10 - 14 Tahun Laki-laki</td>
									<td>{{ $jumlahDiare_10_14_L }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 10 - 14 Tahun Perempuan</td>
									<td>{{ $jumlahDiare_10_14_P }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 15 - 19 Tahun Laki-laki</td>
									<td>{{ $jumlahDiare_15_19_L }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare 15 - 19 Tahun Perempuan</td>
									<td>{{ $jumlahDiare_15_19_P }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare Diatas 20 tahun Laki-laki</td>
									<td>{{ $jumlahDiare_20_L }}</td>
								</tr>
								<tr>
									<td>Jumlah Diare Diatas 20 tahun Perempuan</td>
									<td>{{ $jumlahDiare_20_P }}</td>
								</tr>
								<tr>
									<td>Total Jumlah Diare</td>
									<td>{{ $jumlahDiare}}</td>
								</tr>
								<tr>
									<td>Total Jumlah Diare Yang Diberikan Zinc 0 - 6 bulan</td>
									<td>{{ $jumlahZink_0_5_diare }}</td>
								</tr>
								<tr>
									<td>Total Jumlah Diare Yang Diberikan Zinc 6 - 12 bulan</td>
									<td>{{ $jumlahZink_6_11_diare }} </td>
								</tr>
								<tr>
									<td>Total Jumlah Diare Yang Diberikan Zinc 1 - 5 tahun</td>
									<td>{{ $jumlahZink_1_4_diare }} </td>
								</tr>
								<tr>
									<td>Total Jumlah Pasien Konsumsi Zinc 0 - 6 bulan</td>
									<td>{{ $jumlahZink_0_5 }}</td>
								</tr>
								<tr>
									<td>Total Jumlah Pasien Konsumsi Zinc 6 - 12 bulan</td>
									<td>{{ $jumlahZink_6_11 }} </td>
								</tr>
								<tr>
									<td>Total Jumlah Pasien Konsumsi Zinc 1 - 5 tahun</td>
									<td>{{ $jumlahZink_1_4 }} </td>
								</tr>
								<tr>
									<td>Total Jumlah Pasien Konsumsi Oralit pasien Diare kurang dari 5 tahun</td>
									<td>{{ $jumlahOralit_kurang_dari_5 }} </td>
								</tr>
								<tr>
									<td>Total Jumlah Pasien Konsumsi Oralit pasien Diare Lebih dari 5 tahun</td>
									<td>{{ $jumlahOralit_lebih_dari_5 }} </td>
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
	
<script type="text/javascript" charset="utf-8">
    function printStruk(control){
        alert( $(control).closest('tr').find('.periksa_id').html() );
    }
    
</script>
@stop


