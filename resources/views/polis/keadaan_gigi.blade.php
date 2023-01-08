<tr>
    <td class="taksonomi_gigi_id hide">{{ $t->id }}</td>
    <td class="nama_taksonomi_gigi">
        @if(
            !empty( $t->taksonomi_gigi_anak )
            && \App\Models\Odontogram::dewasa( $t->id, $pasien->id )
            )
            {{ $t->taksonomi_gigi }} / {{ $t->taksonomi_gigi_anak }}
        @else
            {{ $t->taksonomi_gigi }} 
            {{-- <span class="badge">tindakan</span> --}}
       @endif
    </td>
    <td style="width: 1%; nowrap">
        <button onclick="bukaOdontogram(this);return false;" class="btn btn-info btn-sm" type="button">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </button>
    </td>
</tr>


