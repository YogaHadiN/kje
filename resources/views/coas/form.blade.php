 <div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">Buat Coa Baru</div>
	</div>
	<div class="panel-body">
		 <div class="row">
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 <div class="form-group">
					 {!! Form::label('kelompok_coa_id', 'Kelompok Coa') !!}
					 {!! Form::select('kelompok_coa_id', $kelompokCoaList, null, [
						 'class' => 'form-control form-coa rq' , 
						 'id' => 'kelompok_coa_id',
						 'onchange' => 'kelompok_coa_change(this);return false'
					 ]) !!}
				 </div>
			 </div>
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 <div class="form-group">
					 {!! Form::label('coa_id', 'Kode Coa') !!}
					 <input type="text" name="coa_id" id="kode_coa" value="{{ $coa_id }}" @if($create) disabled="disabled" @endif onkeyup="kode_coa_keyup(); return false" class="form-control rq"/>
				 </div>
			 </div>
		 </div>
		 <div class="row">
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				 <div class="form-group">
					 {!! Form::label('coa', 'Keterangan Coa') !!}
					 @if($create)
						 {!! Form::text('coa' , null, ['class' => 'form-control form-coa rq', 'id'=>'keterangan_coa', 'disabled' => 'disabled']) !!}
					 @else
						 {!! Form::text('coa' , null, ['class' => 'form-control form-coa rq', 'id'=>'keterangan_coa']) !!}
					 @endif
				 </div>
			 </div>
		 </div>
		 <div class="row">
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 <button class="btn btn-success btn-block" type="button" id="submit_coa" onclick="submitCoa();return false;">Submit</button>
				 <button class="hide" type="submit" id="submit">Submit</button>
			 </div>
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 <button class="btn btn-danger btn-block" type="button" id="cancel_coa" onclick=" $('#coa_baru').modal('hide');return false;">Cancel</button>
			 </div>
		 </div>
	</div>
 </div>
