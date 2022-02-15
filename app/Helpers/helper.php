<?php

if (!function_exists('flex_url')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function flex_url($url)
    {
        if (request()->secure()) {
            secure_url($url);
        } else {
            return url($url);
        }

    }

}
if (!function_exists('wamehp')) {
    function wamehp($nohp) {
        if (!empty( trim($nohp) )) {
            // kadang ada penulisan no hp 0811 239 345
            $nohp = str_replace(" ","",$nohp);
            // kadang ada penulisan no hp (0274) 778787
            $nohp = str_replace("(","",$nohp);
            // kadang ada penulisan no hp (0274) 778787
            $nohp = str_replace(")","",$nohp);
            // kadang ada penulisan no hp 0811.239.345
            $nohp = str_replace(".","",$nohp);

            // cek apakah no hp mengandung karakter + dan 0-9
            if(!preg_match('/[^+0-9]/',trim($nohp))){
                // cek apakah no hp karakter 1-3 adalah +62
                if(substr(trim($nohp), 0, 3)=='62'){
                    $nohp = trim($nohp);
                }
                // cek apakah no hp karakter 1 adalah 0
                elseif(substr(trim($nohp), 0, 1)=='0'){
                    $nohp = '62'.substr(trim($nohp), 1);
                }
            }
            return 'https://wa.me/' . $nohp;
        }
    }
}

if (!function_exists('tekananDarahTerkendali')) {
    function tekananDarahTerkendali($umur, $sistolik, $diastolik) {
		return (( $umur >= 18  // usia lebih sama dengan 18 tahun
			&& $umur <= 64 // usia kurang sama dengan 64 tahun
			&& $sistolik >= 120 // sistolik lebih sama dengan 120
			&& $sistolik <= 130 // diastolik kurang sama dengan 130
		) ||
		(
			$umur > 64  // usia lebih 64 tahun
			&& $sistolik >= 130 // sistolik lebih sama dengan 120
			&& $sistolik <= 139 // diastolik kurang sama dengan 130
		))
		&& $diastolik >= 70 // diastolik lebih sama dengan 70
		&& $diastolik <= 79; // diastolik kurang sama dengan 79
    }
}

if (!function_exists('rpToNumber')) {
    function rpToNumber($rupiah) {
        // kecilkan semua
        $rupiah = strtolower($rupiah);
        $rupiah = trim($rupiah);
        $rupiah = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $rupiah);


        // hilangkan Rp
        $rupiah = str_replace("rp","",$rupiah); 
//
        // hilangkan ,00
        if(str_ends_with( $rupiah, ',00')){
            $rupiah = str_replace(",00","",$rupiah);
        }
//
        // hilangkan titik
        $rupiah = str_replace(".","",$rupiah); 

        // hilangkan koma
        $rupiah = str_replace(",","",$rupiah); 

        // hilangkan strip
        $rupiah =  str_replace("-","",$rupiah);

        $rupiah = (int) $rupiah;

        return $rupiah;


    }
}
if (!function_exists('excelToPhpDate')) {
    function excelToPhpDate($EXCEL_DATE) {
        $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
        return gmdate("Y-m-d", $UNIX_DATE);
    }
}
if (!function_exists('get_string_between')) {
    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return trim(substr($string, $ini, $len));
    }
}
