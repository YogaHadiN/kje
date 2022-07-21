@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Home

@stop
@section('page-title') 

 <h2>Laporan</h2>
 <ol class="breadcrumb">
      <li class="active">
          <strong>Home</strong>
      </li>
</ol>
@stop
@section('content') 
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                            RINGKASAN PASIEN HARI INI 
                    </div>
                    <div class="panel-body">
						@include('laporans.harianForm', ['periksas' => $periksa_hari_ini])
                    </div>
                </div>
			</div>
		</div>
		<div class="row hide">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<a href="{{ url('ruangperiksa/darurat')}}">
				<div class="widget style1 grey-bg btn-info">
					<div class="row">
						<div class="col-xs-4">
							<i class="fa fa-user-md fa-5x"></i>
						</div>
						<div class="col-xs-8 text-right">
							<span></span>
							<h2>Rawat Jalan</h2>
						</div>
					</div>
				</div></a>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<a href="{{ url('ranaps')}}">
				<div class="widget style1 grey-bg btn-success">
					<div class="row">
						<div class="col-xs-4">
							<i class="fa fa-user-md fa-5x"></i>
						</div>
						<div class="col-xs-8 text-right">
							<span></span>
							<h2>Rawat Inap</h2>
						</div>
					</div>
				</div></a>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<a href="{{ url('ruangperiksa/darurat')}}">
				<div class="widget style1 grey-bg btn-danger">
					<div class="row">
						<div class="col-xs-4">
							<i class="fa fa-user-md fa-5x"></i>
						</div>
						<div class="col-xs-8 text-right">
							<span></span>
							<h2>Transaksi Kasir</h2>
						</div>
					</div>
				</div></a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="alert alert-info">
					<div class="table-responsive">
						<table class="table table-condensed text-center">
							<tbody>
								<tr>
									<td><h3>Angka Kontak Saat ini</h3></td>
									<td><h3>Pengantar belum disubmit</h3></td>
									<td><h3>Angka Kontak Belum Terpenuhi</h3></td>
									<td><h3>Kunjungan sakit Tidak Pakai BPJS Belum Disubmit</h3></td>
								</tr>
								<tr>
									<td><h1> {{ $angka_kontak_saat_ini }} </h1></td>
									<td><h1> <a class="" href="{{ url('laporans/pengantar') }}">{{ $pengantar_belum_disubmit }}</a> </h1></td>
									<td><h1><a class="" href="{{ url('laporans/angka_kontak_belum_terpenuhi') }}"> {{ $angka_kontak_belum_terpenuhi }} </a></h1></td>
									<td><h1> <a class="" href="{{ url('laporans/bpjs_tidak_terpakai/'. date('m-Y')) }}">{{ $kunjungan_sakit_belum_di_submit }}</a> </h1></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="alert alert-success">
					<div class="table-responsive">
						<table class="table table-condensed text-center">
							<tbody>
								<tr>
									<td><h3>HT Terkendali</h3></td>
									<td><h3>DM Terkendali</h3></td>
									<td><h3>RPPT</h3></td>
								</tr>
								<tr>
                                    <td><h1> <a href="{{ url('laporans/ht_terkendali/'. date('Y-m')) }}"> {{ $jumlah_ht_terkendali }}  / {{ $jumlah_denominator_ht }} pasien</a> </h1></td>
                                    <td><h1> <a href="{{ url('laporans/dm_terkendali/'. date('Y-m')) }}" target="_blank"> {{ $jumlah_dm_terkendali }} / {{ $jumlah_denominator_dm }} pasien </a> </h1></td>
									<td><h1> {{ $rppt }} % </h1></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
        </div>
		</div>
        <div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="alert alert-warning">
					<div class="table-responsive">
						<table class="table table-condensed text-center">
							<tbody>
								<tr>
									<td><h3>Jumlah Pasien Lama</h3></td>
									<td><h3>Persen Pasien Lama</h3></td>
								</tr>
								<tr>
									<td><h1> {{ $jumlah_pasien_lama_bulan_ini }}</h1></td>
									<td><h1> {{ $persen_pasien_lama_bulan_ini }} % </h1></td>
								</tr>
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="alert alert-warning">
					<div class="table-responsive">
						<table class="table table-condensed text-center">
							<tbody>
								<tr>
									<td><h3>Jumlah Pasien Baru</h3></td>
									<td><h3>Persen Pasien Baru</h3></td>
								</tr>
								<tr>
									<td><h1> {{ $jumlah_pasien_baru_bulan_ini }}</h1></td>
									<td><h1> {{ $persen_pasien_baru_bulan_ini }} % </h1></td>
								</tr>
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="alert alert-danger">
					<div class="table-responsive">
						<table class="table table-condensed text-center">
							<tbody>
								<tr>
									<td><h3>Obat Stok Minus</h3></td>
									<td><h3>Stok Obat Kritis</h3></td>
									<td><h3>Obat Hampir Kadaluarsa</h3></td>
									<td><h3>Obat Kadaluarsa</h3></td>
								</tr>
								<tr>
									<td><h1> {{ $obat_minus }} </h1></td>
									<td><h1> <a class="" href="{{ url('laporans/pengantar?bulanTahun='. date('m-Y')) }}">{{ $obat_stok_kritis }}</a> </h1></td>
									<td><h1> <a class="" href="{{ url('laporans/sms/bpjs?bulanTahun='. date('m-Y')) }}">{{ $obat_hampir_kadaluarsa }}</a> </h1></td>
									<td><h1> <a class="" href="{{ url('laporans/bpjs_tidak_terpakai?bulanTahun='. date('m-Y')) }}">{{ $obat_kadaluarsa }}</a> </h1></td>
									<td><h1></h1></td>
								</tr>
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
		</div>
			<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					@if ($auth->role_id != '1')
						<div class="panel panel-success">
							<div class="panel-heading">
								Laporan Khusus
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Cek</th>
												<th>Jenis Laporan</th>
												<th></th>
												<th></th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<form action="{{ url('laporans/harian') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Harian</td>
													<td><input type="text" class="form-control tanggal" name="tanggal" value="{!!date('d-m-Y')!!}"/>
													</td>
													<td colspan="2">
														{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}

														</select></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/pengantar') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Pengantar Pasien BPJS</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2"></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/bpjs_tidak_terpakai') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan pasien BPJS tidak pakai BPJS</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2"></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/sms/bpjs') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan SMS Pasien BPJS</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2"></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/hariandanjam') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td><input type="text" class="form-control tanggal" name="tanggal_awal" value="{!!date('d-m-Y')!!}"/>
													</td>
													<td><input type="text" class="form-control jam" name="jam_awal" value="13:00:00"/>
													</td>
													<td><input type="text" class="form-control tanggal" name="tanggal_akhir" value="{!!date('d-m-Y')!!}"/>
													</td>
													<td><input type="text" class="form-control jam" name="jam_akhir" value="13:00:00"/>
													</td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/haridet') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Harian Asuransi</td>
													<td><input type="text" class="form-control tanggal" name="tanggal" value="{!!date('d-m-Y')!!}"/>
													</td>
													<td colspan="2">
														{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}

														</select></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/harikas') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Harian Kasir</td>
													<td><input type="text" class="form-control tanggal" name="tanggal" value="{!!date('d-m-Y')!!}"/>
													</td>
													<td colspan="2">
														{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}
														</select></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/bulanan') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Bulanan Asuransi</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2">
														{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}

														</select></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/tanggal') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Bulanan Per Tanggal</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2">
														{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}

														</select></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/detbulan') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Bulanan Detail</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2">
														{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}

													</td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/bpjs/diagnosa') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Bulanan Diagnosa Rujukan BPJS</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2"></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/bpjs/dm') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Bulanan Diabetes BPJS</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2"></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/bpjs/hipertensi') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Bulanan Hipertensi BPJS</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2"></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/points') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Points</td>
													<td>
													</td>
													<td><input type="text" class="form-control tanggal" placeholder="mulai" name="mulai" value="{!! date('d-m-Y')!!}"/></td>
													<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" placeholder="akhir" name="akhir"/></td>
												</form>
											</tr> 
											<tr>
												<form action="{{ url('laporans/penyakit') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan REKAPITULASI PENYAKIT</td>
													<td>
														{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}
													</td>
													<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="mulai" placeholder="mulai"/>
														<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="akhir" placeholder="akhir"/>
												</form>
											</tr>	   
											<tr>
												<form action="{{ url('laporans/status') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan STATUS</td>
													<td>
														{!! Form::select('staf_id', $staf, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}
													</td>
													<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="mulai" placeholder="mulai"/>
														<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="akhir" placeholder="akhir"/>
												</form>
											</tr>
											<tr>
												<form action="{{ url('dispensings') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Dispensing</td>
													<td>
														{!!Form::select('rak_id', $raklist, null, ['class'=>'form-control selectpick', 'data-live-search'=>'true'])!!}
													</td>						
													<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" placeholder="mulai" name="mulai"/></td>
													<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" placeholder="akhir" name="akhir"/></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('pembelians/riwayat') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Pembelian Obat</td>
													<td>
													</td>						
													<td><input type="text" class="form-control bulanTahun" placeholder="bulan" name="bulanTahun" value="{!! date('m-Y')!!}"/></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('pengeluarans/list') }}" method="post">
													<input type="hidden" name="_token" value="{{ Session::token() }}">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Pengeluaran</td>
													<td>
													</td>						
													<td><input type="text" value="{{ date('d-m-Y') }}" class="form-control tanggal" placeholder="mulai" name="mulai"/></td>
													<td><input type="text" value="{{ date('d-m-Y') }}" class="form-control tanggal" placeholder="akhir" name="akhir"/></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/pendapatan') }}" method="post">
													<input type="hidden" name="_token" value="{{ Session::token() }}">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Pendapatan Lain</td>
													<td>
													</td>						
													<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" placeholder="mulai" name="mulai"/></td>
													<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" placeholder="akhir" name="akhir"/></td>
												</form>
											</tr>
											<tr>
												{!! Form::open(['url' => 'rujukans/show' , 'method' => 'get']) !!}
												<td><input type="submit" class="btn btn-primary btn-sm" value="submit"/></td>
												<td>Laporan kirim RUJUKAN</td>
												<td></td>
												<td><input value="{{ date('d-m-Y') }}" type="text" name="mulai" class="form-control tanggal" placeholder="mulai"/></td>
												<td><input value="{{ date('d-m-Y') }}" type="text" name="akhir" class="form-control tanggal" placeholder="akhir"/></td>
												{!! Form::close()!!}
											</tr>
											<tr>
												{!! Form::open(['url' => 'laporans/rujukankebidanan', 'method' => 'get'])!!}
												<td><input type="submit" class="btn btn-primary btn-sm" value="submit"/></td>
												<td>Laporan RUJUKAN KASUS KEBIDANAN</td>
												<td></td>
												<td> {!! Form::text('mulai',  date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'mulai'])!!}</td>
												<td> {!! Form::text('akhir',  date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'akhir'])!!}</td>
												{!! Form::close()!!}
											</tr>
											<tr>
												{!! Form::open(['url' => 'perbaikantrxs/show', 'method' => 'get'])!!}
												<td><input type="submit" class="btn btn-primary btn-sm" value="submit"/></td>
												<td>Laporan Perbaikan Transaksi</td>
												<td></td>
												<td> {!! Form::text('mulai', date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'mulai'])!!}</td>
												<td> {!! Form::text('akhir',  date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'akhir'])!!}</td>
												{!! Form::close()!!}
											</tr>

											<tr>
												{!! Form::open(['url' => 'perbaikanreseps/show', 'method' => 'get'])!!}
												<td><input type="submit" class="btn btn-primary btn-sm" value="submit"/></td>
												<td>Laporan Perbaikan Resep</td>
												<td></td>
												<td> {!! Form::text('mulai', date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'mulai'])!!}</td>
												<td> {!! Form::text('akhir',  date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'akhir'])!!}</td>
												{!! Form::close()!!}
											</tr>
											<tr>
												{!! Form::open(['url'=>'laporans/bayardokter', 'method'=> 'get']) !!} 
												<td><input type="submit" class="btn btn-primary btn-sm" value="submit"/></td>
												<td>Laporan Gaji Dokter</td>
												<td> {!! Form::select('id', $staf, null, ['class' => 'form-control selectpick', 'data-live-search'=> 'true']) !!} </td>
												<td> {!! Form::text('mulai', date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'mulai'])!!}</td>
												<td> {!! Form::text('akhir',  date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'akhir'])!!}</td>
												{!! Form::close() !!}
											</tr> 
											<tr>
												{!! Form::open(['url'=>'laporans/dispensing/bpjs/dokter', 'method'=> 'post']) !!} 
												<td><input type="submit" class="btn btn-primary btn-sm" value="submit"/></td>
												<td>Laporan Dispensing BPJS Per Dokter</td>
												<td> {!! Form::select('id', $staf, null, ['class' => 'form-control selectpick', 'data-live-search'=> 'true']) !!} </td>
												<td> {!! Form::text('mulai', date('m-Y'), ['class' => 'form-control bulanTahun', 'placeholder' => 'mulai'])!!}</td>
												<td></td>
												{!! Form::close() !!}
											</tr>
											<tr>
												<form action="{{ url('laporans/no_asisten') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Tidak Ada Asisten</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2"></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/gigi') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Bulanan Gigi</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2"></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/kb') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Bulanan KB</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2"></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/anc') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Bulanan ANC</td>
													<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
													<td colspan="2"></td>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/jumlahPasien') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Jumlah Pasien</td>
													<td>
														{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}
													</td>
													<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="mulai" placeholder="mulai"/>
														<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="akhir" placeholder="akhir"/>
												</form>
											</tr>
											<tr>
												<form action="{{ url('laporans/jumlahIspa') }}" method="get">
													<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
													<td>Laporan Jumlah Pasien ISPA</td>
													<td>
														{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}
													</td>
													<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="mulai" placeholder="mulai"/>
														<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="akhir" placeholder="akhir"/>
											</tr>
												</form>
												<tr><form action="{{ url('laporans/jumlahDiare') }}" method="get">
														<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
														<td>Laporan Jumlah Pasien Diare</td>
														<td>
															{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}
														</td>
														<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="mulai" placeholder="mulai"/>
															<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="akhir" placeholder="akhir"/>
													</form>
												</tr>
												<tr>
													<form action="{{ url('laporans/jumlahPenyakitTBCTahunan') }}" method="get">
														<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
														<td>Laporan Jumlah TBC Tahunan</td>
														<td>
															{!! Form::text('tahun', date('Y'), ['class' => 'form-control tahun']) !!}
														</td>
													</form>
												</tr>
                                                @if( \Auth::user()->role_id == 6 )
                                                <tr>
													<form action="{{ url('laporans/pph21') }}" method="get">
														<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
														<td>Laporan pph21</td>
														<td><input type="text" class="form-control bulanTahun" name="bulanTahun" value="{!!date('m-Y')!!}"/></td>
														<td colspan="2"></td>
													</form>
												</tr>
                                                @endif
										</tbody>
									</table>
								</div>
							</div>
						</div>  
					@else
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Pengumuman</h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-condensed table-hover table-bordered">
										<thead>
											<tr>
												<th>Nama</th>
												<th>Alamat</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="3" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					@endif
					</div>
				</div>
@stop
@section('footer') 


<script>
    $(document).ready(function() {
        
    });

</script>

@stop
