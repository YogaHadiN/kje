<div class="form-group">
    {!! Form::label('nama')!!}
    {!! Form::text('nama', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'nama',
        'id'   => 'nama_perujuk'
    ))!!}
    <code>{!! $errors->first('nama')!!}</code>
</div>

<div class="form-group">
    {!! Form::label('alamat')!!}
    {!! Form::textarea('alamat', null, array(
        'class'         => 'form-control textareacustom',
        'placeholder'   => 'alamat',
        'id'        => 'alamat_perujuk'
    ))!!}
    <code>{!! $errors->first('alamat')!!}</code>
</div>
<div class="form-group">
    {!! Form::label('no_telp')!!}
    {!! Form::text('no_telp', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'no_telp',
        'id'        => 'no_telp_perujuk'
    ))!!}
    <code>{!! $errors->first('no_telp')!!}</code>
</div>
<div class="form-group">
    {!! Form::submit($submit, array(
        'class' => 'btn btn-primary block full-width m-b',
        'id'    => 'perujuk_submit'
    )) !!}
    {!! HTML::link('asuransis', 'Cancel', ['class' => 'btn btn-danger block full-width m-b'])!!}
</div>