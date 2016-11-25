<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
Klinik Jati Elok | Gambar Estetika
</title>
    {!! HTML::style('css/all.css')!!}

</head>

<body class="gray-bg">

<h2>Gambar Estetika</h2>
	{!! Form::open([
		'url'		=> 'antrianperiksa/' . $antrianperiksa->id . '/images', 
		'method'	=> 'post', 
		'files'		=> 'true'
	]) !!}
	@include('images.form', [
		'antrianperiksa' => $antrianperiksa,
		'periksa' => $antrianperiksa,
	])
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
