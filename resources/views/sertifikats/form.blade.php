<div class="row">        
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group @if($errors->has('nama')) has-error @endif">
                      {!! Form::label('nama', 'Nama Sertifikat', ['class' => 'control-label']) !!}
                      {!! Form::text('nama' , null, ['class' => 'form-control']) !!}
                      @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
                    </div>
                    <div class="form-group @if($errors->has('staf_id')) has-error @endif">
                      {!! Form::label('staf_id', 'Nama Staf Pemilik', ['class' => 'control-label']) !!}
                      {!! Form::select('staf_id', \App\Models\Staf::pluck('nama', 'id') , null, [
                            'class'            => 'form-control selectpick',
                            'data-live-search' => 'true',
                            'placeholder'      => 'Pilih'
                      ]) !!}
                      @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
                    </div>
                    <div class="form-group @if($errors->has('tanggal_terbit')) has-error @endif">
                      {!! Form::label('tanggal_terbit', 'Tanggal Input', ['class' => 'control-label']) !!}
                      {!! Form::text('tanggal_terbit' , 
                          isset($sertifikat) && !empty($sertifikat->tanggal_terbit) ? \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->format('d-m-Y') : null, 
                      ['class' => 'form-control tanggal']) !!}
                      @if($errors->has('tanggal_terbit'))<code>{{ $errors->first('tanggal_terbit') }}</code>@endif
                    </div>
                    <div class="form-group @if($errors->has('expiry_date')) has-error @endif">
                      {!! Form::label('expiry_date', 'Berlaku Sampai', ['class' => 'control-label']) !!}
                      {!! Form::text('expiry_date' , 
                          isset($sertifikat) && !empty($sertifikat->expiry_date) ? \Carbon\Carbon::parse($sertifikat->expiry_date)->format('d-m-Y') : null,
                      ['class' => 'form-control tanggal']) !!}
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
                            @if(isset($sertifikat))
                                <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
                            @else
                                <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
                            @endif
                            {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <a class="btn btn-danger btn-block" href="{{ url('sertifikats') }}">Cancel</a>
                        </div>
                    </div>

                    @if(isset($sertifikat))
                        <br></br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                {!! Form::open(['url' => 'sertifikats/' . $sertifikat->id, 'method' => 'delete']) !!}
                                    <button type="submit" onclick="return confirm('anda yakin mau menghapus sertifikat ini?')" class="btn btn-warning btn-block">Delete</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                {!! Form::label('url', 'Upload Sertifikat') !!}
                {!! Form::file('url') !!}
                {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
