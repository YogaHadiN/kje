<div class="text-center">
    <div class="panel panel-info">
        <div class="panel-heading">
            FOTO KTP PASIEN
        </div>
        <div class="panel-body hide-panel">
            <div class="booth text-center">
                <video id='ktp_video' width='400px' height='300px'></video>
                <a href="#" id="ktp_capture" class="btn btn-primary" onclick="capture();return false;">Ambil Gambar</a> <br>
                <canvas id="ktp_canvas" width="400px" height="300px" class="hide"></canvas>
            </div>
        </div>
    </div>
    <div class="unhide-panel">
        <img src="{{ url('/') . $image }}?{{ time() }}" alt="" id="ktp_photo">
        <textarea name="image" id="ktp_image" cols="30" rows="10" class="hide"></textarea>
    </div>
</div>
