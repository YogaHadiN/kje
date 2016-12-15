<div class="row">
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group @if($errors->has('nama'))has-error @endif">
					  {!! Form::label('nama', 'Nama', ['class' => 'control-label']) !!}
                        {!! Form::text('nama', null, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'Ketik nama tanpa gelar'
                        ))!!}
					  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
					</div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group @if($errors->has('alamat_domisili'))has-error @endif">
					  {!! Form::label('alamat_domisili', 'Alamat Domisili', ['class' => 'control-label']) !!}
                        {!! Form::textarea('alamat_domisili', null, array(
                            'class'         => 'textareacustom form-control',
                            'placeholder'   => 'Alamat'
                        ))!!}
					  @if($errors->has('alamat_domisili'))<code>{{ $errors->first('alamat_domisili') }}</code>@endif
					</div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group @if($errors->has('tanggal_lahir'))has-error @endif">
					  {!! Form::label('tanggal_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
                        {!! Form::text('tanggal_lahir', $tanggal_lahir, array(
                            'class'         => 'form-control tanggal',
                            'placeholder'   => 'Tanggal Lahir'
                            ))!!}
					  @if($errors->has('tanggal_lahir'))<code>{{ $errors->first('tanggal_lahir') }}</code>@endif
					</div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group @if($errors->has('ktp'))has-error @endif">
					  {!! Form::label('ktp', 'KTP', ['class' => 'control-label']) !!}
                        {!! Form::text('ktp', null, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'No KTP'
						))!!}
					  @if($errors->has('ktp'))<code>{{ $errors->first('ktp') }}</code>@endif
					</div>
                </div>
            </div>
            <div class="row">
                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					 <div class="form-group @if($errors->has('email'))has-error @endif">
					   {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                        {!! Form::email('email', null, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'email'
                        ))!!}
					   @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
					 </div>
                </div>
                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					 <div class="form-group @if($errors->has('no_telp'))has-error @endif">
					   {!! Form::label('no_telp', 'No Telp', ['class' => 'control-label']) !!}
                        {!! Form::text('no_telp', null, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'Nomor Telepon'
                        ))!!}
					   @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
					 </div>
                </div>
            </div>
     <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			 <div class="form-group @if($errors->has('alamat_ktp'))has-error @endif">
			   {!! Form::label('alamat_ktp', 'Alamat KTP', ['class' => 'control-label']) !!}
				{!! Form::textarea('alamat_ktp', null, array(
					'class'         => 'textareacustom form-control',
					'placeholder'   => 'Alamat KTP'
				))!!}
			   @if($errors->has('alamat_ktp'))<code>{{ $errors->first('alamat_ktp') }}</code>@endif
			 </div>
        </div>
    </div>
  <div class="row">
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		 <div class="form-group @if($errors->has('str'))has-error @endif">
		   {!! Form::label('str', 'STR', ['class' => 'control-label']) !!}
            {!! Form::text('str', null, array(
                'class'         => 'form-control',
                'placeholder'   => 'STR'
            ))!!}
		   @if($errors->has('str'))<code>{{ $errors->first('str') }}</code>@endif
		 </div>
    </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		 <div class="form-group @if($errors->has('universitas_asal'))has-error @endif">
		   {!! Form::label('universitas_asal', 'Universitas Asal', ['class' => 'control-label']) !!}
            {!! Form::text('universitas_asal', null, array(
                'class'         => 'form-control',
                'placeholder'   => 'Universitas Asal'
            ))!!}
		   @if($errors->has('universitas_asal'))<code>{{ $errors->first('universitas_asal') }}</code>@endif
		 </div>
    </div>
</div>
  <div class="row">
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		 <div class="form-group @if($errors->has('titel'))has-error @endif">
		   {!! Form::label('titel', 'Titel', ['class' => 'control-label']) !!}
            {!! Form::select('titel', array(
                ''      =>   '(tidak ada titel)',
                'dr'    => 'Dokter',
                'drg'   => 'Dokter Gigi',
                'bd'    => 'Bidan',
                'ns'    => 'Perawat'
                ), null, array(
                'class'         => 'form-control',
                'placeholder'   => 'Titel'
            ))!!}
		   @if($errors->has('titel'))<code>{{ $errors->first('titel') }}</code>@endif
		 </div>
    </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		 <div class="form-group @if($errors->has('no_hp'))has-error @endif">
		   {!! Form::label('no_hp', 'No HP', ['class' => 'control-label']) !!}
            {!! Form::text('no_hp', null, array(
                'class'         => 'form-control',
                'placeholder'   => 'Nomor HP'
            ))!!}
		   @if($errors->has('no_hp'))<code>{{ $errors->first('no_hp') }}</code>@endif
		 </div>
    </div>
