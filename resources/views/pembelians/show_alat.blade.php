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
							   <th>Peralatan</th>
							   <th>Harga Satuan</th>
							   <th>Jumlah</th>
							   <th>Harga Item</th>
							</tr>
						</thead>
						<tbody>
							@foreach($peralatans as $key =>$alat)
								<tr>
								  <td>{{ $key + 1 }}</td>
								  <td>{{ $alat->peralatan }}</td>
								  <td class="uang">{{ $alat->harga_satuan }}</td>
								  <td>{{ $alat->jumlah }}</td>
								  <td class="uang">{{ $alat->jumlah * $alat->harga_satuan }}</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
							  <td colspan="4" class="text-right bold"> Total Biaya : </td>
							  <td class="bold uang" id="totalHargaObat">{!! $fakturbelanja->harga !!}</td>
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
						<img src="{{ \Storage::disk('s3')->url('img/belanja/alat/' . $fakturbelanja->faktur_image) }}" class="img-rounded upload" alt="Responsive image">
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
