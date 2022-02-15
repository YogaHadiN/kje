 @extends('layout.master')

 @section('title') 
{{ env("NAMA_KLINIK") }} | Edit Perujuk

 @stop
 @section('page-title') 
Edit Perujuk
 <h2>Edit Perujuk</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('perujuks')}}">Perujuk</a>
      </li>
      <li class="active">
          <strong>Edit Perujuk</strong>
      </li>
</ol>
 @stop
 @section('content') 

 <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
     
            {!! Form::model($perujuk, array(
                "url"   => "perujuks/". $perujuk->id,
                "class" => "m-t", 
                "role"  => "form",
                "method"=> "put"
            ))!!}
                
                 @include('perujuks.form', ['submit' => 'Update'])
            {!! Form::close() !!}

            {!! Form::open(array('url' => 'perujuks/' . $perujuk->id,'method' => 'DELETE'))!!} 
                {!! Form::submit('DELETE', array(
                'class' => 'btn btn-danger btn-block',
                'onclick' => "return confirm('Yakin Maun Menghapus perujuk " . $perujuk->nama . " ?')"
                ))!!}
            {!! Form::close() !!}



 </div>

 @stop
 @section('footer') 


 @stop


       
