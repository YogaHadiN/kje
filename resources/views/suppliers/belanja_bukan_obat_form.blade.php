{!! Form::text('belanja_id', 3, ['class' => 'hide']) !!} 
<div class="form-group @if($errors->has('supplier_id'))has-error @endif">
  {!! Form::label('supplier_id', 'Supplier', ['class' => 'control-label']) !!}
  {!! Form::select('supplier_id', App\Models\Classes\Yoga::supplierList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
  @if($errors->has('supplier_id'))<code>{{ $errors->first('supplier_id') }}</code>@endif
</div>
<div class="form-group @if($errors->has('staf_id'))has-error @endif">
  {!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
  {!! Form::select('staf_id', App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
</div>

<div class="form-group @if($errors->has('sumber_uang'))has-error @endif">
	{!! Form::label('sumber_uang', 'Sumber Uang', ['class' => 'control-label']) !!}
  {!! Form::select('sumber_uang' , $sumber_uang, null, ['class' => 'form-control']) !!}
  @if($errors->has('sumber_uang'))<code>{{ $errors->first('sumber_uang') }}</code>@endif
</div>
<div class="form-group @if($errors->has('nilai'))has-error @endif">
	{!! Form::label('nilai', 'Nilai', ['class' => 'control-label']) !!}
	{!! Form::text('nilai' , null, ['class' => 'form-control rq uangInput']) !!}
  @if($errors->has('nilai'))<code>{{ $errors->first('nilai') }}</code>@endif
</div>
<div class="form-group @if($errors->has('tanggal'))has-error @endif">
	{!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
	{!! Form::text('tanggal' , date('d-m-Y'), ['class' => 'form-control tanggal']) !!}
  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
</div>
<div class="form-group @if($errors->has('keterangan'))has-error @endif">
  {!! Form::label('keterangan', 'Uangnya Dipakai Buat apa', ['class' => 'control-label']) !!}
  {!! Form::textarea('keterangan' , null, ['class' => 'form-control textareacustom']) !!}
  @if($errors->has('keterangan'))<code>{{ $errors->first('keterangan') }}</code>@endif
</div>
<div class="form-group">
  {!! Form::submit('Belanja Bukan Obat', ['class' => 'btn btn-success btn-block btn-lg']) !!}
</div>

