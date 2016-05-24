
<div class="panel panel-default">
    <div class="panel-body">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id="tab2panel">
                <li role="presentation" class="active">
                    <a href="#Asuransi" aria-controls="Asuransi" role="tab" data-toggle="tab">Asuransi</a>
                </li>
                <li role="presentation">
                    <a href="#Tarif" aria-controls="Tarif" role="tab" data-toggle="tab">Tarif</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="Asuransi">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('nama', 'Nama Asuransi', ['style' => 'text-align:left'])!!}
                                        {!! Form::text('nama', null, array(
                                            'class'         => 'form-control',
                                            'placeholder'   => 'Nama Asuransi'
                                            ))!!}
                                            <code>{!! $errors->first('nama')!!}</code>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            {!! Form::label('alamat', 'Alamat', ['style' => 'text-align:left'])!!}
                                            {!! Form::textarea('alamat', null, array(
                                                'class'         => 'form-control textareacustom',
                                                'placeholder'   => 'Alamat'
                                                ))!!}
                                                <code>{!! $errors->first('alamat')!!}</code>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                {!! Form::label('umum', 'Umum', ['style' => 'text-align:left'])!!}
                                                {!! Form::textarea('umum', $umumstring, array(
                                                    'class'         => 'form-control textareacustom',
                                                    'placeholder'   => 'Umum'
                                                    ))!!}
                                                    <code>{!! $errors->first('umum')!!}</code>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    {!! Form::label('gigi', 'Gigi', ['style' => 'text-align:left'])!!}
                                                    {!! Form::textarea('gigi', $gigistring, array(
                                                        'class'         => 'form-control textareacustom',
                                                        'placeholder'   => 'Gigi'
                                                        ))!!}
                                                        <code>{!! $errors->first('gigi')!!}</code>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        {!! Form::label('no_telp', 'Nomor Telepon', ['style' => 'text-align:left'])!!}
                                                        {!! Form::text('no_telp', null, array(
                                                            'class'         => 'form-control',
                                                            'placeholder'   => 'No Telp'
                                                            ))!!}
                                                    <code>{!! $errors->first('no_telp')!!}</code>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    {!! Form::label('pic', 'PIC', ['style' => 'text-align:left'])!!}
                                                    {!! Form::text('pic',null, array(
                                                        'class'         => 'form-control',
                                                        'placeholder'   => 'PIC'
                                                        ))!!}
                                                    <code>{!! $errors->first('pic')!!}</code>
                                                </div>
                                            </div>
                                        </div>
                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                {!! Form::label('hp_pic', 'HP PIC', ['style' => 'text-align:left'])!!}
                                                                {!! Form::text('hp_pic', null, array(
                                                                    'class'         => 'form-control',
                                                                    'placeholder'   => 'HP PIC'
                                                                    ))!!}
                                                                    <code>{!! $errors->first('hp_pic')!!}</code>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    {!! Form::label('tipe_asuransi', 'Tipe Asuransi', ['style' => 'text-align:left'])!!}
                                                                    {!! Form::select('tipe_asuransi',array(
                                                                        null => '- Tipe Asuransi -',
                                                                        '1' => 'Admedika',
                                                                        '2' => 'Kapitasi',
                                                                        '3' => 'Perusahaan',
                                                                        '4' => 'Flat',
                                                                        '5' => 'BPJS',
                                                                        ), null, array(
                                                                        'class'         => 'form-control',
                                                                        'placeholder'   => 'tipe_asuransi'
                                                                        ))!!}
                                                                        <code>{!! $errors->first('tipe_asuransi')!!}</code>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <div class="form-group">
                                                                        {!! Form::label('tanggal_berakhir', 'Tanggal Berakhir', ['style' => 'text-align:left'])!!}
                                                                        {!! Form::text('tanggal_berakhir', $tanggal, array(
                                                                            'class'         => 'form-control tanggal',
                                                                            'placeholder'   => 'tanggal_berakhir'
                                                                            ))!!}
                                                                            <code>{!! $errors->first('tanggal_berakhir')!!}</code>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                        <div class="form-group">
                                                                            {!! Form::label('email', 'Email', ['style' => 'text-align:left'])!!}
                                                                            {!! Form::email('email', null, array(
                                                                                'class'         => 'form-control',
                                                                                'placeholder'   => 'Email'
                                                                                ))!!}
                                                                                <code>{!! $errors->first('email')!!}</code>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                            <div class="form-group">
                                                                                {!! Form::label('penagihan', 'Penagihan', ['style' => 'text-align:left'])!!}
                                                                                {!! Form::textarea('penagihan', $penagihanstring, array(
                                                                                    'class'         => 'form-control textareacustom',
                                                                                    'placeholder'   => 'penagihan'
                                                                                    ))!!}
                                                                                    <code>{!! $errors->first('Penagihan')!!}</code>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                                <div class="form-group">
                                                                                    {!! Form::label('rujukan', 'Rujukan', ['style' => 'text-align:left'])!!}
                                                                                    {!! Form::textarea('rujukan', $rujukanstring, array(
                                                                                        'class'         => 'form-control textareacustom',
                                                                                        'placeholder'   => 'Rujukan'
                                                                                        ))!!}
                                                                                        <code>{!! $errors->first('rujukan')!!}</code>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div role="tabpanel" class="tab-pane" id="Tarif">
                                                                    <div class="panel panel-info">
                                                                        <div class="panel-heading">
                                                                            <h3>TARIF</h3>
                                                                        </div>
                                                                        <div class="panel-body">
                                                                            <!-- Table -->
                                                                            <table class="table table-condensed table-bordered DT">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Jenis Tarif</th>
                                                                                        <th>Biaya</th>
                                                                                        <th>Jasa Dokter</th>
                                                                                        <th>Tipe Tindakan</th>
                                                                                        <th>Action</th>
                                                                                        <th class="hide">id</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="tblTarif">
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        {!! Form::submit($submit, array(
                                                            'class' => 'btn btn-primary block full-width m-b'
                                                            ))!!}
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                        {!! HTML::link('asuransis', 'Cancel', ['class' => 'btn btn-danger btn-block'])!!}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        {!! Form::textarea('tarifs', $tarifs, ['class' => 'form-control hide', 'id' => 'tarifs'])!!}
                                                    </div>
                                                </div>

