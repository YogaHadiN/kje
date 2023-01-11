@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buat Cek List Harian Baru

@stop
@section('page-title') 
<h2>Buat Cek List Harian Baru</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Buat Cek List Harian Baru</strong>
    </li>
</ol>

@stop
@section('content') 
{!! Form::open(['url' => 'cek_list_harians', 'method' => 'post']) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group @if($errors->has('no_telp')) has-error @endif">
                  {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
                  {!! Form::text('no_telp' , null, ['class' => 'form-control rq']) !!}
                  @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group @if($errors->has('staf_id')) has-error @endif">
                  {!! Form::label('staf_id', 'Nama Staf', ['class' => 'control-label']) !!}
                  {!! Form::select('staf_id' , \App\Models\Staf::pluck('nama', 'id'), null, [
                    'class'       => 'form-control',
                    'placeholder' => '-Pilih-'
                  ]) !!}
                  @if($errors->has('staf_id'))<code>{!! $errors->first('staf_id') !!}</code>@endif
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
            {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <a class="btn btn-danger btn-block" href="{{ url('cek_list_harian') }}">Cancel</a>
        </div>
    </div>
{!! Form::close() !!}
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
