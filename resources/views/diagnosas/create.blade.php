 @extends('layout.master')

 @section('title') 
 Klinik Jati Elok | Asuransi Baru

 @stop
 @section('page-title') 
<h2>Edit Asuransi</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans') }}">Home</a>
      </li>
      <li>
          <a href="{{ url('diagnosas') }}">Asuransi</a>
      </li>
      <li class="active">
          <strong>Edit Diagnosa</strong>
      </li>
</ol>
 @stop
 @section('content') 
  {!! Form::open(array(
        "url"   => "asuransis/". $asuransi->id ,
        "class" => "m-t", 
        "role"  => "form",
        "method"=> "put"
        )) !!}
<div class="row">
 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                {!! Form::text('nama', $asuransi->nama, array(
                    'class'         => 'form-control',
                    'placeholder'   => 'Nama Asuransi'
                    )) !!}
                    <code>{!! $errors->first('nama') !!}</code>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                {!! Form::textarea('alamat', $asuransi->alamat, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'Alamat'
                    )) !!}
                    <code>{!! $errors->first('alamat') !!}</code>
                </div>
            </div>
        </div>
        
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                {!! Form::textarea('gigi', $asuransi->gigi, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'Gigi'
                    )) !!}
                    <code>{!! $errors->first('gigi') !!}</code>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <div class="form-group">
                {!! Form::textarea('laboratorium', $asuransi->laboratorium, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'Laboratorium'
                    )) !!}
                    <code>{!! $errors->first('laboratorium') !!}</code>
                </div>
            </div>
        </div>
      
    <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
             <div class="form-group">
                {!! Form::textarea('tindakan', $asuransi->tindakan, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'Tindakan'
                    )) !!}
                    <code>{!! $errors->first('tindakan') !!}</code>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="row">
           <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
              <div class="form-group">
                  {!! Form::text('no_telp', $asuransi->no_telp, array(
                      'class'         => 'form-control',
                      'placeholder'   => 'No Telp'
                      )) !!}
                      <code>{!! $errors->first('no_telp') !!}</code>
                  </div>
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                    {!! Form::text('pic',$asuransi->pic, array(
                        'class'         => 'form-control',
                        'placeholder'   => 'PIC'
                        )) !!}
                        <code>{!! $errors->first('pic') !!}</code>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        {!! Form::text('hp_pic', $asuransi->hp_pic, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'HP PIC'
                            )) !!}
                            <code>{!! $errors->first('hp_pic') !!}</code>
                        </div>
                    </div>
                </div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                    {!! Form::select('tipe_asuransi', App\Classes\Yoga::tipe_asuransi(), $asuransi->tipe_asuransi, array(
                        'class'         => 'form-control',
                        'placeholder'   => 'tipe_asuransi'
                        )) !!}
                        <code>{!! $errors->first('tipe_asuransi') !!}</code>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        {!! Form::text('tanggal_berakhir', App\Classes\Yoga::updateDatePrep($asuransi->tanggal_berakhir), array(
                            'class'         => 'form-control tanggal',
                            'placeholder'   => 'tanggal_berakhir'
                            )) !!}
                            <code>{!! $errors->first('tanggal_berakhir') !!}</code>
                        </div>
                    </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        {!! Form::email('email', $asuransi->email, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'Email'
                            )) !!}
                        <code>{!! $errors->first('email') !!}</code>
                    </div>
                </div>
            </div>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <div class="form-group">
                {!! Form::textarea('obat', $asuransi->obat, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'obat'
                    )) !!}
                    <code>{!! $errors->first('obat') !!}</code>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <div class="form-group">
                {!! Form::textarea('penagihan', $asuransi->penagihan, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'penagihan'
                    )) !!}
                    <code>{!! $errors->first('penagihan') !!}</code>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <div class="form-group">
                {!! Form::textarea('rujukan', $asuransi->rujukan, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'rujukan'
                    )) !!}
                    <code>{!! $errors->first('rujukan') !!}</code>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
                {!! Form::submit('submit', array(
                    'class' => 'btn btn-primary block full-width m-b'
                    )) !!}
				    {!! Form::close()  !!}

                </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
	            <div class="form-group">
					{!! HTML::link('asuransis', 'Cancel', array('class' => 'btn btn-warning block')) !!}
	            </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
            	{!! Form::open(['url' => 'asuransis/' . $asuransi->id, 'method' => 'delete']) !!}
	                {!! Form::submit('delete', array(
	                    'class' => 'btn btn-danger block full-width m-b',
	                    'onclick' => 'return confirm("Anda Yakin Mau Menghapus Asuransi '. $asuransi->nama .'?")'
	                    )) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

    <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>


    @stop
    @section('footer') 


    @stop
