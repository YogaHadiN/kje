<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <!-- Data Tables 
    <link href="{!! asset('css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/bootstrap-select.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/plugins/dataTables/dataTables.bootstrap.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/plugins/dataTables/dataTables.responsive.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/plugins/dataTables/dataTables.tableTools.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/animate.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/style.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/jquery-ui.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/plugins/datepicker/datepicker3.css') !!}" rel="stylesheet">
    
    -->
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
						<a href="{{ url('antrianpolis')}}">
							<div class="widget style1 blue-bg btn-success">
									<div class="row">
										<div class="col-xs-4 text-center">
										
										<h1>{{ $ap->antrian }}</h1>
										</div>
										<div class="col-xs-8 text-left">
											<h1>{{ $ap->pasien->nama }}</h1>
										</div>
									</div>
							</div>
						</a>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</body>
</html>
