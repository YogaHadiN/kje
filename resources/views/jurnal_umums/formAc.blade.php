			  {!! Form::textarea('keterangan' , null, [
				  'class' => 'form-control textareacustom keterangan rq',
				  'onkeyup' => 'acKeyUp("keterangan", this);return false;'
			  ]) !!}
			</div>
		</div>
		<div class="action col-xs-2 col-sm-2 col-md-2 col-lg-2">
			@if( !isset($kedua) )
				<button value="0" class="btn btn-lg btn-primary btn-block tambah" type="button" onclick="tambahAc(this);return false;">Tambah AC</button>
				<button class="btn btn-lg btn-danger btn-block" type="button" onclick="hapusAc(this);return false;">Hapus AC</button>
			@endif
		</div>
	</div>
