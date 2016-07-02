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
						<div class="form-group">
							<label for="">Tanggal Mulai</label>
							{!! Form::text('tanggal_mulai', $tanggal_mulai, ['class' => 'form-control tanggal'])!!}
						</div>
				  	</div>
				  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="">Jumlah Hari</label>
                            <div class="input-group">
								{!! Form::text('hari', $hari, ['class' => 'form-control', 'aria-describedby' => 'addonTekananDarah', 'dir' =>'rtl'])!!}
                                <span class="input-group-addon" id="addonTekananDarah">Hari</span>
                            </div>
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
							<a href="{!! url('suratsakits/delete/' . $suratsakit->id) !!}" class="btn btn-danger btn-lg btn-block" onclick="return confirm('Anda yakin mau menghapus surat sakit unruk {!! $periksa->pasien->nama!!} ?' );return false;">DELETE</a>
						</div>
					</div>
				 @endif
			  </div>
		</div>
	</div>
</div>