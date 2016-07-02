 <table class="table table-condensed" id="riwayat_obstetri">
    <thead>
        <tr>
            <th>Anak ke</th>
            <th>Jenis Kelamin</th>
            <th>Berat Lahir</th>
            <th>Tahun Lahir</th>
            <th>Lahir di</th>
            <th>Spontan / SC</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="table_riwayat_kehamilan">
        
    </tbody>
    <tfoot>
        <tr> 
            <td></td>
            <td>
                <select name="" id="inputJenisKelamin" class="form-control inp">
                    <option value="">- pilih -</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control inp" id="inputBeratLahir" placeholder="" dir="rtl" name="inputBeratLahir" aria-describedby="addoninputBeratLahir"/>
                    <span class="input-group-addon" id="addoninputBeratLahir">gr</span>
                </div>
            </td>
            <td>
                <input type="text" class="form-control inp" id="inputTahunLahir" placeholder="" dir="rtl" name="inputTahunLahir" aria-describedby="addOnInputTahunLahir"/>
            </td>
            <td>
                <select name="" id="inputLahirDi" class="form-control inp">
                    <option value="">- pilih -</option>
                    <option value="Bidan">Bidan</option>
                    <option value="DSOG">DSOG</option>
                    <option value="dokter">dokter</option>
                    <option value="dukun">dukun</option>
                </select>
            </td>
            <td>
                <select name="" id="inputSpontanSC" class="form-control inp">
                    <option value="">- pilih -</option>
                    <option value="Spontan">Spontan</option>
                    <option value="SC">SC</option>
                    <option value="Abortus">Abortus</option>
                </select>
            </td>
            <td><button type="button" class="btn btn-info btn-xs" onclick="inputRiwayatKehamilan(this);return false" id="input_riwayat">input</button></td>
        </tr>
    </tfoot>
</table>
{!! Form::textarea('riwayat_kehamilan', $riwayat_kehamilan_sebelumnya, ['class' => 'form-control hide', 'id' => 'riwayat_kehamilan'])!!}
