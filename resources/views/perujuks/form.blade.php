<div class="form-group @if($errors->has('nama'))has-error @endif">
  {!! Form::label('nama', 'Nama', ['class' => 'control-label']) !!}
    {!! Form::text('nama', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'nama',
        'id'   => 'nama_perujuk'
    ))!!}
  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
</div>

<div class="form-group @if($errors->has('alamat'))has-error @endif">
  {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
    {!! Form::textarea('alamat', null, array(
        'class'         => 'form-control textareacustom',
        'placeholder'   => 'alamat',
        'id'        => 'alamat_perujuk'
    ))!!}
  @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
</div>
<div class="form-group @if($errors->has('no_telp'))has-error @endif">
  {!! Form::label('no_telp', 'No Telp', ['class' => 'control-label']) !!}
    {!! Form::text('no_telp', null, array(
        'class'         => 'form-control',
        'placeholder'   => 'no_telp',
        'id'        => 'no_telp_perujuk'
    ))!!}
  @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
</div>
<div class="form-group">
    {!! Form::submit($submit, array(
        'class' => 'btn btn-primary block full-width m-b',
        'id'    => 'perujuk_submit'
    )) !!}
    {!! HTML::link('asuransis', 'Cancel', ['class' => 'btn btn-danger block full-width m-b'])!!}
</div>
