@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Cek Harian Anafilaktik Kit {{ $ruangan->nama }}

@stop
@section('page-title') 
    <h2>Cek Harian Anafilaktik Kit {{ $ruangan->nama }}</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Cek Harian Anafilaktik Kit {{ $ruangan->nama }}</strong>
            </li>
</ol>

@stop
@section('content') 
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                {!! Form::open([
                    'url'    => 'cek_harian_anafilaktik_kits/' . $ruangan->id,
                    "class"  => "m-t",
                    "role"   => "form",
                    "method" => "post",
                    "files"  => "true"
                ]) !!}
                    <div class="form-group @if($errors->has('jumlah_epinefrin_inj')) has-error @endif">
                      {!! Form::label('jumlah_epinefrin_inj', 'Jumlah Epinefrin Inj', ['class' => 'control-label']) !!}
                      {!! Form::text('jumlah_epinefrin_inj' , null, ['class' => 'form-control rq']) !!}
                      @if($errors->has('jumlah_epinefrin_inj'))<code>{{ $errors->first('jumlah_epinefrin_inj') }}</code>@endif
                    </div>
                    <div class="form-group{{ $errors->has('jumlah_epinefrin_inj_image') ? ' has-error' : '' }}">
                        {!! Form::label('jumlah_epinefrin_inj_image', 'Gambar Epinefrin Injeksi') !!}
                        {!! Form::file('jumlah_epinefrin_inj_image') !!}
                            @if (isset($cek_harian_anafilaktik_kit) && $cek_harian_anafilaktik_kit->jumlah_epinefrin_inj_image)
                                <p> {!! HTML::image(asset('root directory/'.$cek_harian_anafilaktik_kit->jumlah_epinefrin_inj_image), null, ['class'=>'img-rounded upload']) !!} </p>
                            @else
                                <p> {!! HTML::image(asset('images/image_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
                            @endif
                        {!! $errors->first('jumlah_epinefrin_inj_image', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group @if($errors->has('jumlah_dexamethasone_inj')) has-error @endif">
                      {!! Form::label('jumlah_dexamethasone_inj', 'Jumlah Dexa', ['class' => 'control-label']) !!}
                      {!! Form::text('jumlah_dexamethasone_inj' , null, ['class' => 'form-control rq']) !!}
                      @if($errors->has('jumlah_dexamethasone_inj'))<code>{{ $errors->first('jumlah_dexamethasone_inj') }}</code>@endif
                    </div>
                    <div class="form-group{{ $errors->has('jumlah_dexamethasone_inj_image') ? ' has-error' : '' }}">
                        {!! Form::label('jumlah_dexamethasone_inj_image', 'Gambar Dexa') !!}
                        {!! Form::file('jumlah_dexamethasone_inj_image') !!}
                            @if (isset($cek_harian_anafilaktik_kit) && $cek_harian_anafilaktik_kit->jumlah_dexamethasone_inj_image)
                                <p> {!! HTML::image(asset('root directory/'.$cek_harian_anafilaktik_kit->jumlah_dexamethasone_inj_image), null, ['class'=>'img-rounded upload']) !!} </p>
                            @else
                                <p> {!! HTML::image(asset('images/image_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
                            @endif
                        {!! $errors->first('jumlah_dexamethasone_inj_image', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group @if($errors->has('jumlah_ranitidine_inj')) has-error @endif">
                      {!! Form::label('jumlah_ranitidine_inj', 'Jumlah Ranitidin Inj', ['class' => 'control-label']) !!}
                      {!! Form::text('jumlah_ranitidine_inj' , null, ['class' => 'form-control rq']) !!}
                      @if($errors->has('jumlah_ranitidine_inj'))<code>{{ $errors->first('jumlah_ranitidine_inj') }}</code>@endif
                    </div>
                    <div class="form-group{{ $errors->has('jumlah_ranitidine_inj_image') ? ' has-error' : '' }}">
                        {!! Form::label('jumlah_ranitidine_inj_image', 'Gambar Ranitidin') !!}
                        {!! Form::file('jumlah_ranitidine_inj_image') !!}
                            @if (isset($cek_harian_anafilaktik_kit) && $cek_harian_anafilaktik_kit->jumlah_ranitidine_inj_image)
                                <p> {!! HTML::image(asset('root directory/'.$cek_harian_anafilaktik_kit->jumlah_ranitidine_inj_image), null, ['class'=>'img-rounded upload']) !!} </p>
                            @else
                                <p> {!! HTML::image(asset('images/image_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
                            @endif
                        {!! $errors->first('jumlah_ranitidine_inj_image', '<p class="help-block">:message</p>') !!}
                    </div>
                     <div class="form-group @if($errors->has('jumlah_diphenhydramine_inj')) has-error @endif">
                      {!! Form::label('jumlah_diphenhydramine_inj', 'Jumlah Diphenhydramin Inj', ['class' => 'control-label']) !!}
                      {!! Form::text('jumlah_diphenhydramine_inj' , null, ['class' => 'form-control rq']) !!}
                      @if($errors->has('jumlah_diphenhydramine_inj'))<code>{{ $errors->first('jumlah_diphenhydramine_inj') }}</code>@endif
                    </div>   
                    <div class="form-group{{ $errors->has('jumlah_diphenhydramine_inj_image') ? ' has-error' : '' }}">
                        {!! Form::label('jumlah_diphenhydramine_inj_image', 'Gambar Diphenhydramin') !!}
                        {!! Form::file('jumlah_diphenhydramine_inj_image') !!}
                            @if (isset($cek_harian_anafilaktik_kit) && $cek_harian_anafilaktik_kit->jumlah_diphenhydramine_inj_image)
                                <p> {!! HTML::image(asset('root directory/'.$cek_harian_anafilaktik_kit->jumlah_diphenhydramine_inj_image), null, ['class'=>'img-rounded upload']) !!} </p>
                            @else
                                <p> {!! HTML::image(asset('images/image_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
                            @endif
                        {!! $errors->first('jumlah_diphenhydramine_inj_image', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group @if($errors->has('jumlah_spuit_3cc')) has-error @endif">
                      {!! Form::label('jumlah_spuit_3cc', 'Jumlah Spuit 3cc', ['class' => 'control-label']) !!}
                      {!! Form::text('jumlah_spuit_3cc' , null, ['class' => 'form-control rq']) !!}
                      @if($errors->has('jumlah_spuit_3cc'))<code>{{ $errors->first('jumlah_spuit_3cc') }}</code>@endif
                    </div>
                    <div class="form-group{{ $errors->has('jumlah_spuit_3cc_image') ? ' has-error' : '' }}">
                        {!! Form::label('jumlah_spuit_3cc_image', 'Gambar Spuit 3cc') !!}
                        {!! Form::file('jumlah_spuit_3cc_image') !!}
                            @if (isset($cek_harian_anafilaktik_kit) && $cek_harian_anafilaktik_kit->jumlah_spuit_3cc_image)
                                <p> {!! HTML::image(asset('root directory/'.$cek_harian_anafilaktik_kit->jumlah_spuit_3cc_image), null, ['class'=>'img-rounded upload']) !!} </p>
                            @else
                                <p> {!! HTML::image(asset('images/image_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
                            @endif
                        {!! $errors->first('jumlah_spuit_3cc_image', '<p class="help-block">:message</p>') !!}
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
                            <a class="btn btn-danger btn-block" href="{{ url('cek_list_harians/' . $ruangan->id) }}">Cancel</a>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
@stop
@section('footer') 
    <script type="text/javascript" charset="utf-8">
        function dummySubmit(control){
            if(validatePass2(control)){
                $('#submit').click();
            }
        }
    </script>
@stop
