                         @foreach($model->jurnals as $ky=>$jur)
                            @if($jur->debit == '1' && $ky == 0)
                            <tr class="b-top">
                              <td rowspan="{{$model->jurnals->count()}}">{!!$jur->tanggal!!} <br>
                                  {{ $ju->created_at->format('H:i:s') }} <br />
                               - {{ $ju->jurnalable_type}} {{ $ju->jurnalable_id}}
                              @if($ju->jurnalable_type == 'App\Periksa')
                                <br>
                               - Pembayaran : {{ $model->asuransi->nama}}
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
                              @elseif($ju->jurnalable_type == 'App\FakturBelanja' && $model->belanja_id == '1')
                                  <a href="{{ url('pembelians/show/' . $ju->jurnalable_id)}}" class="btn btn-primary btn-xs btn-block">Detail</a> 
                              @elseif($ju->jurnalable_type == 'App\FakturBelanja'&& $model->belanja_id == '3')
                                  <a href="{{ url('pengeluarans/show/' . $ju->jurnalable_id) }}" class="btn btn-primary btn-xs btn-block">Detail</a> 
                              @elseif($ju->jurnalable_type == 'App\NotaJual'&& $model->pembayaranAsuransi->count() > '0')
                                  <a href="{{ url('pendapatans/pembayaran/asuransi/show/' . $ju->jurnalable_id) }}" class="btn btn-primary btn-xs btn-block">Detail</a> 
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
                             @elseif($jur->debit == '0' && $ky != ($model->jurnals)->count()-1)
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
