<div class="form-group">
    {!! Form::label('nama')!!}
    {!! Form::text('nama', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'nama'
    ))!!}
    @if ($errors->has('nama'))
        <code>{!! $errors->first('nama')!!}</code>
    @endif
</div>

<div class="form-group">
    {!! Form::label('alamat')!!}
    {!! Form::textarea('alamat', null, array(
        'class'         => 'form-control textareacustom',
        'placeholder'   => 'alamat'
    ))!!}
    @if ($errors->has('alamat'))
        <code>{!! $errors->first('alamat')!!}</code>
    @endif
</div>
<div class="form-group">
    {!! Form::label('no_telp')!!}
    {!! Form::text('no_telp', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'Nomor Telepon'
    ))!!}
    @if ($errors->has('no_telp'))
        <code>{!! $errors->first('no_telp')!!}</code>
    @endif
</div>
<div class="form-group">
    {!! Form::label('hp_pic')!!}
    {!! Form::text('hp_pic', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'Nomor HP PIC'
    ))!!}
    @if ($errors->has('hp_pic'))
        <code>{!! $errors->first('hp_pic')!!}</code>
    @endif
</div>
<div class="form-group">
    {!! Form::label('pic')!!}
    {!! Form::text('pic', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'Person In Charge'
    ))!!}
    @if ($errors->has('pic'))
        <code>{!! $errors->first('pic')!!}</code>
    @endif
</div>
<div class="form-group">
    {!! Form::submit($submit, array(
        'class' => 'btn btn-primary block full-width m-b'
    )) !!}
</div>
