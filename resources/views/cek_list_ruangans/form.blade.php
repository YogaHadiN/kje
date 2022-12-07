<div class="form-group @if($errors->has('cek_list_id')) has-error @endif">
  {!! Form::label('cek_list_id', 'Cek List', ['class' => 'control-label']) !!}
  {!! Form::select('cek_list_id', \App\Models\CekList::pluck('cek_list', 'id'), null, [
    'class' => 'form-control rq selectpick',
    'placeholder' => '- Pilih -',
    'data-live-search' => 'true'
  ]) !!}
  @if($errors->has('cek_list_id'))<code>{{ $errors->first('cek_list_id') }}</code>@endif
</div>
<div class="form-group @if($errors->has('frekuensi_cek_id')) has-error @endif">
  {!! Form::label('frekuensi_cek_id', 'Frekuensi', ['class' => 'control-label']) !!}
  {!! Form::select('frekuensi_cek_id', \App\Models\FrekuensiCek::pluck('frekuensi_cek', 'id'), null, [
    'class' => 'form-control rq',
    'placeholder' => '- Pilih -'
  ]) !!}
  @if($errors->has('frekuensi_cek_id'))<code>{{ $errors->first('frekuensi_cek_id') }}</code>@endif
</div>
<div class="form-group @if($errors->has('limit_id')) has-error @endif">
  {!! Form::label('limit_id', 'Limit', ['class' => 'control-label']) !!}
  {!! Form::select('limit_id', \App\Models\Limit::pluck('limit', 'id'), null, [
    'class' => 'form-control rq',
    'placeholder' => '- Pilih -'
  ]) !!}
  @if($errors->has('limit'))<code>{{ $errors->first('limit') }}</code>@endif
</div>
<div class="form-group @if($errors->has('jumlah_normal')) has-error @endif">
  {!! Form::label('jumlah_normal', 'Jumlah Normal', ['class' => 'control-label']) !!}
  {!! Form::text('jumlah_normal' , null, ['class' => 'form-control rq']) !!}
  @if($errors->has('jumlah_normal'))<code>{{ $errors->first('jumlah_normal') }}</code>@endif
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @if(isset($cek_list_ruangan))
            <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
        @else
            <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
        @endif
        {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <a class="btn btn-danger btn-block" href="{{ url('cek_list_ruangans/' . $ruangan->id) }}">Cancel</a>
    </div>
</div>
