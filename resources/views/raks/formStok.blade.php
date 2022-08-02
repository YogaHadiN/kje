<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group @if($errors->has('stok'))has-error @endif">
          {!! Form::label('stok', 'Stok', ['class' => 'control-label']) !!}
          {{ Form::text('stok', null, ['class' => 'form-control', 'id'=>'stokOnRak'])}}
          @if($errors->has('stok'))<code>{{ $errors->first('stok') }}</code>@endif
        </div>
  </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group @if($errors->has('stok_minimal'))has-error @endif">
          {!! Form::label('stok_minimal', 'Stok Minimal', ['class' => 'control-label']) !!}
          {{ Form::text('stok_minimal', null, ['class' => 'form-control', 'id'=>'stokMinimalOnRak'])}}
          @if($errors->has('stok_minimal'))<code>{{ $errors->first('stok_minimal') }}</code>@endif
        </div>
  </div>
</div>
