<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
{{ env("NAMA_KLINIK") }} | Edit Gambar Periksa
</title>
    {!! HTML::style('css/all.css')!!}
</head>

<body class="gray-bg">

	<h2>Edit Gambar Periksa</h2>
	{!! Form::open([
		'url'		=> 'antrianperiksa/' . $antrianperiksa->id . '/images', 
		'method'	=> 'put', 
		'files'		=> 'true'
	]) !!}
	@include('images.form', [
		'antrianperiksa' => $antrianperiksa,
		'periksa' => $antrianperiksa,
	])
	{!! Form::close() !!}
	@include('gambar_periksa')

    <!-- Mainly scripts -->

	<script type="text/javascript" charset="utf-8">
		var gambars = '{!!  json_encode( $antrianperiksa->gambars ) !!}';
	</script>
	{!! HTML::script('js/all.js')!!} 
	{!! HTML::script('js/gambar_periksa.js')!!} 
	{!! HTML::script('js/inputGambar.js')!!} 
</body>

</html>
