<div class="form-group @if($errors->has('rekening_id'))has-error @endif">
  {!! Form::label('rekening_id', 'ID transaksi', ['class' => 'control-label']) !!}
  {!! Form::text('rekening_id', $id, [
	  'class' => 'form-control ', 
	  'onkeyup' => 'cekRekening(this); return false;', 
	  'id' => 'rekening_id'
  ]) !!}
  @if($errors->has('rekening_id'))<code>{!! $errors->first('rekening_id') !!}</code>@endif
</div>
