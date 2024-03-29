<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
{{ ucwords( \Auth::user()->tenant->name ) }} | Edit Gambar Periksa
</title>
    {!! HTML::style('css/all.css')!!}
  {{--   <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"> --}}

</head>

<body class="gray-bg">

	{!! Form::open([
		'url'		=> 'periksa/' . $periksa->id . '/images', 
		'method'	=> 'put', 
		'files'		=> 'true'
	]) !!}
		@include('images.form')
	{!! Form::close() !!}
	@include('gambar_periksa')

    <!-- Mainly scripts -->

	{!! HTML::script('js/all.js')!!} 
	<script type="text/javascript" charset="utf-8">
		var gambars = '{!!  json_encode( $periksa->gambars ) !!}';
	</script>
	{!! HTML::script('js/gambar_periksa.js')!!} 
	{!! HTML::script('js/inputGambar.js')!!} 
</body>

</html>
