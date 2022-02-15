@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Perbaikans

@stop
@section('page-title') 
 <h2>List Perbaikan</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>List Perbaikan</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Perbaikan Transaksi</h3>
                </div>
                <div class="panelRight">
                    <h3>Total : {!! $perbaikans->count() !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <?php echo $perbaikans->appends(Input::except('page'))->links(); ?>

			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Informasi</th>
							<th>sebelum</th>
							<th>sesudah</th>
							<th>terapi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($perbaikans as $perbaikan)
							<tr>
								<td>{!!App\Models\Classes\Yoga::updateDatePrep($perbaikan->periksa->tanggal)!!}
									<br><br>
									{!!$perbaikan->periksa->pasien->nama!!}
									<br><br>
									{!!$perbaikan->periksa->asuransi->nama!!}
								</td>
								<td>
									<table class="table table-condensed nowrap">
										<tbody>
											@foreach(json_decode($perbaikan->sebelum, true) as $prb)
												<tr>
													<td>{!! $prb['jenis_tarif']!!}</td>
													<td class="uang">{!! $prb['biaya']!!}</td>
												</tr>
											@endforeach
										</tbody>
										<tfoot>
											<tr>
												<th>Total</th>
												<th class="uang">{!! App\Models\Classes\Yoga::totalBiaya(json_decode($perbaikan->sebelum, true))!!}</th>
											</tr>
										</tfoot>
									</table>
								</td>
								<td>
									<table class="table table-condensed nowrap">
										<tbody>
											@foreach(json_decode($perbaikan->periksa->transaksi, true) as $prb)
												<tr>
													<td>{!! $prb['jenis_tarif']!!}</td>
													<td class="uang">{!! $prb['biaya']!!}</td>
												</tr>
											@endforeach
										</tbody>
										<tfoot>
											<tr>
												<th>Total</th>
												<th class="uang">{!! App\Models\Classes\Yoga::totalBiaya(json_decode($perbaikan->periksa->transaksi, true))!!}</th>
											</tr>
										</tfoot>
									</table>
								</td>
								<td>
									<table class="table table-condensed nowrap">
										<tbody>
											@foreach($perbaikan->periksa->terapii as $trp)
											<tr>
												<td>{!! $trp->merek->merek !!}</td>
												<td>{!! $trp->jumlah !!}</td>
												<td class="uang">{!! $trp->jumlah * $trp->harga_jual_satuan!!}</td>
											</tr>
											@endforeach
										</tbody>
										<tfoot>
											<tr>
												<th colspan="2">Total</th>
												<th class="uang">{!! App\Models\Classes\Yoga::totalBiayaTerapiJual($perbaikan->periksa->terapii) !!}</th>
											</tr>
										</tfoot>
									</table>
								</td>
					   @endforeach
						</tr>
					</tbody>
				</table>
			</div>
            <?php echo $perbaikans->appends(Input::except('page'))->links(); ?>

      </div>
</div>
@stop
@section('footer') 


@stop
