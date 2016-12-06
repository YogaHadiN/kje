<div class="modal fade" id="modal-alasan">
	@if(isset($antrianperiksa))
		{!! Form::open(['url' => $antrianperiksa, 'method' => 'delete']) !!}
	@else
		{!! Form::open(['url' => 'fasilitas/antrianpolis/destroy', 'method' => 'delete']) !!}
	@endif
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Kenapa Pasien Dihapus Dari Antrian? ini
				<div class="modal-body">

						{!! Form::textarea('alasan_kabur', null, ['class' => 'form-control textareacustom alasan_textarea'])!!}
						{!! Form::hidden('id', null, ['class' => 'form-control id'])!!}
						{!! Form::hidden('pasien_id', null, ['class' => 'form-control pasien_id'])!!}
					
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<button type="button" class="btn btn-success btn-block dummySubmit">Hapus</button>
							<button type="submit" class="submit hide">Hapus</button>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<button type="button" class="btn btn-danger btn-block">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>  
{!! Form::close() !!}
</div>
