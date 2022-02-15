 @if ( $antriankasir->ada_hasil_rapid_antibodi )
     <a href="{{ url('pdfs/rapid/antibodi/' . $antriankasir->id) }}" target="_blank" class="btn btn-primary btn-xs">Rapid Antibodi</a>
 @endif
 @if ( $antriankasir->ada_hasil_rapid_antigen )
     <a href="{{ url('pdfs/rapid/antigen/' . $antriankasir->id) }}" target="_blank" class="btn btn-primary btn-xs">Rapid Antigen</a>
 @endif
