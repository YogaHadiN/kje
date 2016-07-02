<div class="row">
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                        {!! Form::label('nama')!!}
                        {!! Form::text('nama', null, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'Ketik nama tanpa gelar'
                        ))!!}
                        <code>{!! $errors->first('nama')!!}</code>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        {!! Form::label('alamat_domisili')!!}
                        {!! Form::textarea('alamat_domisili', null, array(
                            'class'         => 'textareacustom form-control',
                            'placeholder'   => 'Alamat'
                        ))!!}
                        <code>{!! $errors->first('alamat_domisili')!!}</code>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        {!! Form::label('tanggal_lahir')!!}
                        {!! Form::text('tanggal_lahir', $tanggal_lahir, array(
                            'class'         => 'form-control tanggal',
                            'placeholder'   => 'Tanggal Lahir'
                            ))!!}
                            <code>{!! $errors->first('tanggal_lahir')!!}</code>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        {!! Form::label('ktp')!!}
                        {!! Form::text('ktp', null, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'No KTP'
                            ))!!}
                            <code>{!! $errors->first('ktp')!!}</code>
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        {!! Form::label('email')!!}
                        {!! Form::email('email', null, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'email'
                        ))!!}
                        <code>{!! $errors->first('email')!!}</code>
                    </div>
                </div>
                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        {!! Form::label('no_telp')!!}
                        {!! Form::text('no_telp', null, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'Nomor Telepon'
                        ))!!}
                        <code>{!! $errors->first('no_telp')!!}</code>
                    </div>
                </div>
            </div>
     <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
         <div class="form-group">
            {!! Form::label('alamat_ktp')!!}
            {!! Form::textarea('alamat_ktp', null, array(
                'class'         => 'textareacustom form-control',
                'placeholder'   => 'Alamat KTP'
            ))!!}
            <code>{!! $errors->first('alamat_ktp')!!}</code>
        </div>
        </div>
    </div>
  <div class="row">
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
         <div class="form-group">
            {!! Form::label('str')!!}
            {!! Form::text('str', null, array(
                'class'         => 'form-control',
                'placeholder'   => 'STR'
            ))!!}
            <code>{!! $errors->first('str')!!}</code>
        </div>
    </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
         <div class="form-group">
            {!! Form::label('universitas_asal')!!}
            {!! Form::text('universitas_asal', null, array(
                'class'         => 'form-control',
                'placeholder'   => 'Universitas Asal'
            ))!!}
            <code>{!! $errors->first('universitas_asal')!!}</code>
        </div>
    </div>
</div>
  <div class="row">
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
         <div class="form-group">
            {!! Form::label('titel')!!}
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
            <code>{!! $errors->first('titel')!!}</code>
        </div>
    </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
         <div class="form-group">
            {!! Form::label('no_hp')!!}
            {!! Form::text('no_hp', null, array(
                'class'         => 'form-control',
                'placeholder'   => 'Nomor HP'
            ))!!}
            <code>{!! $errors->first('no_hp')!!}</code>
        </div>
    </div>
</div>
  <div class="row">
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
         <div class="form-group">
            {!! Form::label('tanggal_lulus')!!}
            {!! Form::text('tanggal_lulus', $tanggal_lulus, array(
                'class'         => 'form-control tanggal',
                'placeholder'   => 'Tanggal Lulus'
            ))!!}
            <code>{!! $errors->first('tanggal_lulus')!!}</code>
        </div>
    </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
         <div class="form-group">
            {!! Form::label('tanggal_mulai')!!}
            {!! Form::text('tanggal_mulai', $tanggal_mulai, array(
                'class'         => 'form-control tanggal',
                'placeholder'   => 'Tanggal Mulai'
            ))!!}
            <code>{!! $errors->first('tanggal_mulai')!!}</code>
        </div>
    </div>
</div>
</div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @include('antrianpolis.webcamForm', [
        'image'     => $image, 
        'ktp_image' => $ktp_image,
        'subject'   => 'Staf'
        ])  
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


