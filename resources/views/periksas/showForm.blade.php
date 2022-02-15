	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">
				Upload Berkas Pemeriksaan
			</div>
		</div>
		<div class="panel-body">
			<input type="input" name="" class="hide" id="periksa_id" value="{{ $periksa->id }}" />
			<form enctype="multipart/form-data">
				{!! Form::text('nama_file', null, [
					'class'       => 'form-control',
					'placeholder' => 'Berkas ini tentang apa? (Format PDF)',
					'id'          => 'nama_file'
				]) !!}
				<input name="file" type="file" id="file_upload_periksa" />
			</form>
			<div class="progress">
			  <div class="progress-bar" id="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
					0%
			  </div>
			</div>
			<div>
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<tbody id="download_container">
							@if( !is_null($periksa->berkas) && $periksa->berkas->count() > 0 )
								@foreach($periksa->berkas as $berkas)
									<tr>
										<td><a class="btn btn-block btn-{{ $warna[ rand(0, count($warna) -1) ] }}" href="{{ \Storage::disk('s3')->url($berkas->url) }}" target="_blank">Download {{ $berkas->nama_file }}</a></td>
										<td nowrap class="autofit"><button type="button" onclick="deleteBerkas({{ $berkas->id }}, this); return false;" class="btn btn-danger"> <i class="glyphicon glyphicon-remove"></i> </button></td>
									</tr>
								@endforeach
							@else
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
