<div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#bulanan" aria-controls="bulanan" role="tab" data-toggle="tab">Bulanan</a></li>
        <li role="presentation"><a href="#duaMingguan" aria-controls="duaMingguan" role="tab" data-toggle="tab">2 Mingguan</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="bulanan">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    .
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    {!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 10, [
                        'class' => 'form-control',
                        'onchange' => 'asuransiChangeBulanan();return false;',
                        'id'    => 'displayed_rows_piutang_bulanan'
                    ]) !!}
                </div>

            </div>
            <br>
            <table id="table_riwayat_hutang_bulanan" class="table table-hover table-condensed table-bordered">
              <thead> 
                  <tr> 
                      <th>
                            <a 
                                class="getOrderPiutangBulanan"
                                data-column_name="bulan"
                                data-order="no"
                            >
                            Bulan
                            </a>
                          <br>
                          {!! Form::text('bulan', null, [
                              'class'   => 'form-control orderPiutangSearchParameterBulanan',
                              'id'      => 'bulan_bulanan'
                          ]) !!}
                      </th> 
                      <th>
                            <a 
                                class="getOrderPiutangBulanan"
                                data-column_name="piutang"
                                data-order="no"
                            >
                          Hutang
                            </a>
                          <br>
                          {!! Form::text('piutang', null, [
                              'class'   => 'form-control orderPiutangSearchParameterBulanan',
                              'id'      => 'piutang_bulanan'
                          ]) !!}
                      </th> 
                      <th>
                            <a 
                                class="getOrderPiutangBulanan"
                                data-column_name="sudah_dibayar"
                                data-order="no"
                            >
                          Sudah Dibayar
                            </a>
                          <br>
                          {!! Form::text('sudah_dibayar', null, [
                              'class'   => 'form-control orderPiutangSearchParameterBulanan',
                              'id'      => 'sudah_dibayar_bulanan'
                          ]) !!}
                      </th>
                      <th> 
                            <a 
                                class="getOrderPiutangBulanan"
                                data-column_name="sisa"
                                data-order="no"
                            >
                            Sisa
                            </a>
                          <br>
                          {!! Form::text('sisa', null, [
                              'class'   => 'form-control orderPiutangSearchParameterBulanan',
                              'id'      => 'sisa_bulanan'
                          ]) !!}
                      </th> 
                  </tr> 
              </thead>
              <tbody id="riwayatHutangBulanan">

              </tbody>
          </table>
           <ul id="pagination-twbs-bulanan" class="pagination-sm"></ul>
        </div>
        <div role="tabpanel" class="tab-pane" id="duaMingguan">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    
                    .
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    {!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 10, [
                        'class' => 'form-control',
                        'onchange' => 'asuransiChange();return false;',
                        'id'    => 'displayed_rows_piutang'
                    ]) !!}
                </div>

            </div>
            <br>
            <table id="table_riwayat_hutang" class="table table-hover table-condensed table-bordered">
                  <thead> 
                      <tr> 
                          <th>
                                <a 
                                    class="getOrderPiutang"
                                    data-column_name="bulan"
                                    data-order="no"
                                >
                                Bulan
                                </a>
                              <br>
                              {!! Form::text('bulan', null, [
                                  'class'   => 'form-control orderPiutangSearchParameter',
                                  'id'      => 'bulan'
                              ]) !!}
                          </th> 
                          <th>Periode </th> 
                          <th>
                                <a 
                                    class="getOrderPiutang"
                                    data-column_name="piutang"
                                    data-order="no"
                                >
                              Hutang
                                </a>
                              <br>
                              {!! Form::text('piutang', null, [
                                  'class'   => 'form-control orderPiutangSearchParameter',
                                  'id'      => 'piutang'
                              ]) !!}
                          </th> 
                          <th>
                                <a 
                                    class="getOrderPiutang"
                                    data-column_name="sudah_dibayar"
                                    data-order="no"
                                >
                              Sudah Dibayar
                                </a>
                              <br>
                              {!! Form::text('sudah_dibayar', null, [
                                  'class'   => 'form-control orderPiutangSearchParameter',
                                  'id'      => 'sudah_dibayar'
                              ]) !!}
                          </th>
                          <th> 
                                <a 
                                    class="getOrderPiutang"
                                    data-column_name="sisa"
                                    data-order="no"
                                >
                                Sisa
                                </a>
                              <br>
                              {!! Form::text('sisa', null, [
                                  'class'   => 'form-control orderPiutangSearchParameter',
                                  'id'      => 'sisa'
                              ]) !!}
                          </th> 
                      </tr> 
                  </thead>
                  <tbody id="riwayatHutang">

                  </tbody>
              </table>
               <ul id="pagination-twbs" class="pagination-sm"></ul>
        </div>
    </div>
</div>
