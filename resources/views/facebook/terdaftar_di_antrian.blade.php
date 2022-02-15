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
			<div class="alert alert-success text-center">
			<p>Selamat Datang <h3>{{ $pasien->pasien->nama }}</h3> </p>
				<p>Anda telah terdaftar di antrian pasien</p>
				<p>dengan nomor antrian</p>
				<h2>{{ $pasien->antrian }}</h2>
			</div>
			{!! Form::open(['url' => 'facebook/antrian_polis/'. $pasien->id, 'method' => 'delete']) !!}
				{!! Form::submit('Batalkan Pendaftaran', [
				'class' => 'btn btn-danger btn-lg btn-block submit', 
				'onclick' => 'return confirm("Anda yakin ingin batal berobat?")', 
				'id' => 'submitDelete'
				]) !!}
			{!! Form::close() !!}
			

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
