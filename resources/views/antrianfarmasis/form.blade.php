<div class="row">
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group @if($errors->has('nama'))has-error @endif">
					  {!! Form::label('nama', 'Nama', ['class' => 'control-label']) !!}
                        {!! Form::text('nama', null, array(
                            'class'         => 'form-control rq',
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
                            'class'         => 'textareacustom form-control rq',
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
                      @if (isset($staf) && !empty( $staf->tanggal_lahir ))
                          {!! Form::text('tanggal_lahir', $staf->tanggal_lahir->format('d-m-Y'), ['class' => 'form-control tanggal', 'id' => 'tanggal_lahir'])!!}
                      @else
                          {!! Form::text('tanggal_lahir', null, ['class' => 'form-control tanggal rq', 'id' => 'tanggal_lahir'])!!}
                      @endif
					  @if($errors->has('tanggal_lahir'))<code>{{ $errors->first('tanggal_lahir') }}</code>@endif
					</div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group @if($errors->has('ktp'))has-error @endif">
					  {!! Form::label('ktp', 'KTP', ['class' => 'control-label']) !!}
                        {!! Form::text('ktp', null, array(
                            'class'         => 'form-control rq',
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
					   {!! Form::label('no_telp', 'No Telp Rumah', ['class' => 'control-label']) !!}
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
		   {!! Form::label('str', 'Nomor STR', ['class' => 'control-label']) !!}
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
                '-'    => 'Tidak ada Titel',
                'dr'    => 'Dokter',
                'drg'   => 'Dokter Gigi',
                'bd'    => 'Bidan',
                'ns'    => 'Perawat'
                ), null, array(
                'class'         => 'form-control rq',
                'placeholder'   => 'Pilih Titel'
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
          @if (isset($staf) && !empty( $staf->tanggal_lulus ))
              {!! Form::text('tanggal_lulus', $staf->tanggal_lulus->format('d-m-Y'), array( 'class'         => 'form-control tanggal', 'placeholder'   => 'Tanggal Lulus'))!!}
          @else
              {!! Form::text('tanggal_lulus', null, ['class' => 'form-control tanggal', 'id' => 'tanggal_lulus'])!!}
          @endif
		   @if($errors->has('tanggal_lulus'))<code>{{ $errors->first('tanggal_lulus') }}</code>@endif
		 </div>
    </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		 <div class="form-group @if($errors->has('tanggal_mulai'))has-error @endif">
		   {!! Form::label('tanggal_mulai', 'Tanggal Mulai', ['class' => 'control-label']) !!}
          @if (isset($staf) && !empty( $staf->tanggal_mulai ))
            {!! Form::text('tanggal_mulai', $staf->tanggal_mulai->format('d-m-Y'), array( 'class'         => 'form-control tanggal', 'placeholder'   => 'Tanggal Mulai'))!!}
          @else
              {!! Form::text('tanggal_mulai', null, ['class' => 'form-control tanggal', 'id' => 'tanggal_mulai'])!!}
          @endif
		   @if($errors->has('tanggal_mulai'))<code>{{ $errors->first('tanggal_mulai') }}</code>@endif
		 </div>
    </div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('menikah'))has-error @endif">
			{!! Form::label('menikah', 'Status Pernikahan', ['class' => 'control-label']) !!}
			{!! Form::select('menikah', App\Models\Classes\Yoga::statusMenikahList(), null, array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('menikah'))<code>{{ $errors->first('menikah') }}</code>@endif
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('jumlah_anak'))has-error @endif">
			{!! Form::label('jumlah_anak', 'Jumlah Anak', ['class' => 'control-label']) !!}
			{!! Form::text('jumlah_anak', null, array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('jumlah_anak'))<code>{{ $errors->first('jumlah_anak') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('no_npwp'))has-error @endif">
			{!! Form::label('npwp', 'Nomor NPWP', ['class' => 'control-label']) !!}
			{!! Form::text('npwp', null, array(
				'class'         => 'form-control'
			))!!}
		  @if($errors->has('no_npwp'))<code>{{ $errors->first('no_npwp') }}</code>@endif
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('jenis_kelamin'))has-error @endif">
			{!! Form::label('jenis_kelamin', 'Jenis Kelamin', ['class' => 'control-label']) !!}
			{!! Form::select('jenis_kelamin', App\Models\Classes\Yoga::jenisKelaminList(), null, array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('jenis_kelamin'))<code>{{ $errors->first('jenis_kelamin') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group @if($errors->has('sip'))has-error @endif">
                {!! Form::label('sip', 'Nomor SIP', ['class' => 'control-label']) !!}
            {!! Form::text('sip',  null, array(
                'class'         => 'form-control'
            ))!!}
                @if($errors->has('sip'))<code>{{ $errors->first('sip') }}</code>@endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group @if($errors->has('nomor_rekening'))has-error @endif">
                {!! Form::label('nomor_rekening', 'Nomor Rekening', ['class' => 'control-label']) !!}
            {!! Form::text('nomor_rekening',  null, array(
                'class'         => 'form-control'
            ))!!}
                @if($errors->has('nomor_rekening'))<code>{{ $errors->first('nomor_rekening') }}</code>@endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group @if($errors->has('bank')) has-error @endif">
          {!! Form::label('bank', 'Bank', ['class' => 'control-label']) !!}
          {!! Form::text('bank' , null, ['class' => 'form-control']) !!}
          @if($errors->has('bank'))<code>{{ $errors->first('bank') }}</code>@endif
        </div>    
    </div>
</div>
{{-- @if( isset($staf) ) --}}
{{-- 	@include('asuransis.upload', ['asuransi' => $staf, 'models' => 'stafs', 'folder' => 'staf']) --}}
{{-- @endif --}}
@if( \Auth::user()->id == '28' && isset( $staf ) )
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
											<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($gaji->gaji_pokok )}}</td>
											<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($gaji->bonus) }}</td>
											<td class="text-right strong">{{ App\Models\Classes\Yoga::buatrp($gaji->bonus + $gaji->gaji_pokok ) }}</td>
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
@endif
</div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
					{!! Form::label('image', 'Upload Pas Foto') !!}
					{!! Form::file('image') !!}
						@if (isset($staf) && $staf->image)
                            <p> <img src="{{ \Storage::disk('s3')->url($staf->image) }}" alt="" class="img-rounded upload"> </p>
						@else
                            <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
						@endif
					{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group{{ $errors->has('ktp_image') ? ' has-error' : '' }}">
					{!! Form::label('ktp_image', 'Upload Gambar KTP') !!}
					{!! Form::file('ktp_image') !!}
						@if (isset($staf) && $staf->ktp_image)
                            <p> <img src="{{ \Storage::disk('s3')->url($staf->ktp_image) }}" alt="" class="img-rounded upload"> </p>
						@else
                            <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
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
                            <p> <img src="{{ \Storage::disk('s3')->url($staf->str_image) }}" alt="" class="img-rounded upload"> </p>
						@else
                            <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
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
                            <p> <img src="{{ \Storage::disk('s3')->url($staf->sip_image) }}" alt="" class="img-rounded upload"> </p>
						@else
                            <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
						@endif
					{!! $errors->first('sip_image', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group{{ $errors->has('gambar_npwp') ? ' has-error' : '' }}">
					{!! Form::label('gambar_npwp', 'Upload Gambar Kartu NPWP') !!}
					{!! Form::file('gambar_npwp') !!}
						@if (isset($staf) && $staf->gambar_npwp)
                            <p> <img src="{{ \Storage::disk('s3')->url($staf->gambar_npwp) }}" alt="" class="img-rounded upload"> </p>
						@else
                            <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
						@endif
					{!! $errors->first('gambar_npwp', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group{{ $errors->has('kartu_keluarga') ? ' has-error' : '' }}">
					{!! Form::label('kartu_keluarga', 'Upload Gambar Kartu Keluarga') !!}
					{!! Form::file('kartu_keluarga') !!}
						@if (isset($staf) && $staf->kartu_keluarga)
                            <p> <img src="{{ \Storage::disk('s3')->url($staf->kartu_keluarga) }}" alt="" class="img-rounded upload"> </p>
						@else
                            <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
						@endif
					{!! $errors->first('kartu_keluarga', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		</div>
    </div>
</div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            @if(isset($staf))
                <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
            @else
                <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
            @endif
            {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <a class="btn btn-danger btn-block" href="{{ url('stafs') }}">Cancel</a>
        </div>
    </div>
 </div>
<script type="text/javascript" charset="utf-8">
    function dummySubmit(control){
        if(validatePass2(control)){
            $('#submit').click();
        }
    }
</script>