</div>
  <div class="row">
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		 <div class="form-group @if($errors->has('tanggal_lulus'))has-error @endif">
		   {!! Form::label('tanggal_lulus', 'Tanggal Lulus', ['class' => 'control-label']) !!}
            {!! Form::text('tanggal_lulus', $tanggal_lulus, array(
                'class'         => 'form-control tanggal',
                'placeholder'   => 'Tanggal Lulus'
            ))!!}
		   @if($errors->has('tanggal_lulus'))<code>{{ $errors->first('tanggal_lulus') }}</code>@endif
		 </div>
    </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		 <div class="form-group @if($errors->has('tanggal_mulai'))has-error @endif">
		   {!! Form::label('tanggal_mulai', 'Tanggal Mulai', ['class' => 'control-label']) !!}
            {!! Form::text('tanggal_mulai', $tanggal_mulai, array(
                'class'         => 'form-control tanggal',
                'placeholder'   => 'Tanggal Mulai'
            ))!!}
		   @if($errors->has('tanggal_mulai'))<code>{{ $errors->first('tanggal_mulai') }}</code>@endif
		 </div>
    </div>
</div>
@if( \Auth::id() == '28' )
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Daftar Gaji</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Periode</th>
									<th>Gaji Pokok</th>
									<th>Bonus</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								@if($staf->gaji->count() > 0)
									@foreach($staf->gaji as $gaji)
										<tr>
											<td>{{ $gaji->tanggal_dibayar->format('d-m-Y') }}</td>
											<td class="text-right">{{ $gaji->mulai->format('M-Y') }}</td>
											<td class="text-right">{{ App\Classes\Yoga::buatrp($gaji->gaji_pokok )}}</td>
											<td class="text-right">{{ App\Classes\Yoga::buatrp($gaji->bonus) }}</td>
											<td class="text-right strong">{{ App\Classes\Yoga::buatrp($gaji->bonus + $gaji->gaji_pokok ) }}</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td class="text-center" colspan="">Tidak Ada Data Untuk Ditampilkan :p</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
			
			
		</div>
	</div>
	
@endif
</div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				@include('antrianpolis.webcamForm', [
				'image'     => $image, 
				'ktp_image' => $ktp_image,
				'subject'   => 'Staf'
				])  
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group{{ $errors->has('ktp_image') ? ' has-error' : '' }}">
					{!! Form::label('ktp_image', 'Upload Gambar KTP') !!}
					{!! Form::file('ktp_image') !!}
						@if (isset($staf) && $staf->ktp_image)
							<p> {!! HTML::image(asset($staf->ktp_image), null, ['class'=>'img-rounded upload']) !!} </p>
						@else
							<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
						@endif
					{!! $errors->first('ktp_image', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group{{ $errors->has('str_image') ? ' has-error' : '' }}">
					{!! Form::label('str_image', 'Upload Gambar STR') !!}
					{!! Form::file('str_image') !!}
						@if (isset($staf) && $staf->str_image)
							<p> {!! HTML::image(asset($staf->str_image), null, ['class'=>'img-rounded upload']) !!} </p>
						@else
							<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
						@endif
					{!! $errors->first('str_image', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group{{ $errors->has('sip_image') ? ' has-error' : '' }}">
					{!! Form::label('sip_image', 'Upload Gambar SIP') !!}
					{!! Form::file('sip_image') !!}
						@if (isset($staf) && $staf->sip_image)
							<p> {!! HTML::image(asset($staf->sip_image), null, ['class'=>'img-rounded upload']) !!} </p>
						@else
							<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
						@endif
					{!! $errors->first('sip_image', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>
    </div>
</div>
<div class="row">
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            {!! Form::submit('submit', array(
                'class' => 'btn btn-primary block full-width m-b'
            )) !!}
        </div>
    </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            {!! HTML::link('stafs', 'Cancel', ['class' => 'btn btn-warning btn-block'])!!}
        </div>
    </div>
</div>
 </div>


