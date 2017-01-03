      <table class="table table-bordered">
        <thead class="text-center light-bold">
          <tr>
            <td rowspan="2">No</td>
            <td rowspan="2">Tanggal</td>
            <td rowspan="2">Penjelasan</td>
            <td rowspan="2">Debet</td>
            <td rowspan="2">Kredit</td>
            <td colspan="2">Saldo</td>
          </tr>
          <tr>
            <td>Debet</td>
            <td>Kredit</td>
          </tr>
        </thead>
        <tbody>
          @foreach($jurnalumums as $k => $ju)

          <tr>
            <td>{{ $k + 1}}</td>
            <td>{{ $ju->tanggal }}</td>
            <td>{!! $ju->jurnalable->ketjurnal !!}</td>
            @if($ju->debit == 1)
            <td class="uang">
              {{ $ju->nilai }}
            @else
            <td>
            @endif
            </td>
            @if($ju->debit == 0)
            <td class="uang">
              {{ $ju->nilai }}
            @else
            <td>
            @endif
            </td>
            @if(App\Classes\Yoga::bukuBesarDebit($jurnalumums, $k) > 0)
            <td class="uang">
              {{ App\Classes\Yoga::bukuBesarDebit($jurnalumums, $k)}}
            @else
            <td>
            @endif
            </td>
            @if(App\Classes\Yoga::bukuBesarKredit($jurnalumums, $k) > 0)
            <td class="uang">
              {{ App\Classes\Yoga::bukuBesarKredit($jurnalumums, $k)}}
            @else
            <td>
            @endif
            </td>
          </tr>

          @endforeach
        </tbody>
      </table>
    
