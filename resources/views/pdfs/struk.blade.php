<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk {{ $periksa->id }} | {{ $periksa->pasien->nama }}</title>
		<link href="{!! asset('css/struk.css') !!}" rel="stylesheet">
    </head>
    <body>
		@include('pdfs.formStruk')	
	</body>
</html>
