function informasi(control){
    var ID = $(control).data('value');


    $.post( base + '/poli/ajax/ajxobat', { 'merek_id' : ID}, function(data) {
        /*optional stuff to do after success */
        data = $.parseJSON(data);
        var MyArray = data.komposisis;
        var temp = '';

        for (var i = 0; i < MyArray.length; i++) {
            temp += '<tr>';
            temp += '<td>' + MyArray[i].komposisi + '</td>';
            temp += '<td>' + MyArray[i].pregnancy_safety_index + '</td>';
            temp += '</tr>';
        }

        $('#nama_obat').text($(control).text());

        $('#kontraindikasi').html(data.kontraindikasi);
        $('#indikasi').html(data.indikasi);
        $('#efek_samping').html(data.efek_samping);
        $('#tabel_komposisi').html(temp);

    });
}