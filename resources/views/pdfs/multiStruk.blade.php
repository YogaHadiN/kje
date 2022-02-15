<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
		<title>Cetak Struk Massal</title>
		<link href="{!! asset('css/struk.css') !!}" rel="stylesheet">
    </head>
    <body>
		@foreach($periksas as $periksa)
			<div style="page-break-after:always;">
				@include('pdfs.formStruk')	
			</div>
		@endforeach
		@foreach($nota_juals as $nota_jual)
			<div style="page-break-after:always;">
				@include('pdfs.penjualanForm')	
			</div>
		@endforeach
		@foreach($pendapatans as $pendapatan)
			<div style="page-break-after:always;">
				@include('pdfs.pendapatanForm')	
			</div>
		@endforeach
	</body>
</html>


