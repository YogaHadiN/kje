<div class="modal fade bs-example-modal-md" id="pasienInsert" tabindex="-1" role="dialog" aria-labelledby="kriteriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="kriteriaLabel">PASIEN INSERT</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                            {!! Form::open(['url' => 'pasiens', 'id' => 'pasienInsertForm', 'method' => 'post'])!!}
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                         <div class="form-group">
                                            {!! Form::label('nama', 'Nama Pasien')!!}
                                            {!! Form::text('nama', null, ['class' => 'form-control hh required', 'placeholder' => 'Masukkan nama tanpa gelar, tanpa nama panggilan'])!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('sex', 'Jenis Kelamin')!!}
                                            {!! Form::select('sex',[null => '- jenis kelamin -' , 'L' => 'Laki-laki', 'P' => 'Perempuan'], null, ['class' => 'form-control required'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                           {!!Form::label('status_pernikahan', 'Status Pernikahan')!!}
                                           {!! Form::select('status_pernikahan', $statusPernikahan, null, ['class' => 'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">

                                            {!! Form::label('tanggal_lahir', 'Tanggal Lahir')!!}
                                            {!! Form::text('tanggal_lahir', null, ['class' => 'form-control'])!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('nama_ibu', 'Nama Ibu')!!}
                                            {!! Form::text('nama_ibu', 'Nama Ibu', ['class' => 'form-control hh'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('nama_ayah', 'Nama Ayah')!!}
                                            {!! Form::text('nama_ayah', null, ['class' => 'form-control hh'])!!}
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('no_telp', 'Nomor Telepon')!!}
                                            {!! Form::text('no_telp', null, ['class' => 'form-control hh'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('panggilan', 'Panggilan')!!}
                                            {!! Form::select('panggilan', $panggilan, null, ['class' => 'form-control hh required'])!!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('punya_asuransi', 'Punya Asuransi')!!} <br>
                                            {!! Form::checkbox('punya_asuransi', 0, false, ['id' => 'CheckBox1'])!!}
                                        </div>
                                    </div>
                                </div>
                                 <div class="displayNone transition" id="xx">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-63">
                                            <div class="form-group">
                                              {!!Form::label('asuransi_id', 'Asuransi')!!}
                                              {!!Form::select('asuransi_id', $asuransi, null, ['class' => 'form-control'])!!}
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                                            <div class="form-group">
                                                {!! Form::label('jenis_peserta', 'Jenis Peserta')!!}

                                                {!! Form::select('jenis_peserta', $jenis_peserta, null, ['class' => 'form-control tog hh'])!!}
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                                            <div class="form-group">
                                                {!! Form::label('nomor_asuransi', 'Nomor Asuransi')!!}
                                                {!! Form::text('nomor_asuransi', null, ['class' => 'form-control tog hh'])!!}
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                                            <div class="form-group">
                                                {!! Form::label('nama_peserta', 'Nama Peserta')!!}
                                                {!! Form::text('nama_peserta', null, ['class'=>'form-control tog hh'])!!}
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            {!! Form::label('alamat', null)!!}
                                            {!! Form::textarea('alamat', null, ['class' => 'form-control textareacustom'])!!}
                                        </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="submitPasien">Submit</button>
                            <button type="button" class="btn btn-danger" id="closeModal" data-dismiss="modal">Cancel</button>

                            
                         {!! Form::close() !!}
            </div>
        </div>
        </div>
    </div>