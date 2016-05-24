<html>
<head>
    <meta charset="UTF-8">
    <title>Monitor Survey</title>
    <link href="{!! url('css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('css/animate.css') !!}" rel="stylesheet">
    <link href="{!! url('css/style.css') !!}" rel="stylesheet">
</head>
<body>
<div class="row survey">
<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">

    <a href="" onclick="puas();return false;">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 green-bg maxHeight displayContainer centerPseudo">
            <div class="img">
                </span><img src="{!! url('images/smile.jpg') !!}" alt="">
                <h2>Puas</h2>
            </div>
        </div>
    </a>
    <a href="" onclick="biasa();return false;">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 yellow-bg maxHeight displayContainer centerPseudo">
            <div class="img">
                </span><img src="{!! url('images/notsmile.png') !!}" alt="">
                <h2>Biasa Saja</h2>
            </div>
        </div>
    </a>
    <a href="" onclick="tidak();return false;">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 red-bg maxHeight displayContainer centerPseudo">
            <div class="img">
                </span><img src="{!! url('images/mad.jpg') !!}" alt="">
                <h2>Kecewa</h2>
            </div>
        </div>
    </a>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg displayNone" data-toggle="modal" id="modalShow1" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h4 class="modal-title" id="myModalLabel">Layar Pemberitahuan</h4> -->
      </div>
      <div class="modal-body" style="text-align:center;">
        
            <h1>Mohon Tunggu Petugas Kami Siapkan Dulu.. Terima kasih.. </h1>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default displayNone" data-dismiss="modal" id="modalHide1">Close</button>
        <button type="button" class="btn btn-primary displayNone">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg displayNone" data-toggle="modal" id="modalShow2" data-target="#myModal2">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h4 class="modal-title" id="myModalLabel">Layar Pemberitahuan</h4> -->
      </div>
      <div class="modal-body" style="text-align:center;">
        
            <h1>Terima Kasih Atas Partisipasi Anda.. </h1>
            <img src="{!!url('img\thanks.jpg')!!}" width="200px" height="200px" />

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default displayNone" data-dismiss="modal" id="modalHide2">Close</button>
        <button type="button" class="btn btn-primary displayNone">Save changes</button>
      </div>
    </div>
  </div>
</div>



    
<script src="{!! url('js/jquery-2.1.1.js') !!}"></script>
<script src="{!! url('js/bootstrap.min.js') !!}"></script>
    <script>
        function puas(){
            $.post('{!! url("monitors/puas") !!}', { '_token' : '{{ Session::token() }}'}, function(data) {
                data = $.trim(data);
                if( data == '0' ){
                    console.log('gagal');

                    $("#modalShow1").click();
                    setTimeout(function () {
                        $('#modalHide1').click();
                    }, 2000)
                } else {
                    console.log('berhasil');

                   $("#modalShow2").click();
                    setTimeout(function () {
                        $('#modalHide2').click();
                    }, 2000)
                }
            });
            
        }
        function biasa(){
            $.post('{!! url("monitors/biasa") !!}', {}, function(data) {
                data = $.trim(data);
                if( data == '0' ){
                    console.log('gagal');
                    $("#modalShow1").click();
                    setTimeout(function () {
                        $('#modalHide1').click();
                    }, 2000)
                } else {
                    console.log('berhasil');
                   $("#modalShow2").click();
                    setTimeout(function () {
                        $('#modalHide2').click();
                    }, 2000)
                }
            });

            
        }
        function tidak(){
            $.post('{!! url("monitors/kecewa") !!}', {}, function(data) {
                data = $.trim(data);
                if( data == '0' ){
                    console.log('gagal');
                    $("#modalShow1").click();
                    setTimeout(function () {
                        $('#modalHide1').click();
                    }, 2000)
                } else {
                    console.log('berhasil');
                   $("#modalShow2").click();
                    setTimeout(function () {
                        $('#modalHide2').click();
                    }, 2000)
                }
            });

            
        }
    </script>
</body>
</html>