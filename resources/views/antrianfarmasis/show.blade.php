@extends('layout.master')

@section('title') 
  Klinik Jati Elok | Antrian Farmasi {{ $antrianfarmasi->periksa->pasien->nama }}

@stop
@section('page-title') 
<h2>Antrian Farmasi {{ $antrianfarmasi->periksa->pasien->nama }}</h2>
<ol class="breadcrumb">
      <li>
        <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
        <strong>Antrian Farmasi {{ $antrianfarmasi->periksa->pasien->nama }}</strong>
      </li>
</ol>

@stop
@section('content') 
    <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        @include('surveys.komponen_pasien',[
          'periksa' => $antrianfarmasi->periksa
        ])
        <div id="tanggal_lahir" class="hide">
          {{ $antrianfarmasi->periksa->pasien->tanggal_lahir->format('d-m-Y') }}
        </div>
      </div>
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="panelLeft">
                  <h3>Terapi</h3>
                </div>
                <div class="panelRight">
                    @if ( isset($antrianfarmasi->antrian) )
                      @include('fasilitas.call_button', [
                        'antrian' => $antrianfarmasi->antrian,
                        'bigger_button' => true
                      ])
                    @endif
                </div>
              </div>
              <div class="panel-body">
                {!! $antrianfarmasi->periksa->terapi_html !!}
              </div>
            </div>
          <div class="panel panel-default">
              <div class="panel-heading">
                <h3>Bisa dibantu sebutkan tanggal lahir pasien?</h3>
              </div>
              <div class="panel-body">
                {!! Form::text('tanggal_lahir', null, [
                  'class'    => 'form-control tanggal',
                  'onchange' => 'cekTanggalLahir(this); return false;'
                ]) !!}
              </div>
            </div>
          <div id="komponen_submit" class="row">
              {!! Form::open(['url' => 'antrianfarmasis/'. $antrianfarmasi->id .'/proses', 'method' => 'post']) !!}
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  @if(isset($update))
                    <button class="btn btn-success btn-lg btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
                  @else
                    <button class="btn btn-success btn-lg btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
                  @endif
                  {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <a class="btn btn-danger btn-lg btn-block" href="{{ url('antrianfarmasis') }}">Cancel</a>
                </div>
              {!! Form::close() !!}
          </div>
        </div>
    </div>
@stop
@section('footer') 
@include('tunggu')
@include('panggil')
<script src="{!! asset('js/panggil.js') !!}"></script>
<script src="{!! asset('js/app.js') !!}"></script>
<script type="text/javascript" charset="utf-8">
  $('#komponen_submit').hide();
  function dummySubmit(control){
    if(validatePass2(control)){
      $('#submit').click();
    }
  }
  function cekTanggalLahir(control){
    var konfirmasi_tanggal_lahir = $.trim($(control).val());
    var tanggal_lahir_pasien     = $.trim($('#tanggal_lahir').html());
    if(konfirmasi_tanggal_lahir == tanggal_lahir_pasien){
      $('#komponen_submit').show();
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: konfirmasi_tanggal_lahir + ' Bukan Tanggal Lahir pasien! Pastikan pasien adalah pasien yang benar, jangan sampai tertukar'
      })
      $('#komponen_submit').hide();
    }
  }
window.Echo.join('survey')
    .listen('CustomerSatisfactionSurveyPressence', (e) => {
        console.log(e);
    })
    .here((users) => {
		console.log('users');
		console.log(users);
        for (let i = 0, len = users.length; i < len; i++) {
			console.log('users[i]');
			console.log(users[i].user.surveyable_type == 'App\\Models\\AntrianKasir');
            if(users[i].user.surveyable_type == 'App\\Models\\AntrianKasir'){
                $('#surveyable_id').val(users[i].user.surveyable_id);
                $('#surveyable_type').val(users[i].user.surveyable_type);
            }
        }
    })
    .joining((user) => {
        if( user.surveyable_type == 'App\\Models\\AntrianKasir'){
            $('#surveyable_id').val(users.user.surveyable_id);
        }
    })
    .leaving((user) => {
        if( user.surveyable_type == 'App\\Models\\AntrianKasir'){
            $('#surveyable_id').val('');
        }
    });

</script>
  
@stop
