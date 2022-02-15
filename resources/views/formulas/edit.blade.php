 @extends('layout.master')

 @section('title') 
 {{ env("NAMA_KLINIK") }} | Edit Formula
 @stop
 @section('page-title') 
 <h2>Edit Formula</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('mereks')}}">Home</a>
      </li>
      <li class="active">
          <strong>Edit Formula</strong>
      </li>
</ol>
 @stop
 @section('content') 
 <input type="hidden" name="_token" id="token" value="{{ Session::token() }}">

    @foreach ($errors as $error)
        {!! $error !!} <br>
    @endforeach

{!! Form::model( $formula, [
        'url' => 'formulas/' . $formula->id,
        "class" => "m-t", 
        "role"  => "form",
        "method"=> "put"
])!!}

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-info">
          <div class="panel-heading">
                <h3 class="panel-title">Formula - Rak - Merek</h3>
          </div>
          <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                {!!Form::label('indikasi')!!}<br />
                                {!!Form::textarea('indikasi', null, array(
                                    'class'         => 'form-control textareacustom',
                                    'placeholder'   => 'Indikasi'
                                ))!!}
                                @if($errors->first('indikasi'))first('indikasi'))
                                    <code>{!! $errors->first('indikasi')!!}</code>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                {!!Form::label('kontraindikasi')!!}<br />
                                {!!Form::textarea('kontraindikasi', null, array(
                                    'class'         => 'form-control textareacustom',
                                    'placeholder'   => 'kontraindikasi'
                                ))!!}
                                @if($errors->first('kontraindikasi'))
                                <code>{!! $errors->first('kontraindikasi')!!}</code>
                                @endif
                            </div>
                        </div>
                    </div>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="form-group @if($errors->has('golongan_obat'))has-error @endif">
								{!! Form::label('golongan_obat', 'Golongan Obat', ['class' => 'control-label']) !!}
								{!!Form::text('golongan_obat', null, array(
										'class'         => 'form-control',
										'placeholder'   => 'Krim Pagi / Krim Malam / dll'
									))!!}
								@if($errors->has('golongan_obat'))<code>{{ $errors->first('golongan_obat') }}</code>@endif
							</div>
						</div>
					</div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <div class="row">
                         <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                {!!Form::label('efek_samping')!!}<br />
                                {!!Form::textarea('efek_samping', null, array(
                                    'class'         => 'form-control textareacustom',
                                    'placeholder'   => 'efek_samping'
                                ))!!}
                                @if($errors->first('efek_samping'))
                                <code>{!! $errors->first('efek_samping')!!}</code>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            {!! Form::label('peringatan')!!}
                            {!! Form::textarea('peringatan', null, ['class' => 'form-control textareacustom'])!!}
                        </div>
                    </div>
                    <div class="row">
                        
                             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    {!!Form::label('sediaan')!!}<br />
                                    {!!Form::select('sediaan', $sediaan, null, array(
                                        'class'         => 'form-control'
                                    ))
                                    !!}
                                    @if($errors->first('sediaan'))
                                    <code>{!! $errors->first('sediaan') !!}</code>
                                    @endif
                                    {!! Form::text('sediaan2', $formula->indikasi, array('class' => 'form-control displayNone'))!!}
                                </div>
                            </div>
                             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    {!!Form::label('aturan_minum')!!}<br />
                                    {!!Form::select('aturan_minum_id', $aturan_minums, null, array(
                                        'class'         => 'form-control'
                                    ))
                                    !!}
                                    @if($errors->first('aturan'))
                                    <code>{!! $errors->first('aturan') !!}</code>
                                    @endif
                                </div>
                            </div>
                             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    {!!Form::label('Dijual Bebas')!!}<br />
                                    {!!Form::select('dijual_bebas', $dijual_bebas, null, array(
                                        'class'         => 'form-control'
                                    ))
                                    !!}
                                    @if($errors->first('dijual_bebas'))
                                    <code>{!! $errors->first('dijual_bebas') !!}</code>
                                    @endif
                                </div>
                            </div>
                    </div>
                </div>
            </div> <!-- end row -->

             </div><!-- end panel body -->
        </div><!-- end panel info -->
        </div><!-- end col-12 -->

        </div><!-- end row -->
@include('formulas.form')
<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        {!! Form::submit('Submit', ['class' => 'btn btn-success btn-lg btn-block'])!!}
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        {!! HTML::link('formulas/' . $formula->id, 'Cancel', ['class' => 'btn btn-warning btn-lg btn-block'])!!}
    </div>
{!! Form::close() !!}

    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        {!! Form::open(['url' => 'formulas/' . $formula->id, 'method' => 'delete'])!!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-lg btn-block', 'onclick' => 'return confirm("Anda yakin mau menghapus formula ini? dosis, rak, komposisi, dan merek terkait semua akan terhapus");'])!!}
        {!! Form::close()!!}
    </div>
</div>
  
       
<div id="notif"></div>
<div id="tabelNotif"></div>
 
    @stop
    @section('footer') 
    <script>

       var base = "{{ url('/') }}";
    </script>
    <script src="{{ url('js/createForm.js') }}"></script>

    @stop
