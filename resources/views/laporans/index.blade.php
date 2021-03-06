@extends('layout.master')

@section('title') 
Klinik Jati Elok | Home

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
<div class="row hide">
            <div class="col-lg-3">
                <a href="{{ url('antrianpolis')}}">
                <div class="widget style1 blue-bg btn-success">
                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <i class="fa fa-laptop fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Nurse Station </span>
                                <h2 class="font-bold">{!! $nursestation->count() !!}</h2>
                            </div>
                        </div>
                </div></a>
            </div>
            <div class="col-lg-3">
                <a href="{{ url('antriankasirs')}}">
                <div class="widget style1 lazur-bg btn-info">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-calculator fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Antrian Kasir </span>
                            <h2 class="font-bold">{!! $antriankasir->count() !!}</h2>
                        </div>
                    </div>
                </div></a>
            </div>
            <div class="col-lg-3">
                <a href="{{ url('fakturbelanjas')}}">
                <div class="widget style1 yellow-bg btn-warning">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Antrian Belanja </span>
                            <h2 class="font-bold">{!! $antrianbelanja !!}</h2>
                        </div>
                    </div>
                </div></a>
            </div>
            <div class="col-lg-3">
                <a href="{{ url('pasiens')}}">
                <div class="widget style1 btn-primary">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-group fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Semua Pasien </span>
                            <h2 class="font-bold">{!! App\Pasien::count() !!}</h2>
                        </div>
                    </div>
                </div></a>
            </div>
        </div>
<div class="row hide">
    <div class="col-lg-3">
        <a href="{{ url('ruangperiksa/umum')}}">
        <div class="widget style1grey-bg btn-success">
                <div class="row">
                    <div class="col-xs-4 text-center">
                    <i class="fa fa-user-md fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> Poli Umum </span>
                        <h2 class="font-bold">{!! count($umum) !!}</h2>
                    </div>
                </div>
        </div></a>
    </div>
    <div class="col-lg-3">
        <a href="{{ url('ruangperiksa/kandungan')}}">
        <div class="widget style1grey-bg btn-primary">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-user-md fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Poli Kandungan </span>
                    <h2 class="font-bold">{!! count($kandungan) !!}</h2>
                </div>
            </div>
        </div></a>
    </div>
    <div class="col-lg-3">
        <a href="{{ url('ruangperiksa/gigi')}}">
        <div class="widget style1 grey-bg btn-info">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-user-md fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Poli Gigi </span>
                    <h2 class="font-bold">{!! count($gigi) !!}</h2>
                </div>
            </div>
        </div></a>
    </div>
    <div class="col-lg-3">
        <a href="{{ url('ruangperiksa/darurat')}}">
        <div class="widget style1 grey-bg btn-danger">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-user-md fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Gawat Darurat </span>
                    <h2 class="font-bold">{!! count($darurat) !!}</h2>
                </div>
            </div>
        </div></a>
    </div>
</div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                            RINGKASAN PASIEN HARI INI 
                    </div>
                    <div class="panel-body">
						<div class="table-responsive">
							<table class="table table-condensed table-hover">
							  <thead>
								  <tr>
									  <th>Nama Asuransi</th>
									  <th>Jumlah</th>
									  @foreach($polis as $poli)	
										  <th>{{ $poli }}</th>
									  @endforeach
								  </tr>
							  </thead>
							  <tbody>
								  @if (count($hariinis) > 0)
									  @foreach ($hariinis as $hariini)
										  <tr>
											  <td>{!! $hariini->nama !!}</td>
											  <th>{!! $hariini->jumlah !!}</th>
											  @foreach($polis as $poli)	
												  <td class="text-center">{{ App\Classes\Yoga::periksa_by_asuransi($tanggal, $hariini->id, $poli) }}</td>
											  @endforeach
										  </tr>
									  @endforeach
								  @else
									  <tr>
										  <td colspan="2" class="text-center">Tidak ada data untuk ditampilkan :p</td>
									  </tr>
								  @endif
							  </tbody>
							  <tfoot>
								  <th> Jumlah </th>
								  <th>{!! count($periksas) !!}</th>
								  @foreach($polis as $poli)	
									  <th class="text-center">{{ App\Classes\Yoga::periksa_by_poli($tanggal, $poli) }}</th>
								  @endforeach
							  </tfoot>
						  </table>
						</div>
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
					<table class="table table-condensed text-center">
						<tbody>
							<tr>
								<td><h3>Angka Kontak Saat ini</h3></td>
								<td><h3>Pengantar belum disubmit</h3></td>
								<td><h3>SMS belum disubmit</h3></td>
								<td><h3>Kunjungan sakit belum disubmit</h3></td>
							</tr>
							<tr>
								<td><h1> {{ $angka_kontak_saat_ini }} </h1></td>
								<td><h1> <a class="" href="{{ url('laporans/pengantar?bulanTahun='. date('m-Y')) }}">{{ $pengantar_belum_disubmit }}</a> </h1></td>
								<td><h1> <a class="" href="{{ url('laporans/sms/bpjs?bulanTahun='. date('m-Y')) }}">{{ $sms_belum_di_submit }}</a> </h1></td>
								<td><h1> <a class="" href="{{ url('laporans/bpjs_tidak_terpakai?bulanTahun='. date('m-Y')) }}">{{ $kunjungan_sakit_belum_di_submit }}</a> </h1></td>
								<td><h1></h1></td>
							</tr>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="alert alert-danger">
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
			<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					@if ($auth->role != '1')
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
													<td colspan="2">Laporan STATUS</td>
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
												<td> {!! Form::select('id', App\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search'=> 'true']) !!} </td>
												<td> {!! Form::text('mulai', date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'mulai'])!!}</td>
												<td> {!! Form::text('akhir',  date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'akhir'])!!}</td>
												{!! Form::close() !!}
											</tr> 
											<tr>
												{!! Form::open(['url'=>'laporans/pembayaran/dokter', 'method'=> 'get']) !!} 
												<td><input type="submit" class="btn btn-primary btn-sm" value="submit"/></td>
												<td>Laporan Pembayaran Dokter </td>
												<td></td>
												<td> {!! Form::text('mulai', date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'mulai'])!!}</td>
												<td> {!! Form::text('akhir',  date('d-m-Y'), ['class' => 'form-control tanggal', 'placeholder' => 'akhir'])!!}</td>
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
												</form>
												<tr><form action="{{ url('laporans/jumlahDiare') }}" method="get">
														<td><input type="submit" class="btn btn-primary btn-sm" value="submit" name="submit"/></td>
														<td>Laporan Jumlah Pasien Diare</td>
														<td>
															{!! Form::select('asuransi_id', $asuransis, '%', ['data-live-search' => 'true', 'class' => 'form-control selectpick'])!!}
														</td>
														<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="mulai" placeholder="mulai"/>
															<td><input value="{{ date('d-m-Y') }}" type="text" class="form-control tanggal" name="akhir" placeholder="akhir"/>
													</form></tr>
											</tr>
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
