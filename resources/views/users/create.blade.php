<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat User Baru</title>
    {!! HTML::style('css/bootstrap.min.css')!!}
    {!! HTML::style('font-awesome/css/font-awesome.css')!!}
    {!! HTML::style('css/animate.css')!!}
    {!! HTML::style('css/style.css')!!}
</head>
<body class="gray-bg">
<div class="row">
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Buat Akun Baru</div>
            </div>
            <div class="panel-body">

                {!! Form::open(array(
                "url"   => "users",
                "class" => "m-t", 
                "role"  => "form",
                "method"=> "post"
                ))!!}
                    @include('users.form', ['create'=>true])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


    <!-- Mainly scripts -->

    {!! HTML::script('js/jquery-2.1.1.js')!!}
    {!! HTML::script('js/bootstrap.min.js')!!}

</body>

</html>
