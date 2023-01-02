<tr>
    <td class="taksonomi_id hide">{{ $t->id }}</td>
    <td>
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
        <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#odontogramEditor">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </button>
    </td>
</tr>


