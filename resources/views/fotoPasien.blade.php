<div class="panel-image text-center">
    @if(isset($pasien->image))
        <img src="{!! \Storage::disk('s3')->url($pasien->image)!!}" alt="" width="280px" height="210px" id="fotoPasien" onclick="showFotoZoom(); return false;">
    @else
        <img src="{!! \Storage::disk('s3')->url('img/notfound.jpg')!!}" alt="" >
    @endif
    <br><br>
    <div class="alert alert-info">
        <h3>{!! $pasien->nama !!}  </h3> <span id="umur">{!! App\Models\Classes\Yoga::datediff($pasien->tanggal_lahir->format('Y-m-d'), date('Y-m-d')) !!}</span>
    </div>
</div>

<a class="btn btn-primary hide" data-toggle="modal" href='#fotozoom'>Trigger modal</a>
<div class="modal" id="fotozoom">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">{!! $pasien->nama !!}</h4>
			</div>
			<div class="modal-body">
                <img src="{{ \Storage::disk('s3')->url($pasien->image) }}" alt="" width="500px" height="375px">
			</div>
		</div>
	</div>
</div>
<script charset="utf-8">
    function showFotoZoom() {
        $("#fotozoom").modal("show");
    }
</script>
