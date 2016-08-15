<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <link href="{!! asset('css/all.css') !!}" rel="stylesheet" media="screen">

<link href="{!! asset('font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet">

    @yield('head')
</head>
<body>
	<div class="page-wrapper">
		<div class="wrapper white-bg">
			@foreach($antrianperiksa as $k =>$ap)
			<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="widget blue-bg btn-success">
							<div class="row">
								<div class="col-xs-4 text-center">

									<h1>{{ $ap->antrian }}</h1>
								</div>
								<div class="col-xs-8 text-left">
									<h1>{{ $ap->pasien->nama }}</h1>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
<script src="{!! asset('js/all.js') !!}"></script>
</body>
</html>
