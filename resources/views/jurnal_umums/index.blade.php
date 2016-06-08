@extends('layout.master')

@section('title') 
Klinik Jati Elok | Jurnal Umum
@stop
@section('page-title') 
 <h2>Jurnal Umum</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Jurnal Umum</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                  <h3>Jurnal Umum</h3>
                </div>
                <div class="panelRight">
                    <h3>Total : {!! $jurnalumums->count() !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            {!! $jurnalumums->appends(Input::except('page'))->links(); !!}
            <table class="table borderless table-condensed">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Akun </th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                   @if (count($jurnalumums) > 0)
                    @foreach($jurnalumums as $k=>$ju)
                         @foreach($ju->jurnalable_type::find($ju->jurnalable_id)->jurnals as $ky=>$jur)
                            @if($jur->debit == '1' && $ky == 0)
                            <tr class="b-top">
                              <td rowspan="{{$ju->jurnalable_type::find($ju->jurnalable_id)->jurnals->count()}}">{!! $k + 1 !!}</td>
                              <td rowspan="{{$ju->jurnalable_type::find($ju->jurnalable_id)->jurnals->count()}}">{!!$jur->tanggal!!} <br>
                               - {{ $ju->jurnalable_type}} {{ $ju->jurnalable_id}}
                              @if($ju->jurnalable_type == 'App\Periksa')
                                <br>
                               - Pembayaran : {{ $ju->jurnalable_type::find($ju->jurnalable_id)->asuransi->nama}}
                              @endif
                              </td>
                              <td>
                                @if(!empty($jur->coa_id))
                                  {!! $jur->coa_id!!} - {!!$jur->coa->coa!!}
                                @endif
                              </td>
                              <td class="uang">{!!$jur->nilai!!}</td>
                              <td></td>
                              <td>
                              @if($ju->jurnalable_type == 'App\Periksa')
                                  <a href="{{ url('periksas/' . $ju->jurnalable_id)}}" class="btn btn-primary btn-xs btn-block">Detail</a> 
                              @elseif($ju->jurnalable_type == 'App\FakturBelanja' && $ju->jurnalable_type::find($ju->jurnalable_id)->belanja_id == '1')
                                  <a href="{{ url('pembelians/show/' . $ju->jurnalable_id)}}" class="btn btn-primary btn-xs btn-block">Detail</a> 
                              @elseif($ju->jurnalable_type == 'App\FakturBelanja'&& $ju->jurnalable_type::find($ju->jurnalable_id)->belanja_id == '3')
                                  <a href="{{ url('pengeluarans/show/' . $ju->jurnalable_id) }}" class="btn btn-primary btn-xs btn-block">Detail</a> 
                              @endif
                              </td>
                            </tr>
                             @elseif($jur->debit == '1' && $ky != 0)
                               <tr>
                                <td>
                                  @if(!empty($jur->coa_id))
                                    {!! $jur->coa_id!!} - {!!$jur->coa->coa!!}
                                  @endif
                                </td>
                                <td class="uang">{!!$jur->nilai!!}</td>
                                <td></td>
                                <td></td>
                              </tr>
                             @elseif($jur->debit == '0' && $ky != ($ju->jurnalable_type::find($ju->jurnalable_id)->jurnals)->count()-1)
                             <tr>
                                <td class="text-right">
                                  @if(!empty($jur->coa_id))
                                    {!! $jur->coa_id!!} - {!!$jur->coa->coa!!}
                                  @endif
                                </td>
                                <td></td>
                                <td class="uang">{!!$jur->nilai!!}</td>
                                <td></td>
                            </tr>
                            @else 
                             <tr class="b-bottom">
                                <td class="text-right">
                                  @if(!empty($jur->coa_id))
                                    {!! $jur->coa_id!!} - {!!$jur->coa->coa!!} <br>
                                    {!! App\Classes\Yoga::Flash($jur->jurnalable->ketjurnal) !!}
                                  @endif
                                </td>
                                <td></td>
                                <td class="uang">{!!$jur->nilai!!}</td>
                                <td></td>
                            </tr>
                            @endif
                          </tr>
                        @endforeach
                   @endforeach
                  @else
                    <tr>
                      <td colspan="7" class="text-center">Tidak ada Data Untuk Ditampilkan :p</td>
                    </tr>
                  @endif
                </tbody>
            </table>
            {!! $jurnalumums->appends(Input::except('page'))->links(); !!}
      </div>
</div>
@stop
@section('footer') 

@stop
