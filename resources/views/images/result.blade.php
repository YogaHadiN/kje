<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
{{ env("NAMA_KLINIK") }} | Gambar Periksa
</title>
    {!! HTML::style('css/all.css')!!}
</head>

<body class="gray-bg">

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		@if (Session::has('pesan'))
			{!! Session::get('pesan')!!}
		@endif
	</div>
</div>


	{!! HTML::script('js/all.js')!!} 
</body>

</html>
