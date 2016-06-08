@extends('layout.master')

@section('title') 
Klinik Jati Elok | Coa belum di set
@stop
@section('page-title') 
 <h2>Jurnal Umum</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Coa belum di set</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                  <h3>Coa Pengeluaran</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table borderless table-condensed">
                <thead>
                    <tr>
                        <th class="hide">Tanggal</th>
                        <th>Tanggal</th>
                        <th>Akun </th>
                        <th>Nilai</th>
            						<th>Chart Of Account</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurnalumums as $ju)
                      @if($ju['jurnalable_type'] == 'App\FakturBelanja')
                        <tr>
                          @foreach ($ju->jurnalable->pengeluaran as $penge)
                              @if(empty( $penge->coa_id ))
                                  <td class="hide field_id">{!! $ju->id !!}</td>
                                  <td>{!! $ju->tanggal !!}</td>
                                  <td>{!! $penge->bukanObat->nama !!}</td>
                                  <td class="uang">{!! $ju->nilai !!}</td>
                                  <td>
                                      {!! Form::select('coa', $bebanCoaList, null, ['class' => 'form-control rq', 'onchange' => 'coaChange(this); return false;']) !!}
                                  </td>
                              @endif
                          @endforeach
                        </tr>
                      @endif
                    @endforeach
                </tbody>
            </table>
      </div>
</div>

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                  <h3>Coa Pendapatan Lain</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table borderless table-condensed">
                <thead>
                    <tr>
                        <th class="hide field_id">id</th>
                        <th>Tanggal</th>
                        <th>Pendapatan</th>
                        <th>Biaya</th>
                        <th>Chart Of Account</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurnalumums as $ju)
                      @if($ju['jurnalable_type'] == 'App\Pendapatan')
                        <tr>
                          <td class="hide field_id">{!! $ju->id !!}</td>
                          <td>{!! App\Classes\Yoga::updateDatePrep($ju->tanggal) !!}</td>
                          <td>{!! $ju->jurnalable->pendapatan !!}</td>
                          <td class="uang">{!! $ju->nilai !!}</td>
                           <td>
                            {!! Form::select('coa', $pendapatanCoaList, null, ['class' => 'form-control rq', 'onchange' => 'coaChange(this); return false;']) !!}
                          </td>
                          <td>{!! $ju->jurnalable->keterangan !!}</td>
                          <td>
                            <a href="#" class="btn btn-info btn-xs btn-block">Detail</a>
                          </td>
                        </tr>
                      @endif
                    @endforeach
                </tbody>
            </table>
      </div>
</div>

{!! Form::open(['url' => 'jurnal_umums/coa']) !!}
  {!! Form::textarea('temp', json_encode($jurnalumums), ['class' => 'form-control', 'id' => 'temp']) !!}

  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <button class="btn btn-success btn-lg btn-block" type="button" onclick="dummySubmit();return false;">Submit</button>
      <button class="btn btn-success btn-lg btn-block hide" id="submit" type="submit">Submit</button>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <a href="{{ url('jurnal_umums') }}" class="btn btn-danger btn-lg btn-block">Cancel</a>
    </div>
  </div>
{!! Form::close() !!}
@stop
@section('footer') 

<script>
  function coaChange(control){
    var id = $(control).closest('tr').find('.field_id').html();
    console.log('id = ' + id);
    var data = JSON.parse($('#temp').val());
    for (var i = 0; i < data.length; i++) {
      if (data[i].id == id) {
        data[i].coa_id = $(control).val();
        break;
      }
    }

    var string = JSON.stringify(data);
    $('#temp').val(string);
  }

  function dummySubmit(){
    if (validatePass()) {
      $('#submit').click();
    }
  }
</script>

@stop
