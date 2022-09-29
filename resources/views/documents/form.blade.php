<div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group @if($errors->has('nama')) has-error @endif">
                      {!! Form::label('nama', 'Nama Dokumen', ['class' => 'control-label']) !!}
                      {!! Form::text('nama' , null, ['class' => 'form-control']) !!}
                      @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
                    </div>
                    <div class="form-group @if($errors->has('tanggal')) has-error @endif">
                      {!! Form::label('tanggal', 'Tanggal Input', ['class' => 'control-label']) !!}
                      {!! Form::text('tanggal' , null, ['class' => 'form-control tanggal']) !!}
                      @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
                    </div>
                    <div class="form-group @if($errors->has('expiry_date')) has-error @endif">
                      {!! Form::label('expiry_date', 'Tanggal Kadaluarsa', ['class' => 'control-label']) !!}
                      {!! Form::text('expiry_date' , null, ['class' => 'form-control tanggal']) !!}
                      @if($errors->has('expiry_date'))<code>{{ $errors->first('expiry_date') }}</code>@endif
                    </div>
                    @if( isset($document) && !is_null($document->url) )
                        <div class="row pb-8">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <a href="{{ \Storage::disk('s3')->url($document->url) }}" target="_blank" class="btn btn-info btn-sm">Download <span class="glyphicon glyphicon-download-alt"></span></a>
                            </div>
                        </div>
                    @endif
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
                            <a class="btn btn-danger btn-block" href="{{ url('documents') }}">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                    {!! Form::label('url', 'Upload Dokumen Penting') !!}
                    {!! Form::file('url') !!}
                    {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
                </div>
        </div>
    </div>
