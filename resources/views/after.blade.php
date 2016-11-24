    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="hideModal1" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Pilih Diagnosa ICD 10</h4>
                </div>
                <div class="modal-body">
                    <table class="table icd notResponsive" id="GridView4">
                        <thead>
                            <tr>
                                <th>ICD 10</th>
                                <th>Diagnosa</th>
                            </tr>
                            <tr>
                                <th><input type="text" class="form-control search" id="byICD"></th>
                                <th><input type="text" class="form-control search" id="byDiagnosa"></th>
                            </tr>
                        </thead>
                        <tbody id="temp">
                            @foreach ($icd10s as $icd10)
                                <tr>
                                    <td>{!! $icd10->id !!}</td>
                                    <td>{!! $icd10->diagnosaICD !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                <button type="button" id="showModal2" class="displayNone" data-toggle="modal" data-target="#exampleModal1">Close</button>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <button type="button" id="confirmICD" class="btn btn-success btn-block">Submit</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModal1Label">Pilih atau buat Diagnosa Umum</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table">
                                <tr>
                                    <td>Kode ICD 10</td>
                                    <td>
                                        <label id="lblICD"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Diagnosa ICD</td>
                                    <td>
                                        <label id="lblDiagnosaICD"></label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="ketik lalu tekan ENTER untuk tambah diagnosa.." aria-describedby="basic-addon2" id="tambahDiagnosa" />
                                                <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table class="table" id="GridView2">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Diagnosa</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ajax4">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                         <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <button type="button" id="confirmDiagnosa" class="btn btn-success btn-block" onclick="confirmDiagnosa();">Submit</button>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                 <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" id="hideModal2" aria-label="Close">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <div class="modal fade" id="modalTindakan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="hideModal1" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Input Tindakan / Penunjang</h4>
                </div>
                <div class="modal-body">
                    @include('tindakan', ['tindakans' => $tindakans])  
                    @if($antrianperiksa->asuransi_id == '32')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="alert alert-warning text-center" style="display:none;" id="option_bila_nebu_bpjs">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="strong" id="keterangan_nebu_bpjs">BPJS hanya menanggung Nebu bila pasien dalam keadaan asma akut</div> <br>
                                            Apakah pasien dalam keadaan asma akut ? 
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <a href="#" class="btn btn-block btn-success" onclick="asmaAkut();return false;">Asma Akut</a>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <a href="#" class="btn btn-block btn-danger" onclick="bukanAsmaAkut();return false;">Bukan Asma Akut</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							@include('warninggds', ['cekGdsBulanIni' => $cekGdsBulanIni])
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                <button type="button" id="showModal2" class="displayNone" data-toggle="modal" data-target="#exampleModal1">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSigna" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="hideModalSigna" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Signa</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-inline" >
                        
                            <div class="form-group">
                                <label for="">Signa Baru</label>
                                
                                
                            </div>
                        </div>
                        <table class="table table-condensed icd tfoot" id="tblSigna">
                            <thead>
                                <tr>
                                    <th colspan="2"><input type="text" class="form-control" id="inputSigna"></th>
                                    <th><a href="#" class="btn btn-primary" id="btnInsertSigna" onclick="insertSigna(this);return false;">Input</a></th>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Signa</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($signas->count() > 0)
                                    {{-- expr --}}
                                    @foreach ($signas as $signa)

                                        <tr>
                                            <td>{!!$signa->id!!}</td>
                                            <td>{!!$signa->signa!!}</td>
                                            <td><button class="btn btn-success btn-xs" value="{!!$signa->id!!}" onclick="pilihSigna(this)">pilih</button></td>
                                        </tr>

                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data untuk ditampilkan :p</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" id="showModal2" class="displayNone" data-toggle="modal" data-target="#exampleModal1">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_asuransi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{!! $antrianperiksa->asuransi->nama !!}</h4>
            </div>
            <div class="modal-body">

                <h4>Gigi</h4>
                <p>{!! $antrianperiksa->asuransi->gigi !!}</p>
                <h4>Laboratorium</h4>
                <p>{!! $antrianperiksa->asuransi->laboratorium !!}</p>
                <h4>Tindakan</h4>
                <p>{!! $antrianperiksa->asuransi->tindakan !!}</p>
                <h4>Obat</h4>
                <p>{!! $antrianperiksa->asuransi->obat !!}</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('obat')

 <div class="modal fade bs-example-modal-sm" id="modalAturanMinum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="hideModalAturanMinum" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Aturan Minum</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-condensed icd tfoot" id="tblAturanMinum">
                                <thead>
                                     <tr>
                                        <td colspan="2"><input type="text" class="form-control" id="inputAturanMinum"></td>
                                        <td><a href="#" class="btn btn-primary btn-sm" id="btnAturanMinum"  onclick="insertAturanMinum();">Input</a></td>
                                    </tr>
                                    <tr>
                                        <th>ID</th>
                                        <th>Aturan Minum</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($aturans->count() > 0)
                                        {{-- expr --}}
                                       @foreach ($aturans as $aturan)
                                           <tr>
                                               <td> {!! $aturan->id !!} </td>
                                               <td> {!! $aturan->aturan_minum !!} </td>
                                               <td> <button class="btn btn-success btn-xs" onclick="pilihAturanMinum(this)" value="{!! $aturan->id !!}">Pilih</button>  </td>
                                           </tr>
                                       @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada data untuk ditampilkan :p</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" id="showModal2" class="displayNone" data-toggle="modal" data-target="#exampleModal1">Close</button>
                </div>
            </div>
        </div>
    </div>
