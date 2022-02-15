<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
{{ env("NAMA_KLINIK") }} | Gambar Periksa
</title>
    {!! HTML::style('css/all.css')!!}
  {{--   <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"> --}}

</head>

<body class="gray-bg">

<h2>Gambar Periksa</h2>
	{!! Form::open([
		'url'		=> 'periksa/' . $periksa->id . '/images', 
		'method'	=> 'post', 
		'files'		=> 'true'
	]) !!}
		@include('images.form')
	{!! Form::close() !!}
	@include('gambar_periksa')

    <!-- Mainly scripts -->

	{!! HTML::script('js/all.js')!!} 
<script type="text/javascript" charset="utf-8">
	tambahGambar();
	function dummySubmit(){
		 $('#submit').click();
	}
</script>
	{!! HTML::script('js/gambar_periksa.js')!!} 
	{!! HTML::script('js/inputGambar.js')!!} 
</body>

</html>
