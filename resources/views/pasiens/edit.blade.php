 @extends('layout.master')
 @section('title') 
	Klinik Jati Elok | edit Pasien
 @stop
 @section('head')

 @stop
 @section('page-title') 

 <h2>Update Pasien</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('pasiens')}}">Pasien</a>
      </li>
      <li class="active">
          <strong>Update Pasien</strong>
      </li>
</ol>
 @stop
 @section('content') 
            {!! Form::model($pasien, array(
                "url"   => "pasiens/". $pasien->id,
                "method"=> "put",
                "class" => "m-t", 
                "role"  => "form",
                "files"=> true
            ))!!}
				@include('pasiens.edit_form', ['facebook' =>false, 'pasien' => $pasien])
            {!! Form::close() !!}

            @if(\Auth::user()->role == '6')
                {!! Form::open(array('url' => 'pasiens/' . $pasien->id, 'method' => 'DELETE'))!!} 
				<div class="row">
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
						{!! Form::submit('Delete', array('class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Anda yakin mau menghapus pasien ' . $pasien->id . ' - ' . $pasien->nama . '")')) !!}
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
						@if( $pasien->prolanis )
							<a class="btn btn-info btn-block" href="{{ url('prolanis/' . $pasien->prolanis->id . '/edit') }}">Edit Prolanis</a>
						@else
							<a class="btn btn-success btn-block" href="{{ url('prolanis/create/' . $pasien->id) }}">Create Prolanis</a>
						@endif
					</div>
				</div>
                {!! Form::close() !!}
            @endif
 @stop
 @section('footer') 
 <!-- Data picker -->
    <script>
    var base = '{{ url("/") }}';
    </script>
    {!! HTML::script('js/togglepanel.js')!!}
   <script pasiens="{{ url('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    {!! HTML::script('js/plugins/webcam/photo.js')!!}
   <script>
        $(document).ready(function() {
              $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });



            // var image = $('#formfield').val()
            // $('.image').attr("src","data:image/png;base64,"+image);

        });

		function dummySubmit(){
			if(validatePass()){
				$('#submit').click();
			}	 
		}

		function dummySubmit2(){
			var r = confirm('Anda yakin mau kirim sms?') ;
			if(r){
				$('#submitSMS').click();
			}
		}
   </script>
 @stop


       
