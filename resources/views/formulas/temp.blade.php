<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Riwayat Pembelian</h3>
			</div>
			<div class="panel-body">
				<table class="table table-condensed table-hover table-bordered">
					 <thead>
                    <tr>
                       <th>Merek</th>
                       <th>Harga Beli</th>
                       <th>Rak</th>
                       <th>Nama Apotek</th>
                       <th>Harga Tanggal</th>
                       <th>Detil</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($supplierprices as $k => $v)
                        <tr>
							<td>
								<a class="" target="_blank" href="{{ url('mereks/' . $v->merek_id . '/edit') }}">{!! $v->merek !!}</a>
							</td>
                          <td class="uang">{!! $v->harga_beli!!}</td>
						  <td>
							<a class="" target="_blank" href="{{ url('raks/' . $v->rak_id) }}">{!! $v->rak_id !!}</a>
						  </td>
						  <td>
							  <a class="" target="_blank" href="{{ url('suppliers/' . $v->supplier_id .'/edit') }}">{{ $v->nama }}</a>
						  </td>
                          <td>{!! App\Classes\Yoga::updateDatePrep($v->tanggal) !!}</td>
						  <td> <a class="btn btn-xs btn-success" target="_blank" href="{{ url('pembelians/show/' . $v->faktur_belanja_id) }}">Detil Transaksi</a> </td>
                        </tr>
                   @endforeach
                </tbody>
				</table>
			</div>
		</div>
	</div>
</div>
