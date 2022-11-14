@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Supplier
@stop
@section('page-title') 
 <h2>Supplier</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('suppliers')}}">Home</a>
      </li>
      <li class="active">
          <strong>Show</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-info">
      <!-- Default panel contents -->
	  <div class="panel-heading">
			<div class="panelLeft">
				Riwayat Pembelanjaan
			</div> 
	  </div>
        <div class="panel-body">
			<div class="table-responsive">
			<table class="table table-condensed table-hover">
			  <tbody>
				<tr>
				  <td class="text-bold">Nama</td>
				  <td>{!!$supplier->nama!!}</td>
				</tr>
				<tr>
				  <td class="text-bold">Alamat</td>
				  <td>{!!$supplier->alamat!!}</td>
				</tr>
				<tr>
				  <td class="text-bold">No Telp</td>
				  <td>{!!$supplier->no_telp!!}</td>
				</tr>
				<tr>
				  <td class="text-bold">PC </td>
				  <td>{!!$supplier->pic!!}</td>
				</tr>
				<tr>
				  <td class="text-bold">HP PIC</td>
				  <td>{!!$supplier->hp_pic!!}</td>
				</tr>
				<tr>
				  <td class="text-bold">Created At</td>
				  <td>{!!$supplier->created_at->format('d-m-Y')!!}</td>
				</tr>
			  </tbody>
			</table>
			</div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
					Riwayat Pembelian
                </div>
            </div>
      </div>
      <div class="panel-body">
<div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#obat" aria-controls="obat" role="tab" data-toggle="tab">Belanja Obat ({{ $belanja_obats_count }})</a></li>
	<li role="presentation"><a href="#alat" aria-controls="alat" role="tab" data-toggle="tab">Belanja Peralatan ({{ $belanja_alats_count }})</a></li>
	<li role="presentation"><a href="#lain" aria-controls="lain" role="tab" data-toggle="tab">Belanja Lain-lain ({{ $pengeluarans_count }})</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="obat">
		<div class="table-responsive">
            <?php echo $belanja_obats->appends(Input::except('page'))->links(); ?>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
					  <th>tanggal</th>
					  <th>Nomor Faktur</th>
					  <th>Jenis Belanja</th>
					  <th>Jumlah Item</th>
					  <th>Total Biaya</th>
					  <th>Action</th>
					</tr>
				</thead>
				<tbody>
				  @if($belanja_obats->count())
					@foreach ($belanja_obats as $faktur_beli)
					<tr>
						<td><div>{!!App\Models\Classes\Yoga::updateDatePrep($faktur_beli->tanggal)!!}</div></td>
						<td><div>{!!$faktur_beli->nomor_faktur!!}</div></td>
						<td><div>{!!$faktur_beli->belanja->belanja!!}</div></td>
						<td><div>{!!$faktur_beli->items!!} pcs</div></td>
						<td><div class="uang">{!!$faktur_beli->totalbiaya!!}</div></td>
						<td>
						  <a href="{{ url('pembelians/show/' . $faktur_beli->id) }}" class="btn-sm btn btn-primary btn-xs">Detail</a>
						</td>
					</tr>
					@endforeach
				  @else 
					<td colspan="6" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
				  @endif
				</tbody>
			</table>
            <?php echo $belanja_obats->appends(Input::except('page'))->links(); ?>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane" id="alat">
		<div class="table-responsive">
            <?php echo $belanja_alats->appends(Input::except('page'))->links(); ?>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
					  <th>tanggal</th>
					  <th>Nomor Faktur</th>
					  <th>Jenis Belanja</th>
					  <th>Jumlah Item</th>
					  <th>Total Biaya</th>
					  <th>Action</th>
					</tr>
				</thead>
				<tbody>
				  @if($belanja_alats->count())
					@foreach ($belanja_alats as $faktur_beli)
					<tr>
						<td><div>{!!App\Models\Classes\Yoga::updateDatePrep($faktur_beli->tanggal)!!}</div></td>
						<td><div>{!!$faktur_beli->nomor_faktur!!}</div></td>
						<td><div>{!!$faktur_beli->belanja->belanja!!}</div></td>
						<td><div>{!!$faktur_beli->items!!} pcs</div></td>
						<td><div class="uang">{!!$faktur_beli->totalbiaya!!}</div></td>
						<td>
						  <a href="{{ url('pembelians/show/' . $faktur_beli->id) }}" class="btn-sm btn btn-primary btn-xs">Detail</a>
						</td>
					</tr>
					@endforeach
				  @else 
					<td colspan="6" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
				  @endif
				</tbody>
			</table>
            <?php echo $belanja_alats->appends(Input::except('page'))->links(); ?>
		</div>
	</div>

	<div role="tabpanel" class="tab-pane" id="lain">
		<div class="table-responsive">
            <?php echo $pengeluarans->appends(Input::except('page'))->links(); ?>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
					  <th>Tanggal</th>
					  <th>Supplier</th>
					  <th>Petugas</th>
					  <th>Nilai</th>
					  <th>Keterangan</th>
					  <th>Action</th>
					</tr>
				</thead>
				<tbody>
				  @if($pengeluarans->count())
					@foreach ($pengeluarans as $faktur_beli)
					<tr>
						<td><div>{!! $faktur_beli->tanggal->format('d-m-Y') !!}</div></td>
						<td><div>{!!$faktur_beli->supplier->nama!!} pcs</div></td>
						<td><div>{!!$faktur_beli->staf->nama !!}</div></td>
						<td><div class="uang">{!!$faktur_beli->nilai!!}</div></td>
						<td><div>{!!$faktur_beli->keterangan !!}</div></td>
						<td>
						  <a href="{{ url('pengeluarans/show/' . $faktur_beli->id) }}" class="btn-sm btn btn-primary btn-xs">Detail</a>
						</td>
					</tr>
					@endforeach
				  @else 
					<td colspan="6" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
				  @endif
				</tbody>
			</table>
            <?php echo $pengeluarans->appends(Input::except('page'))->links(); ?>
		</div>
	
	</div>
  </div>
</div>
      </div>
</div>
  </div>
</div>

@stop
@section('footer') 


@stop
