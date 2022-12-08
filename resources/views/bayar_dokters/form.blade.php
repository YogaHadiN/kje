 <div class="table-responsive">
    <div class="row">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            Ditemukan <span id="rows_found"></span> data
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            {!! Form::select('name', App\Models\Classes\Yoga::manyRows(), 15, [
                'class'    => 'form-control',
                'id'       => 'displayed_rows',
                'onchange' => 'clearAndView();return false;'
            ]) !!}
        </div>
    </div>
    <table class="table table-striped table-bordered table-hover " id="tableAsuransi">
      <thead>
        <tr>
          <th>ID</th>
          <th>
            Tanggal
            {!! Form::text('tanggal', null, [
              'class' => 'ajaxChange form-control', 
              'onkeyup' => 'clearAndView();return false;',
              'id' => 'tanggal'
            ]) !!}
          </th>
          <th>
            Nama Dokter
            {!! Form::text('nama_dokter', null, [
              'class'   => 'ajaxChange form-control',
              'onkeyup' => 'clearAndView();return false;',
              'id'      => 'nama_dokter'
            ]) !!}
          </th>
          <th>
            Pembayaran
            {!! Form::text('pembayaran', null, [
              'class'   => 'ajaxChange form-control',
              'style'=>"text-align:right;",
              'onkeyup' => 'clearAndView();return false;',
              'id'      => 'pembayaran']) !!}
          </th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="content"></tbody>
    </table>
  </div>
  <div id="page-box">
      <nav class="text-right" aria-label="Page navigation" id="paging">
      
      </nav>
  </div>
