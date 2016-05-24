 @extends('layout.master')

 @section('title') 
Klinik Jati Elok | sign Up

 @stop
 @section('head')

    <link href="{{ url('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
 @stop

 @section('page-title') 

 <h2>Pasien Baru</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('pasiens')}}">Pasien</a>
      </li>
      <li class="active">
          <strong>Pasien Baru</strong>
      </li>
</ol>
 @stop
 @section('content') 

 <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
     
            {!! Form::open(array(
                "url"   => "pasien",
                "class" => "m-t", 
                "role"  => "form",
                "method"=> "post"
            ))!!}
                
                <div class="form-group">
                    {!! Form::text('nama', null, array(
                        'class'         => 'form-control',
                        'placeholder'   => 'nama'
                    ))!!}
                    <code>{!! $errors->first('nama')!!}</code>
                </div>

                <div class="form-group">
                    {!! Form::textarea('alamat', null, array(
                        'class'         => 'form-control',
                        'placeholder'   => 'alamat'
                    ))!!}
                    <code>{!! $errors->first('alamat')!!}</code>
                </div>
                
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::input('date','tanggal_lahir', null, array(
                                'class'         => 'form-control datepicker',
                                'placeholder'   => 'Tanggal Lahir'
                            ))!!}
                            <code>{!! $errors->first('tanggal_lahir')!!}</code>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::select('jenis_kelamin', array(
                                null        => '- Jenis Kelamin -',
                                'L'         => 'laki-laki',
                                'P'         => 'perempuan',
                            ), null, array('class' => 'form-control'))!!}
                            <code>{!! $errors->first('no_telp')!!}</code>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::text('no_telp', null, array(
                                'class'         => 'form-control',
                                'placeholder'   => 'no_telp'
                            ))!!}
                            <code>{!! $errors->first('no_telp')!!}</code>
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::text('nama_ayah', null, array(
                                'class'         => 'form-control',
                                'placeholder'   => 'nama ayah'
                            ))!!}
                            <code>{!! $errors->first('nama_ayah')!!}</code>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::text('nama_ibu', null, array(
                                'class'         => 'form-control',
                                'placeholder'   => 'nama ibu'
                            ))!!}
                            <code>{!! $errors->first('nama_ibu')!!}</code>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::select('status_pernikahan', array(
                                null        => '- Status Pernikahan -',
                                'B'         => 'Belum Menikah',
                                'P'         => 'Pernah Manikah'
                            ), null, array('class' => 'form-control'))!!}
                            <code>{!! $errors->first('status_pernikahan')!!}</code>
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::select('asuransi_id', $asuransi, null, array(
                                'class'         => 'form-control', 
                                'placeholder'   => 'asuransi_id',
                                'title'         => 'asuransi'
                            ))!!}
                            <code>{!! $errors->first('asuransi_id')!!}</code>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            {!! Form::text('nama_peserta', null, array(
                                'class'         => 'form-control',
                                'placeholder'   => 'nama_peserta'
                            ))!!}
                            <code>{!! $errors->first('nama_peserta')!!}</code>
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            {!! Form::text('nomor_asuransi', null, array(
                                'class'         => 'form-control',
                                'placeholder'   => 'nomor asuransi'
                            ))!!}
                            <code>{!! $errors->first('nomor_asuransi')!!}</code>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            {!! Form::select('jenis_peserta', array(
                               null => '- Pilih Peserta -',
                                'P' => 'Peserta',
                                'S' => 'Suami',
                                'I' => 'Istri',
                                'A' => 'Anak'
                                ), null, array(
                                'class'         => 'form-control',
                                'placeholder'   => 'jenis peserta'
                            ))!!}
                            <code>{!! $errors->first('jenis_peserta')!!}</code>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::submit('submit', array(
                        'class' => 'btn btn-primary block full-width m-b'
                    ))!!}
                </div>
            {!! Form::close() !!}

        <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>

 </div>

 @stop
 @section('footer') 
    <!-- Data picker -->
   <script src="{{ url('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
    });
</script>

 @stop


       
