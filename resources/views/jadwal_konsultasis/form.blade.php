<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group @if($errors->has('staf_id')) has-error @endif">
          {!! Form::label('staf_id', 'Nama Staf', ['class' => 'control-label']) !!}
          {!! Form::select('staf_id' , App\Models\Staf::pluck('nama', 'id'), null, [
            'class' => 'form-control selectpick rq',
            'data-live-search' => 'true',
            'placeholder' => 'Pilih Staf'
          ]) !!}
          @if($errors->has('staf_id'))<code>{!! $errors->first('staf_id') !!}</code>@endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group @if($errors->has('tipe_konsultasi_id')) has-error @endif">
          {!! Form::label('tipe_konsultasi_id', 'Tipe Konsultasi', ['class' => 'control-label']) !!}
          {!! Form::select('tipe_konsultasi_id' , \App\Models\TipeKonsultasi::pluck('tipe_konsultasi', 'id'), null, [
            'class'       => 'form-control rq',
            'placeholder' => '-Pilih-'
          ]) !!}
          @if($errors->has('tipe_konsultasi_id'))<code>{!! $errors->first('tipe_konsultasi_id') !!}</code>@endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group @if($errors->has('hari_id')) has-error @endif">
          {!! Form::label('hari_id', 'Hari', ['class' => 'control-label']) !!}
          {!! Form::select('hari_id' , App\Models\Hari::pluck('hari', 'id'), null, [
            'class' => 'form-control rq',
            'placeholder' => 'Pilih Hari'
          ]) !!}
          @if($errors->has('hari_id'))<code>{!! $errors->first('hari_id') !!}</code>@endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group @if($errors->has('jam_mulai')) has-error @endif">
          {!! Form::label('jam_mulai', 'Jam Mulai', ['class' => 'control-label']) !!}
        <div class="input-group jam" data-placement="left" data-align="top" data-autoclose="true">
          {!! Form::text('jam_mulai' , null, ['class' => 'form-control rq']) !!}
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-time"></span>
            </span>
        </div>
          @if($errors->has('jam_mulai'))<code>{!! $errors->first('jam_mulai') !!}</code>@endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group @if($errors->has('jam_akhir')) has-error @endif">
          {!! Form::label('jam_akhir', 'Jam Akhir', ['class' => 'control-label']) !!}
        <div class="input-group jam" data-placement="left" data-align="top" data-autoclose="true">
          {!! Form::text('jam_akhir' , null, ['class' => 'form-control rq']) !!}
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-time"></span>
            </span>
        </div>
          @if($errors->has('jam_akhir'))<code>{!! $errors->first('jam_akhir') !!}</code>@endif
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>{{ isset($jadwal_konsultasi) ? 'Update' : 'Submit' }}</button>
            {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <a class="btn btn-danger btn-block" href="{{ url('jadwal_konsultasis') }}">Cancel</a>
        </div>
    </div>
    <script type="text/javascript" charset="utf-8">
        function dummySubmit(control){
            if(validatePass2(control)){
                $('#submit').click();
            }
        }
    </script>
