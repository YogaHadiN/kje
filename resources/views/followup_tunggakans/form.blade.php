    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group @if($errors->has('asuransi_id')) has-error @endif">
              {!! Form::label('asuransi_id', 'Nama Asuransi', ['class' => 'control-label']) !!}
              {!! Form::select('asuransi_id', \App\Models\Asuransi::pluck('nama', 'id'), null, [
                'class' => 'form-control selectpick rq',
                'data-live-search' => 'true',
                'placeholder' => '- Pilih -',
              ]) !!}
              @if($errors->has('asuransi_id'))<code>{{ $errors->first('asuransi_id') }}</code>@endif
            </div>
            <div class="form-group @if($errors->has('staf_id')) has-error @endif">
              {!! Form::label('staf_id', 'Nama Staf', ['class' => 'control-label']) !!}
              {!! Form::select('staf_id' , \App\Models\Staf::pluck('nama', 'id'), null, [
                'class' => 'form-control selectpick rq',
                'data-live-search' => 'true',
                'placeholder' => '- Pilih -',
              ]) !!}
              @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
            </div>
            <div class="form-group @if($errors->has('tanggal')) has-error @endif">
              {!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
              {!! Form::text('tanggal' , isset($followup_tunggakan) ? \Carbon\Carbon::parse( $followup_tunggakan->tanggal )->format('d-m-Y') : null, ['class' => 'form-control tanggal rq']) !!}
              @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group{{ $errors->has('bukti_followup') ? ' has-error' : '' }}">
                {!! Form::label('bukti_followup', 'Bukti Followup') !!}
                {!! Form::file('bukti_followup') !!}
                    @if (isset($followup_tunggakan) && $followup_tunggakan->bukti_followup)
                        <p> <img src="{{ \Storage::disk('s3')->url($followup_tunggakan->bukti_followup) }}" alt="" class="img-rounded upload"> </p>
                    @else
                        <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
                    @endif
                {!! $errors->first('bukti_followup', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            @if(isset($followup_tunggakan))
                <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
            @else
                <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
            @endif
            {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <a class="btn btn-danger btn-block" href="{{ url('followup_tunggakans') }}">Cancel</a>
        </div>
    </div>
