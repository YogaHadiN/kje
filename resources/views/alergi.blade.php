<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">
            <div class="panelLeft">
                Daftar Alergi
            </div>	
            <div class="panelRight">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Alergi Obat
                </button>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Alergi</th>
                        <th class="fit">Action</th>
                    </tr>
                </thead>
                <tbody id="alergy_body_table">
                    @if($pasien->alergies->count() > 0)
                        @foreach($pasien->alergies as $alergi)
                            <tr>
                                <td class="nama_obat">{{ $alergi->generik->generik }}</td>
                                <td nowrap class="fit">
                                    <button class="btn btn-danger btn-sm" onclick="deleteAlergi('{{ $alergi->id }}', this);return false;" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada data ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
		  <div class="form-group @if($errors->has('gener')) has-error @endif">
		    {!! Form::label('generik_id', 'Nama Generik', ['class' => 'control-label']) !!}
            {!! Form::select('generik_id' , $generik_list, null, [
                 'data-live-search' => 'true',
                 'placeholder'      => '- Pilih -',
                 'class'            => 'form-control selectpick',
                 'onchange'         => 'generik_list_change();return false;',
                 'id'               => 'generik_list_alergi'
            ]) !!}
		    @if($errors->has('generik_id'))<code>{{ $errors->first('generik_id') }}</code>@endif
		  </div>
		  {{-- {!! Form::text('id_poli', $antrianperiksa->id, ['class' => 'form-control hide', 'id' => ]) !!} --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
        <button type="button" class="btn submit_button btn-primary disabled" onclick="submitAlergi(this);return false;">Simpan Alergi Obat</button>
      </div>
    </div>
  </div>
</div>
