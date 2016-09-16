<div class="panel panel-defaulr">
	<div class="panel-body">
		<div class="row hide">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">

				<div class="form-group @if($errors->has('email'))has-error @endif">
				{!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
				  {!! Form::text('email' , $user->getEmail(), ['class' => 'form-control']) !!}
				  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row hide">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">

				<div class="form-group @if($errors->has('facebook_id'))has-error @endif">
				{!! Form::label('facebook_id', 'Facebook Id', ['class' => 'control-label']) !!}
				  {!! Form::text('facebook_id' , $user->getId(), ['class' => 'form-control']) !!}
				  @if($errors->has('facebook_id'))<code>{{ $errors->first('facebook_id') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="form-group @if($errors->has('nama'))has-error @endif">
				{!! Form::label('nama', 'Nama Sesuai KTP', ['class' => 'control-label']) !!}
				  {!! Form::text('nama' , $user->getName(), ['class' => 'form-control rq']) !!}
				  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="form-group @if($errors->has('pernah_berobat'))has-error @endif">
				{!! Form::label('pernah_berobat', 'Apa Pasien Pernah Berobat disini sebelumnya?', ['class' => 'control-label']) !!}
				  {!! Form::select('pernah_berobat', $pernah_berobat , null, ['class' => 'form-control rq']) !!}
				  @if($errors->has('pernah_berobat'))<code>{{ $errors->first('pernah_berobat') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<label>Tanggal Lahir</label>
				<div class="row">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

						<div class="form-group @if($errors->has('tanggal'))has-error @endif">
						  {!! Form::label('tanggal', 'Tanggal', ['class' => 'hide control-label']) !!}
						  {!! Form::select('date', $date , App\Classes\Yoga::getDayFromFacebook($birthday), ['class' => 'form-control angka selectpick']) !!}
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

						<div class="form-group @if($errors->has('bulan'))has-error @endif">
						  {!! Form::label('bulan', 'Bulan', ['class' => 'hide control-label']) !!}
						  {!! Form::select('month', $month , App\Classes\Yoga::getMonthFromFacebook($birthday), ['class' => 'form-control selectpick angka']) !!}
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<div class="form-group @if($errors->has('tahun'))has-error @endif">
						  {!! Form::label('tahun', 'Tahun', ['class' => 'hide']) !!}
						  {!! Form::select('year', $year , App\Classes\Yoga::getYearFromFacebook($birthday), ['class' => 'form-control angka']) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group @if($errors->has('no_hp'))has-error @endif">
					{!! Form::label('no_hp', 'Nomor Handphone', ['class' => 'control-label']) !!}
				    {!! Form::text('no_hp' , null, ['class' => 'form-control rq']) !!}
				  @if($errors->has('no_hp'))<code>{{ $errors->first('no_hp') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="form-group @if($errors->has('alamat'))has-error @endif">
				{!! Form::label('alamat', 'Alamat Lengkap', ['class' => 'control-label']) !!}
				  {!! Form::textarea('alamat' , null, ['class' => 'form-control textareacustom rq']) !!}
				  @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="form-group @if($errors->has('poli'))has-error @endif">
				{!! Form::label('poli', 'Mau ke Dokter Apa ? ', ['class' => 'control-label']) !!}
				  {!! Form::select('poli' , $polis, null, ['class' => 'form-control rq']) !!}
				  @if($errors->has('poli'))<code>{{ $errors->first('poli') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="form-group @if($errors->has('pembayaran'))has-error @endif">
				{!! Form::label('pembayaran', 'Biaya Pribadi atau Asuransi ? ', ['class' => 'control-label']) !!}
				  {!! Form::select('pembayaran' , $pembayarans, null, ['class' => 'form-control rq']) !!}
				  @if($errors->has('pembayaran'))<code>{{ $errors->first('pembayaran') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group">
					<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit(); return false;">Submit</button>
					{!! Form::submit('submit', ['class' => 'btn btn-success btn-block btn-lg hide', 'id' => 'submit']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
