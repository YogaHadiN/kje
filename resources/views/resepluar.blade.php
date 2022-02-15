<div class="modal fade" tabindex="-1" role="dialog" id="resepluar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Resep Luar</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Resep Luar</div>
            </div>
            <div class="panel-body">
                {!! Form::textarea('resepluar', null, ['class' => 'form-control']) !!}
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
