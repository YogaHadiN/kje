<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
					<button type="button" class="btn btn-success" id="processing-warning" onclick="return false;">Done</button>
                </div>
				@if( $createLink )
                <div class="panelRight">
                <a href="#" type="button" class="btn btn-info" data-toggle="modal" data-target="#kriteria"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Parameter Pencarian</a>
                @if(isset($antrian))
					<a href="{{ url( "antrians/{$antrian->id}/pasiens/create" ) }}" type="button" class="btn btn-success">
				@else
					<a href="{{ url( 'pasiens/create' ) }}" type="button" class="btn btn-success">
				@endif
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> PASIEN Baru</a>
                <a href="#" type="button" class="btn btn-success hide" data-toggle="modal" data-target="#pasienInsert"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> PASIEN Baru</a>
                </div>
				@endif
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
			  <div class="row">
			  	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
			  		Menampilkan <span id="rows"></span> hasil
			  	</div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
                    {!! Form::open(['url' => 'pasiens/ajax/ajaxpasiens', 'method' => 'get', 'id' => 'ajaxkeyup', 'autocomplete' => 'off'])!!}
					{!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
						'class' => 'form-control',
						'onchange' => 'clearAndSelectPasien();return false;',
						'id'    => 'displayed_rows'
					]) !!}
				</div>
			  </div>
              <br>
            <table class="table table-bordered table-hover" id="tablePasien">
                  <thead>
                    <tr>
                        <th class="displayNone">
                           No Status<br>
                           {!! Form::text('id', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'id'])!!}
                        </th>
                        <th class="nama_pasien">
                            Nama Pasien <br>
                           {!! Form::text('nama', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama'])!!}
                        </th>
                        <th class="kolom_2">
                            Alamat <br>
                           {!! Form::text('alamat', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'alamat'])!!}
                        </th>
                        <th class="kolom_3">
                            Tanggal Lahir <br>
                           {!! Form::text('tanggal_lahir', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'tanggal_lahir'])!!}
                        </th>
                        <th class="no_telp">
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
                        <th class="action">Sudah Kontak <br> 
							{!! Form::select('sudah_kontak',[
								null => '- Pilih -',
								1 => 'Sudah',
								0 => 'Belum'
							], null, [
								'class'    => 'form-control',
								'onchange' => 'clearAndSelectPasien();return false;'
						]) !!}
						</th>
                    {!! Form::close()!!}
                    </tr>
                </thead>
                <tbody id="ajax">
                  
                </tbody>
            </table>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div id="page-box">
						<nav class="text-right" aria-label="Page navigation" id="paging">
						
						</nav>
					</div>
				</div>
			</div>
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
@if (isset($poli))
	@include('pasiens.modal_antrian_poli_insert')  
@endif
