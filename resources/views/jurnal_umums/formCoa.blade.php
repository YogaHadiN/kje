	@if(!$kedua)

	<div class="panel panel-info">
		<div class="panel-body">
			<p>
			<strong>Kelompok 1: ( 4 tahun )</strong> Aset yang digunakan untuk operasional lembaga dengan masa pakai maksimum 4 tahun. Termasuk dalam kelompok ini misalnya:

			Mesin kantor seperti mesin tik, mesin hitung duplikator, mesin fotokopi, mesin akunting/pembukuan, komputer, printer, scanner, dan sejenisnya.
			Perlengkapan lainnya seperti amplifer, tape/cassette, video recorder, televisi dan sejenisnya.
			Sepeda motor, sepeda.
			Alat komunikasi, pesawat telepon, fax, handphone, dan sejenisnya.
			Alat perlengkapan khusus bagi industri/jasa yang bersangkutan.
			</p>

		<p>
		<strong>Kelompok 2: ( 8 tahun )</strong> Aset yang digunakan untuk operasional lembaga dengan masa pakai maksimum 8 tahun. Termasuk dalam kelompok ini misalnya:

		Mebel dan peralatan dari logam termasuk meja, bangku, kursi, lemari, dan sejenisnya yang bukan merupakan bagian dari bangunan, alat pengatur udara seperti AC, kipas angin, dan sejenisnya.
		Mobil, bus, truk, speed boat, dan sejenisnya.

		</p>
		<p>
		<strong>Kelompok 3: ( 10 tahun )</strong> Kelompok bangunan tidak permanen 10 tahun.
		</p>
		<p>
		<strong>Kelompok 4: ( 20 tahun )</strong> Kelompok bangunan permanen dianggap sama saja yaitu usia pakainya 20 tahun .
		</p>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group @if($errors->has('nomor_faktur'))has-error @endif">
			  {!! Form::label('nomor_faktur', 'Nomor Faktur', ['class' => 'control-label']) !!}
			  {!! Form::text('nomor_faktur' , null, [
				  'class' => 'form-control nomor_faktur',
				  'onkeyup'=> 'nomorFakturKeyup(this);return false;'
			  ]) !!}
			  @if($errors->has('nomor_faktur'))<code>{{ $errors->first('nomor_faktur') }}</code>@endif
			</div>
		</div>
	</div>
	@endif
	<div class="row rowAlat">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<div class="form-group @if($errors->has('peralatan'))has-error @endif">
			@if( !$kedua )
				  {!! Form::label('peralatan', null, ['class' => 'control-label']) !!}
			  @endif
			  {!! Form::text('peralatan' , null, [
				  'class' => 'form-control peralatan',
				  'onkeyup' => 'alatKeyUp("peralatan", this);return false;'
			  ]) !!}
			  @if($errors->has('peralatan'))<code>{{ $errors->first('peralatan') }}</code>@endif
			</div>
		</div>
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
			<div class="form-group @if($errors->has('harga_satuan'))has-error @endif">
			@if( !$kedua )
				{!! Form::label('harga_satuan', null, [
					'class' => 'control-label',
					'onkeyup' => 'alatK'
				]) !!}
			  @endif
			  {!! Form::text('harga_satuan' , null, [
				  'class' => 'form-control uangInputIni harga_satuan',
				  'onkeyup' => 'alatKeyUp("harga_satuan", this);return false;'
			  ]) !!}
			  @if($errors->has('harga_satuan'))<code>{{ $errors->first('harga_satuan') }}</code>@endif
			</div>
		</div>
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
			<div class="form-group @if($errors->has('jumlah'))has-error @endif">
			@if( !$kedua )
				  {!! Form::label('jumlah', null, ['class' => 'control-label']) !!}
			  @endif
			  {!! Form::text('jumlah' , null, [
				  'class' => 'form-control angka jumlah',
				  'onkeyup' => 'alatKeyUp("jumlah", this);return false;'
			  ]) !!}
			  @if($errors->has('jumlah'))<code>{{ $errors->first('jumlah') }}</code>@endif
			</div>
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<div class="form-group @if($errors->has('masa_pakai'))has-error @endif">
			@if( !$kedua )
				  {!! Form::label('masa_pakai', 'Golongan Penyusutan', ['class' => 'control-label masa_pakai']) !!}
			  @endif

			  {!! Form::select('masa_pakai' , App\Models\Classes\Yoga::masaPakai(), null, [
				  'class'    => 'form-control masa_pakai',
				  'disabled'    => 'disabled',
				  'onchange' => 'masaPakaiOnChange(this);return false;'
			  ]) !!}

			  @if($errors->has('masa_pakai'))<code>{{ $errors->first('masa_pakai') }}</code>@endif
			</div>
		</div>
		<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 alat-action">
			<div class="form-group">
				@if( !$kedua )
				  {!! Form::label('', '', ['class' => 'control-label']) !!}
				@endif
				  <div class="input-group nowrap">
					<button class="btn btn-primary key" value="0" type="button" onclick="tambahAlat(this);return false;"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
					<button class="btn btn-danger hide" type="button" onclick="kurangAlat(this);return false;"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button>
				  </div>
			</div>
		</div>
	</div>

