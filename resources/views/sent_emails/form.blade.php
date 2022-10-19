<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group @if($errors->has('email')) has-error @endif">
          {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
          {!! Form::text('email' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('staf_id')) has-error @endif">
          {!! Form::label('staf_id', 'Nama Staf', ['class' => 'control-label']) !!}
          {!! Form::select('staf_id' , \App\Models\Staf::pluck('nama', 'id'), null, [
            'class'            => 'form-control rq selectpick',
            'data-live-search' => 'true',
            'placeholder'      => '-Pilih-'
          ]) !!}
          @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('tanggal')) has-error @endif">
          {!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
          {!! Form::text('tanggal' , null, ['class' => 'form-control tanggal']) !!}
          @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('subject')) has-error @endif">
          {!! Form::label('subject', 'Subject', ['class' => 'control-label']) !!}
          {!! Form::text('subject' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('subject'))<code>{{ $errors->first('subject') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('body')) has-error @endif">
          {!! Form::label('body', 'Body', ['class' => 'control-label']) !!}
          {!! Form::textarea('body' , null, ['class' => 'form-control textareacustom']) !!}
          @if($errors->has('body'))<code>{{ $errors->first('body') }}</code>@endif
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                @if(isset($update))
                    <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
                @else
                    <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
                @endif
                {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a class="btn btn-danger btn-block" href="{{ url('home/') }}">Cancel</a>
            </div>
        </div>
    </div>
</div>
