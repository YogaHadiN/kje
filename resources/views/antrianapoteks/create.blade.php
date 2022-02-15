 @extends('layout.master')

 @section('title') 
{{ env("NAMA_KLINIK") }} | Create Staf
 @stop
 @section('page-title') 
 <h2>Create Staf</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('stafs')}}">Staf</a>
      </li>
      <li class="active">
        <strong>Create Staf</strong>
      </li>
</ol>
 @stop
 @section('content') 
{!! Form::open(array(
    "url"    => "stafs",
    "class"  => "m-t",
    "role"   => "form",
    "method" => "post",
    "files"  => "true"
))!!}
  @include('stafs.form', [
    'image'         => null,
    'ktp_image'     => null
  ])
{!! Form::close() !!}
 @stop
 @section('footer') 
{!! HTML::script('js/plugins/webcam/photo.js')!!}
{!! HTML::script('js/togglepanel.js')!!}
 @stop
