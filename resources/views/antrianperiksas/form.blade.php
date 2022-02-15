                                        @if(!$periksa->suratSakit)
                                            <span>
                                                <button type="button" onclick="cekMasihAda(this);return false;" class="btn btn-success btn-sm">Buat Surat Sakit</button>
                                                <a href="{{ url('suratsakits/create/' . $periksa->id) }}" class="btn btn-success btn-sm rujukan hide">Buat Surat Sakit2</a>
                                            </span>
                                        @else
                                            <span>
                                                <button type="button" onclick="cekMasihAda(this);return false;" class="btn btn-warning btn-sm">Edit Surat Sakit</button>
                                                <a href="{{ url('suratsakits/' . $periksa->suratSakit->id . '/edit') }}" class="btn btn-warning btn-sm rujukan hide">Edit Surat Sakit2</a>
                                            </span>
                                        @endif
                                        @if(!$periksa->rujukan)
                                            <span>
                                                <button type="button" onclick="cekMasihAda(this);return false;" class="btn btn-success btn-sm">Buat Rujukan</button>
                                                <a href="{{ url('rujukans/create/' . $periksa->id) }}" class="btn btn-success btn-sm rujukan hide">Buat Rujukan2</a>
                                            </span>
                                        @else
                                            <span>
                                                <button type="button" onclick="cekMasihAda(this);return false;" class="btn btn-warning btn-sm">Edit Rujukan</button>
                                                <a href="{{ url('rujukans/' . $periksa->rujukan->id . '/edit') }}" class="btn btn-warning btn-sm rujukan hide">Edit Rujukan2</a>
                                            </span>
                                        @endif
                                        @if(!$periksa->kontrol)
                                            <span>
                                                <button type="button" onclick="cekMasihAda(this);return false;" class="btn btn-info btn-sm">Buat Janji Kontrol</button>
                                                <a href="{{ url('kontrols/create/' . $periksa->id) }}" class="btn btn-success btn-sm rujukan hide">Buat Rujukan2</a>
                                            </span>
                                        @else
                                            <span>
                                                <button type="button" onclick="cekMasihAda(this);return false;" class="btn btn-warning btn-sm">Edit Janji Kontrol</button>
                                                <a href="{{ url('kontrols/' . $periksa->kontrol->id . '/edit') }}" class="btn btn-warning btn-sm rujukan hide">Edit Rujukan2</a>
                                            </span>
                                        @endif
                                            <span>
                                                <button type="button" onclick="cekMasihAda(this);return false;" class="btn btn-danger btn-sm">Periksa Lagi</button>
                                            {!! Form::submit('Periksa Lagi2', ['class' => 'btn btn-danger btn-sm periksa hide', 'onclick' => 'return confirm("Anda Yakin mau mengembalikan ' . $periksa->pasien_id . ' - ' . $periksa->pasien->nama. ' ke ruang periksa?")']) !!}
                                            </span>
