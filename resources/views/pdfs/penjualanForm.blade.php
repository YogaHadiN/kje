<div class="row" id="content-print">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box title-print text-center border-bottom">
            <h1>{{ ucwords( \Auth::user()->tenant->name ) }}</h1>
            <h5>
                {{ ucwords( \Auth::user()->tenant->address ) }} <br>
                Telp : {{ \Auth::user()->tenant->no_telp }}  
            </h5>
			<h2 class="text-center border-top">
				@if ($nota_jual->tipe_jual_id == 1)
					Penjualan
				@else
					Pendapatan Lain
				@endif
			</h2>
		</div>
	   <div class="box border-bottom">
		   <div class="table-responsive">
				<table class="table table-condensed">
				   <tbody>
					   <tr>
						   <td>Nomor Faktur</td>
							<td>:</td>
						   <td>{{ $nota_jual->id }}</td>
					   </tr>
					   <tr>
						   <td>Nama Kasir</td>
							<td>:</td>
							<td>{{ $nota_jual->staf->nama }}</td>
					   </tr>
						<tr>
						   <td>Tanggal</td>
							<td>:</td>
							<td>{{ $nota_jual->created_at->format('d-m-Y')}}</td>
					   </tr>
						<tr>
						   <td>Jam</td>
							<td>:</td>
							<td>{{ $nota_jual->created_at->format('H:i:s')}}</td>
					   </tr>
				   </tbody>
			   </table>
		   </div>
	   </div>
		<div class="font-small border-bottom">
			@if ($nota_jual->tipe_jual_id == 1)
				<h2>
					<div class="table-responsive">
					<table class="table table-condensed bordered">
						<thead>
							<tr>
								<th>Jenis Transaksi</th>
								<th>Rp</th>
							</tr>
						</thead>
						<tbody id="daftarBelanja">
							<tr>
								<td>Biaya Obat</td>
								<td id="totalBiaya" class="text-right" nowrap colspan="3">{{ App\Models\Classes\Yoga::buatrp( $nota_jual->nilai ) }}</td>
							</tr>
						</tbody>
					</table>
					</div>
				</h2>
			@elseif($nota_jual->tipe_jual_id == 2)
				<div class="table-responsive">
					<table class="table table-condensed bordered">
						<thead>
							<tr>
								<th>Pendapatan Lain</th>
								<th>Rp</th>
								<th>Ket</th>
							</tr>
						</thead>
						<tbody id="daftarBelanja" class="font-small">
							@foreach ($nota_jual->pendapatan as $pemb)
								<tr>
									<td>{{ $pemb->pendapatan }}</td>
									<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $pemb->biaya ) }}</td>
									<td>{{ $pemb->keterangan }}</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot class="big">
							<tr>
								<td>Total</td>
								<td id="totalBiaya" colspan="2" class="text-right">{{ App\Models\Classes\Yoga::buatrp( $nota_jual->total ) }}</td>
							</tr>    
						</tfoot>
					</table>
				</div>
			@endif
		</div>
		</div>
	   <div class="only-padding">
		   
	   </div> 
	   @if ($nota_jual->tipe_jual_id == 1)
			<div class="text-center footer box">
				<h3>
					Semoga Lekas Sembuh
				</h3>
			</div>
	   @elseif ($nota_jual->tipe_jual_id == 2)
		<div class="text-center">
			<table class="table-center">
				<tbody class="text-center">
					<tr class="border-top">
						<td>Diserahkan Oleh</td>
						<td>Diterima Oleh</td>
					</tr>
					<tr class="tanda-tangan">
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>( .................... )</td>
						<td>{{ $nota_jual->staf->nama }}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<p class="text-center">Untuk Diserahkan Kepada Yang Mengantar Uang</p>
	   @endif
		
	   <div class="small-padding">
		   

	   </div> 
	   .
	</div>

