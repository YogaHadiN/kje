<div class="form-group">
    {!! Form::label('nama')!!}
    {!! Form::text('nama', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'nama'
    ))!!}
    <code>{!! $errors->first('nama')!!}</code>
</div>

<div class="form-group">
    {!! Form::label('alamat')!!}
    {!! Form::textarea('alamat', null, array(
        'class'         => 'form-control textareacustom',
        'placeholder'   => 'alamat'
    ))!!}
    <code>{!! $errors->first('alamat')!!}</code>
</div>
<div class="form-group">
    {!! Form::label('no_telp')!!}
    {!! Form::text('no_telp', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'Nomor Telepon'
    ))!!}
    <code>{!! $errors->first('no_telp')!!}</code>
</div>
<div class="form-group">
    {!! Form::label('hp_pic')!!}
    {!! Form::text('hp_pic', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'Nomor HP PIC'
    ))!!}
    <code>{!! $errors->first('hp_pic')!!}</code>
</div>
<div class="form-group">
    {!! Form::label('pic')!!}
    {!! Form::text('pic', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'Person In Charge'
    ))!!}
    <code>{!! $errors->first('pic')!!}</code>
</div>

<div class="form-group">
    {!! Form::submit($submit, array(
        'class' => 'btn btn-primary block full-width m-b'
    )) !!}
</div>