 @extends('layout.master')

 @section('title') 
 {{ env("NAMA_KLINIK") }} | Asuransi Baru

 @stop
 @section('head')
    <style>
        .w{
            overflow: hidden;
        }

        .w input{
            width:100%;
        }
    </style>
 @stop
 @section('page-title') 
<h2>Asuransi Baru</h2> 
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('asuransis')}}">Asuransi</a>
      </li>
      <li class="active">
          <strong>Buat Baru</strong>
      </li>
</ol>
 @stop
 @section('content') 
  {!! Form::open(array(
        "url"   => "asuransis",
        "class" => "m-t", 
        "role"  => "form",
		"files"=> "true",
        "method"=> "post"
        ))!!}
@include('asuransis/form', [
'tanggal' => null, 
'submit' => 'Submit', 
'tarifs' => $tarifs, 
'umumstring' => null,
'gigistring' => null,
'rujukanstring' => null,
'hapus' => false,
'penagihanstring' => null
])
    {!! Form::close() !!}
@stop
@section('footer') 
		{!! HTML::script('js/show_periksa.js') !!}
		@include('asuransis/footer', ['tarifs' => $tarifs])
@stop
