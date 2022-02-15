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
                <h4 class="modal-title">Kenapa Pasien Dihapus Dari Antrian ini?
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('staf_id'))has-error @endif">
								{!! Form::label('staf_id', 'Nama Petugas', ['class' => 'control-label']) !!}
								{!! Form::select('staf_id', App\Models\Staf::list(), null, array(
									'class'         => 'form-control rq'
								))!!}
							  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('alasan_kabur'))has-error @endif">
								{!! Form::label('alasan_kabur', 'Alasan', ['class' => 'control-label']) !!}
								{!! Form::textarea('alasan_kabur', null, array(
									'class'         => 'form-control rq textareacustom'
								))!!}
							  @if($errors->has('alasan_kabur'))<code>{{ $errors->first('alasan_kabur') }}</code>@endif
							</div>
						</div>
					</div>
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
