<div class="modal fade" tabindex="-1" role="dialog" id="confirm_staf">
  <div class="modal-dialog">
  {!! Form::open(['url'=>'pasiens/ajax/confirm_staf', 'method'=> 'post', 'autocomplete' => 'off']) !!} 
	<input style="display:none"><input type="password" style="display:none">
    <input type="hidden" name="pasien_id" id="pasien_id_stafs" value=""> 
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Konfirmasi Staf</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger">
            <h4>Riwayat Pemeriksaan Pasien Adalah RAHASIA</h4>
            <p>Hanya Dokter / Staf yang pernah periksa pasien ini yang memiliki wewenang untuk melihat riwayat pasien</p>
        </div> 
		<div class="form-group @if($errors->has('email'))has-error @endif">
		  {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
          {!! Form::text('email' , null, ['class' => 'form-control rq', 'autocomplete' => 'off']) !!}
		  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
		</div>
		<div class="form-group @if($errors->has('password'))has-error @endif">
		  {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
          {!! Form::password('password',  array('placeholder' => 'password', 'class'=>'form-control rq', 'autocomplete' => 'false'))!!}
		  @if($errors->has('password'))<code>{{ $errors->first('password') }}</code>@endif
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="confirmStaf(this);return false;">Submit</button>
        {!! Form::submit('Submit', ['class' => 'hide', 'id' => 'submit_confirm_staf']) !!}
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
    {!! Form::close() !!}
  </div><!-- /.modal-dialog -->
</div>
