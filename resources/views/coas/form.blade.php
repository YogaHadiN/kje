 <div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">Buat Coa Baru</div>
	</div>
	<div class="panel-body">
		 <div class="row">
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 <div class="form-group @if($errors->has('keompok_coa_id'))has-error @endif">
				   {!! Form::label('keompok_coa_id', 'Kelompok Coa', ['class' => 'control-label']) !!}
				 {!! Form::select('kelompok_coa_id', App\Models\KelompokCoa::list(), null, [
					 'class' => 'form-control form-coa rq' , 
					 'id' => 'kelompok_coa_id',
					 'onchange' => 'kelompok_coa_change(this);return false'
				 ]) !!}
				   @if($errors->has('keompok_coa_id'))<code>{{ $errors->first('keompok_coa_id') }}</code>@endif
				 </div>
			 </div>
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 <div class="form-group @if($errors->has('coa_id'))has-error @endif">
				   {!! Form::label('coa_id', 'Kode Coa', ['class' => 'control-label']) !!}
				   <input type="text" name="coa_id" id="kode_coa" value="{{ $coa_id }}" @if($create) disabled="disabled" @endif onkeyup="kode_coa_keyup(); return false" class="form-control rq"/>
				   @if($errors->has('coa_id'))<code>{{ $errors->first('coa_id') }}</code>@endif
				 </div>
			 </div>
		 </div>
		 <div class="row">
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				 <div class="form-group @if($errors->has('coa'))has-error @endif">
				   {!! Form::label('coa', 'Keterangan Coa', ['class' => 'control-label']) !!}
					 @if($create)
						 {!! Form::text('coa' , null, ['class' => 'form-control form-coa rq', 'id'=>'keterangan_coa', 'disabled' => 'disabled']) !!}
					 @else
						 {!! Form::text('coa' , null, ['class' => 'form-control form-coa rq', 'id'=>'keterangan_coa']) !!}
					 @endif
				   @if($errors->has('coa'))<code>{{ $errors->first('coa') }}</code>@endif
				 </div>
			 </div>
		 </div>
		 <div class="row">
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 <button class="btn btn-success btn-block" type="button" id="submit_coa" onclick="submitCoa(this);return false;">Submit</button>
				 <button class="hide submit" type="submit" id="submit">Submit</button>
			 </div>
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 <button class="btn btn-danger btn-block" type="button" id="cancel_coa" onclick=" $('#coa_baru').modal('hide');return false;">Cancel</button>
			 </div>
		 </div>
	</div>
 </div>
