<div class="modal fade" tabindex="-1" role="dialog" id="create_supplier">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buat Supplier Baru</h4>
      </div>
      <div class="modal-body">
          @include('suppliers.form', ['submit' => 'SUBMIT'])
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
