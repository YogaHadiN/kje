<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-info">
			  <div class="panel-heading">
					<h3 class="panel-title">Pasien {!!$periksa->id!!} - {!! $periksa->pasien->nama !!}</h3>
			  </div>
			 
			  <div class="panel-body">
			  		{!! Form::hidden('periksa_id', $periksa->id)!!}
			  	 <div class="row">
				  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('tanggal_mulai'))has-error @endif">
						    {!! Form::label('tanggal_mulai', 'Tanggal Mulai', ['class' => 'control-label']) !!}
							{!! Form::text('tanggal_mulai', $tanggal_mulai, ['class' => 'form-control tanggal'])!!}
						  @if($errors->has('tanggal_mulai'))<code>{{ $errors->first('tanggal_mulai') }}</code>@endif
						</div>
				  	</div>
				  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('hari'))has-error @endif">
						  {!! Form::label('hari', 'Jumlah Hari', ['class' => 'control-label']) !!}
                            <div class="input-group">
								{!! Form::text('hari', $hari, ['class' => 'form-control', 'aria-describedby' => 'addonTekananDarah', 'dir' =>'rtl'])!!}
                                <span class="input-group-addon" id="addonTekananDarah">Hari</span>
                            </div>
						  @if($errors->has('hari'))<code>{{ $errors->first('hari') }}</code>@endif
						</div>
				  	</div>
				 </div>
				 <div class="row">
				 	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 		{!! Form::submit($submit, ['class' => 'btn btn-primary btn-block'])!!}
				 	</div>
				 	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 		<a href="{!! url('ruangperiksa/'.$periksa->poli) !!}" class="btn btn-warning btn-block">Cancel</a>
				 	</div>
				 </div>
				 @if($delete)
				 <br>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<a href="{!! url('suratsakits/delete/' . $suratsakit->id . '/' . $poli) !!}" class="btn btn-danger btn-lg btn-block" onclick="return confirm('Anda yakin mau menghapus surat sakit unruk {!! $periksa->pasien->nama!!} ?' );return false;">DELETE</a>
						</div>
					</div>
				 @endif
			  </div>
		</div>
	</div>
	@if ($dikasih_dalam_1_bulan_terakhir && $periksa->asuransi_id == '32')
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="alert alert-warning" role="alert">
				<h3>Pasien sudah minta surat sakit sebanyak </h3>
				<h1>{{ $dikasih_dalam_1_bulan_terakhir }} kali</h1>
				<h3>Sejak 60 hari terakhir</h3>
				<h3>Harap selektif dalam memberikan surat keterangan sakit</h3>
			</div>
		</div>
	@endif
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">Riwayat Minta Surat Sakit</h3>
			  </div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-condensed DT">
						<thead>
							<tr>
								<th>Tanggal Izin</th>
								<th>Berapa Hari</th>
								<th>Pemeriksa</th>
								<th>Diagnosa</th>
								<th>Pembayaran</th>
							</tr>
						</thead>
						<tbody>
							@if(count($ss) > 0)
								@foreach($ss as $s)
									<tr>
										<td>{{ App\Models\Classes\Yoga::updateDatePrep(  $s->tanggal_izin  )}}</td>
										<td>{{ $s->jumlah_hari }} hari</td>
										<td>{{ $s->nama_staf }}</td>
										<td>{{ $s->diagnosa }}</td>
										<td>{{ $s->pembayaran }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td class="text-center" colspan="5">Tidak Ada Data Untuk Ditampilkan :p</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		
	</div>
</div>
