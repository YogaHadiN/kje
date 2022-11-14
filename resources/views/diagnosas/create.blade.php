 @extends('layout.master')

 @section('title') 
 {{ ucwords( \Auth::user()->tenant->name ) }} | Asuransi Baru

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
				<div class="form-group @if($errors->has('nama'))has-error @endif">
					{!! Form::text('nama', $asuransi->nama, array(
						'class'         => 'form-control',
						'placeholder'   => 'Nama Asuransi'
                    )) !!}
			     @if($errors->has('name'))<code>{{ $errors->first('nama') }}</code>@endif
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			   <div class="form-group @if($errors->has('alamat'))has-error @endif">
                {!! Form::textarea('alamat', $asuransi->alamat, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'Alamat'
                    )) !!}
			     @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
			   </div>
            </div>
        </div>
        
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			   <div class="form-group @if($errors->has('gigi'))has-error @endif">
                {!! Form::textarea('gigi', $asuransi->gigi, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'Gigi'
                    )) !!}
			     @if($errors->has('gigi'))<code>{{ $errors->first('gigi') }}</code>@endif
			   </div>
            </div>
        </div>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			   <div class="form-group @if($errors->has('laboratorium'))has-error @endif">
                {!! Form::textarea('laboratorium', $asuransi->laboratorium, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'Laboratorium'
                    )) !!}
			     @if($errors->has('laboratorium'))<code>{{ $errors->first('laboratorium') }}</code>@endif
			   </div>
            </div>
        </div>
		<div class="row">
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				 <div class="form-group @if($errors->has('tindakan'))has-error @endif">
					{!! Form::textarea('tindakan', $asuransi->tindakan, array(
						'class'         => 'form-control textareacustom',
						'placeholder'   => 'Tindakan'
						)) !!}
				   @if($errors->has('tindakan'))<code>{{ $errors->first('tindakan') }}</code>@endif
				 </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="row">
           <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			   <div class="form-group @if($errors->has('no_telp'))has-error @endif">
                  {!! Form::text('no_telp', $asuransi->no_telp, array(
                      'class'         => 'form-control',
                      'placeholder'   => 'No Telp'
				  )) !!}
			     @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
			   </div>
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				  <div class="form-group @if($errors->has('pic'))has-error @endif">
                    {!! Form::text('pic',$asuransi->pic, array(
                        'class'         => 'form-control',
                        'placeholder'   => 'PIC'
                        )) !!}
				    @if($errors->has('pic'))<code>{{ $errors->first('pic') }}</code>@endif
				  </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="form-group @if($errors->has('hp_pic'))has-error @endif">
                        {!! Form::text('hp_pic', $asuransi->hp_pic, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'HP PIC'
                            )) !!}
					  @if($errors->has('hp_pic'))<code>{{ $errors->first('hp_pic') }}</code>@endif
					</div>
                    </div>
                </div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group @if($errors->has('tipe_asuransi'))has-error @endif">
                    {!! Form::select('tipe_asuransi', App\Models\Classes\Yoga::tipe_asuransi(), $asuransi->tipe_asuransi, array(
                        'class'         => 'form-control',
                        'placeholder'   => 'tipe_asuransi'
                        )) !!}
				  @if($errors->has('tipe_asuransi'))<code>{{ $errors->first('tipe_asuransi') }}</code>@endif
				</div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="form-group @if($errors->has('tanggal_berakhir'))has-error @endif">
                        {!! Form::text('tanggal_berakhir', App\Models\Classes\Yoga::updateDatePrep($asuransi->tanggal_berakhir), array(
                            'class'         => 'form-control tanggal',
                            'placeholder'   => 'tanggal_berakhir'
                            )) !!}
					  @if($errors->has('tanggal_berakhir'))<code>{{ $errors->first('tanggal_berakhir') }}</code>@endif
					</div>
                    </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="form-group @if($errors->has('email'))has-error @endif">
                        {!! Form::email('email', $asuransi->email, array(
                            'class'         => 'form-control',
                            'placeholder'   => 'Email'
                            )) !!}
					  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
					</div>
                </div>
            </div>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			   <div class="form-group @if($errors->has('obat'))has-error @endif">
                {!! Form::textarea('obat', $asuransi->obat, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'obat'
                    )) !!}
			     @if($errors->has('obat'))<code>{{ $errors->first('obat') }}</code>@endif
			   </div>
            </div>
        </div>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			   <div class="form-group @if($errors->has('penagihan'))has-error @endif">
                {!! Form::textarea('penagihan', $asuransi->penagihan, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'penagihan'
                    )) !!}
			     @if($errors->has('penagihan'))<code>{{ $errors->first('penagihan') }}</code>@endif
			   </div>
            </div>
        </div>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			   <div class="form-group @if($errors->has('rujukan'))has-error @endif">
                {!! Form::textarea('rujukan', $asuransi->rujukan, array(
                    'class'         => 'form-control textareacustom',
                    'placeholder'   => 'rujukan'
                    )) !!}
			     @if($errors->has('rujukan'))<code>{{ $errors->first('rujukan') }}</code>@endif
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
@stop
@section('footer') 


@stop
