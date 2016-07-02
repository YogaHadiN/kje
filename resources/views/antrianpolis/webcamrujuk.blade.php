<div class="text-center">
    <div class="panel panel-info">
        <div class="panel-heading">
            Edit Foto Rujukan 
        </div>
        <div class="panel-body hide-panel">
            <div class="booth text-center">
                <video id='video' width='400px' height='300px'></video>
                <br>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <a href="#" id="capture" class="btn btn-block btn-sm btn-primary" onclick="capture();return false;">Ambil Gambar Rujukan</a>
                    </div>
                </div>
                <canvas id="canvas" width="400px" height="300px" class="hide"></canvas>
            </div>
        </div>
    </div>
    <div class="unhide-panel">
        <h3>Gambar Rujukan</h3>
        <img src="{{ url('/') . $image }}?{{ time() }}" alt="" id="photo">
        <textarea name="image" id="image" cols="30" rows="10" class="hide"></textarea>
    </div>
</div>
