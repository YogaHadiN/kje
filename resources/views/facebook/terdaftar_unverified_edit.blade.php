<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>
    {!! HTML::style('css/bootstrap.min.css')!!}
    {!! HTML::style('font-awesome/css/font-awesome.css')!!}
    {!! HTML::style('css/animate.css')!!}
    {!! HTML::style('css/style.css')!!}
  {{--   <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"> --}}

</head>
<body class="gray-bg">
    <div class="middle-box loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">KJE+</h1>
            </div>
			<p>Selamat Datang 
			<h3>{{ $fb->nama_pasien }}</h3>
			</p>
            <p>Silahkan pilih dengan benar</p>

			{!! Form::open(array('url' => 'facebook/terdaftar/unverified/'.$fb->id . '/update', 'method' => 'post')) !!}

				<div class="form-group @if($errors->has('facebook_id'))has-error @endif">
				{!! Form::label('facebook_id', 'Facebook Id', ['class' => 'control-label']) !!}
				  {!! Form::text('facebook_id' ,  $fb->facebook_id, ['class' => 'form-control rq']) !!}
				  @if($errors->has('facebook_id'))<code>{{ $errors->first('facebook_id') }}</code>@endif
				</div>

				<div class="form-group @if($errors->has('poli'))has-error @endif">
				{!! Form::label('poli', 'Berobat ke Dokter mana ?', ['class' => 'control-label']) !!}
				  {!! Form::select('poli' , $polis, $fb->pilihan_poli, ['class' => 'form-control rq']) !!}
				  @if($errors->has('poli'))<code>{{ $errors->first('poli') }}</code>@endif
				</div>

				<div class="form-group @if($errors->has('pembayaran'))has-error @endif">
				{!! Form::label('pembayaran', 'Pembayaran dengan Asuransi atau Biaya Pribadi ?', ['class' => 'control-label']) !!}
				  {!! Form::select('pembayaran', $pembayarans, $fb->pilihan_pembayaran, ['class' => 'form-control rq']) !!}
				  @if($errors->has('pembayaran'))<code>{{ $errors->first('pembayaran') }}</code>@endif
				</div>
				<div class="form-group">
					<button class="btn btn-warning btn-block btn-lg" type="button" onclick="dummySubmit();return false">Update</button>
					{!! Form::submit('Update', ['class' => 'btn btn-warning btn-block btn-lg hide', 'id' => 'submit']) !!}
				</div>
            {!! Form::close() !!}
           @if(\Session::has('pesan'))
                <p class="m-t"> <code> {!! \Session::get('pesan') !!}</code> </p>
            @endif
        </div>
    </div>
   <!-- Mainly scripts -->
    {!! HTML::script('js/jquery-2.1.1.js')!!}
    {!! HTML::script('js/bootstrap.min.js')!!}
    {!! HTML::script('js/all.js')!!}
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(){
			if(validatePass()){
				$('#submit').click();
			}
		}
	</script>
</body>

</html>
