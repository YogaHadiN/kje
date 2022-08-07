<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group @if($errors->has('tanggal')) has-error @endif">
          {!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
          {!! Form::text('tanggal' , isset($setor_tunai) ? \Carbon\Carbon::parse($setor_tunai->tanggal)->format('d-m-Y') : null, ['class' => 'form-control tanggal rq']) !!}
          @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('staf_id')) has-error @endif">
          {!! Form::label('staf_id', 'Nama Staf', ['class' => 'control-label']) !!}
          {!! Form::select('staf_id', \App\Models\Staf::pluck('nama', 'id') , null, [
                'class'            => 'form-control selectpick rq',
                'data-live-search' => 'true',
                'placeholder'      => '- Pilih Staf -',

          ]) !!}
          @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('coa_id')) has-error @endif">
          {!! Form::label('coa_id', 'Tujuan Transfer', ['class' => 'control-label']) !!}
          {!! Form::select('coa_id' , $tujuan_uang_list, null, [
                'class' => 'form-control rq',
                'placeholder'      => '- Pilih Tujuan Transfer -',
          ]) !!}
          @if($errors->has('coa_id'))<code>{{ $errors->first('coa_id') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('nominal')) has-error @endif">
          {!! Form::label('nominal', 'Nominal', ['class' => 'control-label']) !!}
          {!! Form::text('nominal' , null, ['class' => 'form-control uangInput rq']) !!}
          @if($errors->has('nominal'))<code>{{ $errors->first('nominal') }}</code>@endif
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                @if(isset($setor_tunai))
                    <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
                @else
                    <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
                @endif
                {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a class="btn btn-danger btn-block" href="{{ url('setor_tunais') }}">Cancel</a>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group{{ $errors->has('nota_image') ? ' has-error' : '' }}">
            {!! Form::label('nota_image', 'Bukti Setor') !!}
            {!! Form::file('nota_image') !!}
                @if (isset($setor_tunai) && $setor_tunai->nota_image)
                     <p> <img src="{{ \Storage::disk('s3')->url($setor_tunai->nota_image) }}" alt="" class="img-rounded upload"> </p>
                @else
                     <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
                @endif
            {!! $errors->first('nota_image', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
