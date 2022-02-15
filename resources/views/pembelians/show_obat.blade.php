<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Nomor Faktur : {!! $fakturbelanja->nomor_faktur !!} | {!! $fakturbelanja->supplier->nama !!}</h3>
                </div>
                <div class="panelRight">
                	<h3> Tanggal : {!! App\Models\Classes\Yoga::updateDatePrep($fakturbelanja->tanggal)!!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="row">
			<div class="col-xs-size col-sm-size col-md-size col-lg-size">
			  <div class="table-responsive">
					<table class="table table-bordered" id="tableEntriBeli">
						  <thead>
							<tr>
							   <th>No</th>
							   <th>Merek Obat</th>
							   <th>Harga Beli</th>
							   <th>Harga Jual</th>
							   <th>Exp Date</th>
							   <th>Operator</th>
							   <th>Jumlah</th>
							   <th>Harga Item</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($pembelians as $key => $pembelian)
							 @if ($pembelian->harga_naik > 0)
								{{-- expr --}}
							  <tr class="cust-red-bg">
							 @elseif($pembelian->harga_naik == 0)
							 <tr>
							 @else
							 <tr class="cust-green-bg">
							 @endif
							 <td> {!! $key + 1!!} </td>
							 <td> <a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="{{ $pembelian->merek_id }}" onclick="informasi(this); return false; " href="#" >{!! $pembelian->merek->merek ?? 'merek dihapus' !!}</a> </td>
							@if ($pembelian->harga_naik > 0)
							  {{-- expr --}}
							   <td><span class="uang"> {!! $pembelian->harga_beli !!} </span>, naik {!! $pembelian->harga_naik !!} </td>
							 @elseif($pembelian->harga_naik == 0)
							   <td><span class="uang">{!! $pembelian->harga_beli !!}</span> , tetap </td>
							 @else
							   <td><span class="uang">{!! $pembelian->harga_beli !!}</span> , turun {!! $pembelian->harga_naik!!} </td>
							 @endif
							 <td class="uang"> {!! $pembelian->harga_jual !!} </td>
							 <td> {!! $pembelian->exp_date !!} </td>
							 <td> 
							  @if(isset($pembelian->staf->staf_id))
							  {!! $pembelian->staf->staf_id !!} </td>
							  @endif
							 <td> {!! $pembelian->jumlah !!} </td>
							 <td><span class="uang"> {!! $pembelian->jumlah * $pembelian->harga_beli !!}</span> </td>
							</tr>
							@endforeach
							 
						</tbody>
						<tfoot>
							<tr>
							  <td colspan="4"></td>
							  <td colspan="2" class="text-right bold"> Total Biaya : </td>
							  <td class="bold uang" id="totalHargaObat" colspan="2">{!! $fakturbelanja->harga !!}</td>
							</tr>
						</tfoot>
					</table>
			  </div>
			</div>
		  </div>
		  <div class="row">
		  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="panel panel-info">
					<div class="panel-body">
						<img src="{{ \Storage::disk('s3')->url('img/belanja/obat/' . $fakturbelanja->faktur_image) }}" class="img-rounded upload" alt="Responsive image">
					</div>
				</div>
		  	</div>
		  </div>
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="{{ url('pembelians/' . $fakturbelanja->id . '/edit' ) }}" class='btn btn-warning btn-lg btn-block'>Edit</a>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <a href="{{ url('fakturbelanjas/cari') }}" class='btn btn-danger btn-lg btn-block'>Cancel</a>            
              </div>
            </div>
      </div>
</div>
