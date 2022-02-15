 @extends('layout.master')

 @section('title') 
 {{ env("NAMA_KLINIK") }} | Create Rak
 @stop
 @section('page-title') 

 <h2>Create Rak</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('mereks')}}">Merek</a>
      </li>
      <li class="active">
          <strong>Create Rak</strong>
      </li>
</ol>
 @stop
 @section('content') 
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @foreach ($errors as $error)
        {!! $error !!} <br>
    @endforeach
{!! Form::open([
        'url' => 'mereks',
        "class" => "m-t", 
        "role"  => "form",
        "method"=> "post"
])!!}


@include('mereks.createForm', ['rak' => $rak, 'modal' => false])

{!! Form::close() !!}

    @stop
    @section('footer')
      {!! HTML::script('js/rak.js')!!} 
      <script>
         var base = "{{ url('/') }}";
         console.log(base);
      </script>
      <script src="{{ url('js/merek.js') }}"></script>
    @stop
