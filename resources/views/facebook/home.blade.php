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

            @if(\Session::has('pesan'))
                <p class="m-t"> <code> {!! \Session::get('pesan') !!}</code> </p>
            @endif
			
			<h2>Login dengan Facebook</h2>
			<h2>Login dengan Twitter</h2>

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
