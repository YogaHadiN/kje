<div class="panel panel-info">
	<div class="panel-heading">
		<div class="panelLeft">
			<div class="panel-title">Peraturan Penyusutan</div>
		</div>
		<div class="panelRight">
		</div>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed">
				<tbody>
					@foreach( $penyusutan as $p )
					<tr>
						<th nowrap>{{ $p->golongan_peralatan }}</th>
						<td>{{ $p->keterangan }}</td>
						<td>
							<ul>
								@foreach( $p->keteranganPenyusutan as $k )
								<li>{{ $k->keterangan }}</li>
								@endforeach
							</ul>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
