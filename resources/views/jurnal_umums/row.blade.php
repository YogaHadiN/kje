<tr class="kuitansi">
	<td>Kuitans : </td>
	<td colspan="3"> 
		<a href="{{ \Storage::disk('s3')->url('img/belanja/lain/'. $ju->jurnalable->faktur_image) }}" target="_blank">
			<img src="{{ \Storage::disk('s3')->url('img/belanja/lain/'. $ju->jurnalable->faktur_image) }}" class="img-rounded upload"> 
		</a>
	</td>
	<td>{{ $ju->jurnalable->faktur_image }}</td>
</tr>
<tr class="rowTr">
  <td class="hide field_id">{!! $ju->id !!}</td>
  <td class="hide key">{!! $k !!}</td>
  <td>
	  {!! $ju->created_at !!} <br />
	  Jurnalable type : <br />
	  {!! $ju->jurnalable_type !!} <br />
	  Jurnalable id : <br />
	  {!! $ju->jurnalable_id !!}
  </td>
  <td>{!! $ju->jurnalable->staf->nama !!}</td>
  <td class="keterangan">{!! $ju->jurnalable->ketJurnal !!}</td>
  <td class="uang">{!! $ju->nilai !!}</td>
  <td>
	  {!! Form::select('coa', $coa_list, null, [
			'class'            => 'form-control rq selectpick kode_coa',
			'onchange'         => 'coaChange(this); return false;',
			'data-live-search' => 'true'
	]) !!}
  </td> 
</tr>
