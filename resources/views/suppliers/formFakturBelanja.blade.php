{!! Form::text('belanja_id', 1, ['class' => 'hide']) !!} 
<div class="form-group @if($errors->has('supplier_id'))has-error @endif">
	{!! Form::label('supplier_id', 'Supplier', ['class' => 'control-label']) !!}
  {!! Form::select('supplier_id', App\Models\Classes\Yoga::supplierList(), null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true', 'id' => 'supplier_id']) !!}
  @if($errors->has('supplier_id'))<code>{{ $errors->first('supplier_id') }}</code>@endif
</div>

<div class="form-group @if($errors->has('sumber_uang'))has-error @endif">
	{!! Form::label('sumber_uang', 'Sumber Uang', ['class' => 'control-label']) !!}
	@if(isset( $edit ))
		{!! Form::select('sumber_uang' , $sumber_uang, $fakturbelanja->sumber_uang_id, ['class' => 'form-control rq']) !!}
	@else
	  {!! Form::select('sumber_uang' , $sumber_uang, null, ['class' => 'form-control rq']) !!}
	@endif
  @if($errors->has('sumber_uang'))<code>{{ $errors->first('sumber_uang') }}</code>@endif
</div>

<div class="form-group @if($errors->has('nomor_faktur'))has-error @endif">
	{!! Form::label('nomor_faktur', 'Nomor Faktur', ['class' => 'control-label']) !!}
  {!! Form::text('nomor_faktur' , null, ['class' => 'form-control rq']) !!}
  @if($errors->has('nomor_faktur'))<code>{{ $errors->first('nomor_faktur') }}</code>@endif
</div>

<div class="form-group @if($errors->has('tanggal'))has-error @endif">
	{!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
	@if(isset($edit))
		{!! Form::text('tanggal' , $fakturbelanja->tanggal->format('d-m-Y'), ['class' => 'form-control tanggal rq']) !!}
	@else
	  {!! Form::text('tanggal' , date('d-m-Y'), ['class' => 'form-control tanggal rq']) !!}
	@endif
  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
</div>

<div class="form-group @if($errors->has('tanggal'))has-error @endif">
	{!! Form::label('staf_id', 'Nama Penginput', ['class' => 'control-label']) !!}
	@if(isset($edit))
		{!! Form::select('staf_id', App\Models\Classes\Yoga::stafList(), $fakturbelanja->petugas_id, ['class'=>'form-control selectpick rq', 'id'=>'staf_id', 'data-live-search' => 'true'])!!}
	@else
	  {!! Form::select('staf_id', App\Models\Classes\Yoga::stafList(), null, ['class'=>'form-control selectpick rq', 'id'=>'staf_id', 'data-live-search' => 'true'])!!}
	@endif
  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
</div>
<div class="form-group @if($errors->has('diskon'))has-error @endif">
  {!! Form::label('diskon', 'Diskon Pembelian', ['class' => 'control-label']) !!}
  {!! Form::text('diskon' , null, ['class' => 'form-control uangInput rq']) !!}
  @if($errors->has('diskon'))<code>{{ $errors->first('diskon') }}</code>@endif
</div>
