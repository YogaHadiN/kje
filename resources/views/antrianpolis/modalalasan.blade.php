<div class="modal fade" id="modal-alasan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Kenapa Pasien Dihapus Dari Antrian?
            <div class="modal-body">
                {!! Form::textarea('alasan', null, ['class' => 'form-control textareacustom', 'id' => 'alasan_textarea'])!!}
                {!! Form::hidden('id', null, ['class' => 'form-control', 'id' => 'alasan_id'])!!}
                {!! Form::hidden('submit_id', null, ['class' => 'form-control', 'id' => 'submit_id'])!!}
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <button type="button" class="btn btn-success btn-block" onclick='hapusSajalah();return false;'>Hapus</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <button type="button" class="btn btn-danger btn-block" onclick="$('#modal-alasan').modal('hide');return false;">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
</div>