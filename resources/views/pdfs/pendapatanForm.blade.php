<div class="row" id="content-print">
	<div class="box title-print text-center border-bottom">

		<h1>{{ env("NAMA_KLINIK") }}</h1>
		<h5>
			{{ env("ALAMAT_KLINIK") }} <br>
			Telp : {{ env("TELPON_KLINIK") }}  
		</h5>
		<h2 class="text-center border-top">Pendapatan Lain</h2>

	</div>
	<div class="box border-bottom">
		<div class="table-responsive">
			<table class="table table-condensed">
				<tbody>
					<tr>
						<td>Sumber Uang</td> 
						<td>:</td>
						<td>{{ $pendapatan->sumber_uang }}</td> 
					</tr>  
					<tr>
						<td>Tanggal</td>
						<td>:</td>
						<td>{{ $pendapatan->created_at->format('d-m-Y') }}</td>
					</tr>
					<tr>
						<td>Petugas</td>
						<td>:</td>
						<td>{{ App\Models\Classes\Yoga::buatrp( $pendapatan->nilai ) }}</td>
					</tr>
					<tr>
						<td>Keterangan</td>
						<td>:</td>
						<td>{{ $pendapatan->keterangan }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	   <div class="only-padding">
		   
	   </div> 
		<table class="text-center">
			<tr>
				<td>Penginput</td>
				<td>Disahkan Oleh</td>
			</tr>
			<tr class="tanda-tangan">
				<td></td>
				<td></td>
			</tr>
			<tr>
			<td class="staf-print">{{ $pendapatan->staf->nama }}</td>
				<td>( ................. )</td>
			</tr>
		</table>
	   <div class="small-padding">
		   .
	   </div> 
	</div>

