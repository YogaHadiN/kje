 @extends('layout.master')

 @section('title') 
{{ env("NAMA_KLINIK") }} | Edit Staf

 @stop
 @section('head')
    <link href="{{ url('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

 @stop
 @section('page-title') 
 <h2>Update Staf</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('stafs')}}">Staf</a>
      </li>
      <li class="active">
          <strong>Update Staf</strong>
      </li>
</ol>
 @stop

 @section('content') 
 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  {!! Form::model($staf, array(
      "url"   => "stafs/". $staf->id,
      "class" => "m-t", 
      "role"  => "form",
	  "method"=> "put",
       "files"=> "true"
  ))!!}

   @include('stafs.form', [
		'image'         => $staf->image,
		'ktp_image'     => $staf->ktp_image
   ])

  {!! Form::close() !!}
  <div class="row">
  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		  {!! Form::open(array('url' => 'stafs/' . $staf->id,'method' => 'DELETE'))!!} 
			  {!! Form::submit('DELETE', array('class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Anda akan menghapus data Staf ' . $staf->id . ' - '. $staf->nama .', Lanjutkan? ");'))!!}
		  {!! Form::close() !!}
  	</div>
  </div>
 </div>

 @stop
 @section('footer') 
	 <script type="text/javascript" charset="utf-8">
		var base = "{{ url ('/') }}";
	 </script>
{!! HTML::script('js/togglepanel.js')!!}
{!! HTML::script('js/asuransi_upload.js')!!}
{!! HTML::script('js/plugins/webcam/photo.js')!!}
 @stop
