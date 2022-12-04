@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Cek Harian Anafilaktik Kit {{ $ruangan->nama }}

@stop
@section('page-title') 
    <h2>Cek Harian Anafilaktik Kit {{ $ruangan->nama }}</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Cek Harian Anafilaktik Kit {{ $ruangan->nama }}</strong>
            </li>
</ol>

@stop
@section('content') 
    {!! Form::open([
        'url'    => 'cek_harian_anafilaktik_kits/' . $ruangan->id,
        "class"  => "m-t",
        "role"   => "form",
        "method" => "post",
        "files"  => "true"
    ]) !!}
        <div class="form-group @if($errors->has('jumlah_epinefrin_inj')) has-error @endif">
          {!! Form::label('jumlah_epinefrin_inj', 'Jumlah Epinefrin Inj', ['class' => 'control-label']) !!}
          {!! Form::text('jumlah_epinefrin_inj' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('jumlah_epinefrin_inj'))<code>{{ $errors->first('jumlah_epinefrin_inj') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('jumlah_dexamethasone_inj')) has-error @endif">
          {!! Form::label('jumlah_dexamethasone_inj', 'Jumlah Dexa Inj', ['class' => 'control-label']) !!}
          {!! Form::text('jumlah_dexamethasone_inj' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('jumlah_dexamethasone_inj'))<code>{{ $errors->first('jumlah_dexamethasone_inj') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('jumlah_ranitidine_inj')) has-error @endif">
          {!! Form::label('jumlah_ranitidine_inj', 'Jumlah Ranitidin Inj', ['class' => 'control-label']) !!}
          {!! Form::text('jumlah_ranitidine_inj' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('jumlah_ranitidine_inj'))<code>{{ $errors->first('jumlah_ranitidine_inj') }}</code>@endif
        </div>
         <div class="form-group @if($errors->has('jumlah_diphenhydramine_inj')) has-error @endif">
          {!! Form::label('jumlah_diphenhydramine_inj', 'Jumlah Diphenhydramin Inj', ['class' => 'control-label']) !!}
          {!! Form::text('jumlah_diphenhydramine_inj' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('jumlah_diphenhydramine_inj'))<code>{{ $errors->first('jumlah_diphenhydramine_inj') }}</code>@endif
        </div>   
        <div class="form-group @if($errors->has('jumlah_spuit_3cc')) has-error @endif">
          {!! Form::label('jumlah_spuit_3cc', 'Jumlah Spuit 3cc', ['class' => 'control-label']) !!}
          {!! Form::text('jumlah_spuit_3cc' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('jumlah_spuit_3cc'))<code>{{ $errors->first('jumlah_spuit_3cc') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('oksigen_bisa_dipakai')) has-error @endif">
          {!! Form::label('oksigen_bisa_dipakai', 'Oksigen Bisa Dipakai?', ['class' => 'control-label']) !!}
          {!! Form::select('oksigen_bisa_dipakai', yesno_option() , null, [
            'class' => 'form-control',
            'placeholder' => '- Pilih -'
          ]) !!}
          @if($errors->has('oksigen_bisa_dipakai'))<code>{{ $errors->first('oksigen_bisa_dipakai') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('jumlah_gudel_anak')) has-error @endif">
          {!! Form::label('jumlah_gudel_anak', 'Jumlah Spuit 3cc Inj', ['class' => 'control-label']) !!}
          {!! Form::text('jumlah_gudel_anak' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('jumlah_gudel_anak'))<code>{{ $errors->first('jumlah_gudel_anak') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('jumlah_gudel_dewasa')) has-error @endif">
          {!! Form::label('jumlah_gudel_dewasa', 'Jumlah Gudel Dewasa', ['class' => 'control-label']) !!}
          {!! Form::text('jumlah_gudel_dewasa' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('jumlah_gudel_dewasa'))<code>{{ $errors->first('jumlah_gudel_dewasa') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('jumlah_nacl')) has-error @endif">
          {!! Form::label('jumlah_nacl', 'Jumlah NaCl', ['class' => 'control-label']) !!}
          {!! Form::text('jumlah_nacl' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('jumlah_nacl'))<code>{{ $errors->first('jumlah_nacl') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('jumlah_infus_set')) has-error @endif">
          {!! Form::label('jumlah_infus_set', 'Jumlah Infus Set', ['class' => 'control-label']) !!}
          {!! Form::text('jumlah_infus_set' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('jumlah_infus_set'))<code>{{ $errors->first('jumlah_infus_set') }}</code>@endif
        </div>
        <div class="form-group @if($errors->has('jumlah_tiang_Infus')) has-error @endif">
          {!! Form::label('jumlah_tiang_Infus', 'Jumlah Tiang Infus', ['class' => 'control-label']) !!}
          {!! Form::text('jumlah_tiang_Infus' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('jumlah_tiang_Infus'))<code>{{ $errors->first('jumlah_tiang_Infus') }}</code>@endif
        </div>
        <div class="form-group{{ $errors->has('image_anafilaktik_kit_tembok') ? ' has-error' : '' }}">
            {!! Form::label('image_anafilaktik_kit_tembok', 'Gambar Anafilaktik Kit di Tembok') !!}
            {!! Form::file('image_anafilaktik_kit_tembok') !!}
                @if (isset($cek_harian_anafilaktik_kit) && $cek_harian_anafilaktik_kit->image_anafilaktik_kit_tembok)
                    <p> {!! HTML::image(asset('root directory/'.$cek_harian_anafilaktik_kit->image_anafilaktik_kit_tembok), null, ['class'=>'img-rounded upload']) !!} </p>
                @else
                    <p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
                @endif
            {!! $errors->first('image_anafilaktik_kit_tembok', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group{{ $errors->has('image_anafilaktik_kit_box') ? ' has-error' : '' }}">
            {!! Form::label('image_anafilaktik_kit_box', 'Gambar Anafilaktik Kit di Kotak') !!}
            {!! Form::file('image_anafilaktik_kit_box') !!}
                @if (isset($cek_harian_anafilaktik_kit) && $cek_harian_anafilaktik_kit->image_anafilaktik_kit_box)
                    <p> {!! HTML::image(asset('root directory/'.$cek_harian_anafilaktik_kit->image_anafilaktik_kit_box), null, ['class'=>'img-rounded upload']) !!} </p>
                @else
                    <p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
                @endif
            {!! $errors->first('image_anafilaktik_kit_box', '<p class="help-block">:message</p>') !!}
        </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    @if(isset($update))
                        <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
                    @else
                        <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
                    @endif
                    {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <a class="btn btn-danger btn-block" href="{{ url('cek_list_harians/' . $ruangan->id) }}">Cancel</a>
                </div>
            </div>
    {!! Form::close() !!}
@stop
@section('footer') 
    <script type="text/javascript" charset="utf-8">
        function dummySubmit(control){
            if(validatePass2(control)){
                $('#submit').click();
            }
        }
    </script>
@stop
