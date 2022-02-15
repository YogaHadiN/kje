@foreach( $ht as $h )
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Edit Pasien</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="table-responsive">
						<table class="table table-hover table-condensed table-bordered">
							<tbody>
								<tr>
									<td class="column-fit">Nama</td>
									<td class="nama_pasien">{{ $h['data_bpjs']['nama'] }}</td>
								</tr>
								<tr>
									<td class="column-fit">Tanggal Lahir</td>
									<td>{{ $h['data_bpjs']['tanggal_lahir'] }}</td>
								</tr>
								<tr>
									<td class="column-fit">Alamat</td>
									<td>{{ $h['data_bpjs']['alamat'] }}</td>
								</tr>
								<tr>
									<td class="column-fit">Jenis Kelamin</td>
									<td class="jenis_kelamin">{{ $h['data_bpjs']['jenis_kelamin'] }}</td>
								</tr>
								<tr>
									<td class="column-fit">Jenis Prolanis</td>
									<td class="jenis_prolanis">{{ $h['data_bpjs']['rppt'] }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 select_div">
					<select class="form-control selectPasien">
							<option value="">Pilih</option>
						@foreach( $h['pasiens'] as $p )
							<option value="{{ $p->id }}">{{ $p->nama }} | {{ $p->alamat }}</option>
						@endforeach
					</select>
					<hr>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<button class="btn btn-block btn-primary" onclick="changePasien(this); return false;">Konfirmasi</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
@endforeach
