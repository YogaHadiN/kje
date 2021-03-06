<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : </h3>
                </div>
				@if( $createLink )
                <div class="panelRight">
                <a href="#" type="button" class="btn btn-info" data-toggle="modal" data-target="#kriteria"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Parameter Pencarian</a>
                <a href="{{ url( 'pasiens/create' ) }}" type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> PASIEN Baru</a>
                <a href="#" type="button" class="btn btn-success hide" data-toggle="modal" data-target="#pasienInsert"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> PASIEN Baru</a>
                </div>
				@endif
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tablePasien">
                  <thead>
                    <tr>
                    {!! Form::open(['url' => 'pasiens/ajax/ajaxpasiens', 'method' => 'get', 'id' => 'ajaxkeyup', 'autocomplete' => 'off'])!!}

                        <th class="displayNone">
                           No Status<br>
                           {!! Form::text('id', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'id'])!!}
                        </th>
                        <th>
                            Nama Pasien <br>
                           {!! Form::text('nama', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama'])!!}
                        </th>
                        <th>
                            Alamat <br>
                           {!! Form::text('alamat', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'alamat'])!!}
                        </th>
                        <th>
                            Tanggal Lahir <br>
                           {!! Form::text('tanggal_lahir', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'tanggal_lahir'])!!}
                        </th>
                        <th>
                            No Telp <br>
                           {!! Form::text('no_telp', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'no_telp'])!!}
                        </th>
                        <th class="displayNone">
                            Nama Asuransi <br>
                           {!! Form::text('nama_asuransi', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_asuransi'])!!}
                        </th>
                        <th class="displayNone">
                            No Asuransi <br>
                           {!! Form::text('nomor_asuransi', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nomor_asuransi'])!!}
                        </th>
                        <th class="displayNone">
                            Nama Peserta <br>
                           {!! Form::text('nama_peserta', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_peserta'])!!}
                        </th>
                        <th class="displayNone">
                            Nama Ibu <br>
                           {!! Form::text('nama_ibu', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_ibu'])!!}
                        </th>
                        <th class="displayNone">
                            Nama Ayah <br>
                           {!! Form::text('nama_ayah', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_ayah_Input'])!!}
                        </th>
                        <th class="displayNone">Asuransi ID</th>
                        <th>Action <br> <button class="btn btn-danger  btn-block" id="clear">clear</button></th>

                    {!! Form::close()!!}
                    </tr>
                </thead>
                <tbody id="ajax">
                  
                </tbody>
            </table>
		  </div>
      </div>
	</div>
     <div class="modal fade bs-example-modal-sm" id="kriteria" tabindex="-1" role="dialog" aria-labelledby="kriteriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="kriteriaLabel">Tambahkan Kriteria Pencarian</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt" value="Nomor Status">Nomor Status</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt" value="Nama Asuransi">Nama Asuransi</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt" value="Nama Peserta">Nama Peserta</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt" value="Nomor Asuransi">Nomor Asuransi</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt" value="Nama Ibu">Nama Ibu</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" autocomplete="off" name="opt"value="Nama Ayah">Nama Ayah</label>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Selesai</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Masukkan ke antrian</h4>
			</div>
			<div class="modal-body">
				@include('pasiens.antrianpoli_insert')
			</div>
		</div>
	</div>
</div>  
