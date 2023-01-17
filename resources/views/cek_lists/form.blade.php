<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group @if($errors->has('cek_list')) has-error @endif">
          {!! Form::label('cek_list', 'Cek List', ['class' => 'control-label']) !!}
          {!! Form::text('cek_list' , null, ['class' => 'form-control']) !!}
          @if($errors->has('cek_list'))<code>{!! $errors->first('cek_list') !!}</code>@endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @if(isset($cek_list))
            <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
        @else
            <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
        @endif
        {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <a class="btn btn-danger btn-block" href="{{ url('cek_lists') }}">Cancel</a>
    </div>
</div>
