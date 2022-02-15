<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#hutang" aria-controls="hutang" role="tab" data-toggle="tab">Hutang</a></li>
	<li role="presentation"><a href="#pembayaran" aria-controls="pembayaran" role="tab" data-toggle="tab">Pembayaran</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="hutang">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2>Hutang {{ $asuransi->nama }} {{ count( $hutangs ) }} pasien</h2>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					@include('pendapatans.tempRiwayatHutang')
				</div>
			</div>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane" id="pembayaran">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h2>Riwayat Pembayaran {{ $asuransi->nama }}</h2>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						{!! Form::select('displayed_rows', [
							'15'  => '15 Baris',
							'30'  => '30 Baris',
							'50'  => '50 Baris',
							'100' => '100 Baris'
						], 15, [
							'class' => 'form-control displayed_rows displayed_rows_pembayaran',
							'id'    => 'displayed_rows_pembayaran'
						]) !!}
					</div>
				</div>
				<br>
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered" id="table_pembayaran_asuransi">
						<thead>
							<tr>
								<th>
									<a 
										class="getOrderPembayaran"
										data-column-name="pembayaran_asuransi_id"
										data-order="no"
									>
										Id 
									</a>
								  <br>
								  {!! Form::text('id', null, [
									  'class'   => 'form-control id ajaxGetPembayaran',
								  ]) !!}
								</th>
								<th>
									<a 
										class="getOrderPembayaran"
										data-column-name="tanggal_dibayar"
										data-order="no"
									>
									Tanggal
									</a>
								  <br>
								  {!! Form::text('tanggal', null, [
									  'class'   => 'form-control tanggal_dibayar ajaxGetPembayaran'
								  ]) !!}
								</th>
								<th>
									<a 
										class="getOrderPembayaran"
										data-column-name="pembayaran"
										data-order="no"
									>
									Pembayaran
									</a>
								  <br>
								  {!! Form::text('pembayaran', null, [
									  'class'   => 'form-control pembayaran ajaxGetPembayaran'
								  ]) !!}
								</th>
								<th>
									<a 
										class="getOrderPembayaran"
										data-column-name="nilai"
										data-order="no"
									>
									Nilai
									</a>
								  <br>
								  {!! Form::text('nilai', null, [
									  'class'   => 'form-control nilai ajaxGetPembayaran'
								  ]) !!}
								</th>
								<th>
									<a 
										class="getOrderPembayaran"
										data-column-name="selisih"
										data-order="no"
									>
									Selisih
									</a>
								  <br>
								  {!! Form::text('selisih', null, [
									  'class'   => 'form-control selisih ajaxGetPembayaran'
								  ]) !!}
								</th>
								<th>
									<a 
										class="getOrderPembayaran"
										data-column-name="deskripsi"
										data-order="no"
									>
									Deskripsi Rekening
									</a>
								  <br>
								  {!! Form::text('deskripsi', null, [
									  'class'   => 'form-control deskripsi ajaxGetPembayaran'
								  ]) !!}
								</th>
							</tr>
						</thead>
						<tbody id="container_pembayaran_asuransi"></tbody>
					</table>
				   <ul id="pagination_pembayaran_asuransi" class="pagination-sm"></ul>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>

