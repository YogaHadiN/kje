<table class="table table-condensed tfoot" id="tblTindakan">
    <thead>
        <tr>
            <th>Tindakan</th>
            <th>Keterangan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="ajaxTindakan">
    </tbody>
    <tfoot>
        <tr>
            <td>
                {!! Form::select('selectTindakan', $tindakans, null, ['class' => 'form-control selectpick', 'id' => 'selectTindakan', 'data-live-search' => 'true'])!!}
        </td>
            <td><input type="text" class="form-control" id="keteranganTindakan"></td>
            <td><a href="#" class="btn btn-success" onclick="submitTindakan(); return false;" id="inputTindakanSubmit">submit</a></td>
        </tr>
    </tfoot>
</table>