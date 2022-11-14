@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Gaji Dokter

@stop
@section('page-title') 
<h2>Bayar Dokter</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
        <li>
          <a href="{{ url('stafs')}}">Staf</a>
      </li>
      <li class="active">
          <strong>Gaji Dokter</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>
                        Dokter : {{ $nama_staf }}
                    </h3>
                </div>
                <div class="panelRight">
                    <h3>
                        Tanggal : {{ $mulai }} s/d {{ $akhir }} 
                    </h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
					<table class="table table-striped table-bordered table-hover " id="tableAsuransi">
					  <thead>
						<tr>
							<th>ID</th>
							<th>Tanggal</th>
							<th>Nama Pasien</th>
							<th>Asuransi</th>
							<th>Tunai</th>
							<th>Piutang</th>
							<th>Jasa Dokter</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($hutangs as $hutang)
							<tr>
								<td>{!! $hutang->pasien_id !!}</td>
								<td>{!! App\Models\Classes\Yoga::updateDatePrep( $hutang->tanggal  )!!}</td>
								<td>{!! $hutang->nama !!}</td>
								<td>{!! $hutang->nama_asuransi !!}</td>
								<td class="uang">{!! $hutang->tunai !!}</td>
								<td class="uang">{!! $hutang->piutang !!}</td>
								<td class="uang">{!! $hutang->nilai !!}</td>
							</tr>
						@endforeach
					</tbody>
				   <tfoot>
					   <tr>
						   <td colspan="4" class="text-right"><h2>Total</h2></td>
						   <td colspan="3" class="bold"><h2 class="uang">{{ $total }}</h2></td>
					   </tr>
				   </tfoot> 
				</table>
		  </div>
      </div>
</div>


@stop
@section('footer') 
	
@stop

