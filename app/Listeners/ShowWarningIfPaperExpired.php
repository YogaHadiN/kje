<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Staf;
use App\Models\Document;
use Carbon\Carbon;

class ShowWarningIfPaperExpired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        /* 'titel' */

        session()->forget('warning_kuning');
        session()->forget('warning_merah');
        session()->forget('warning_biru');
        if ( $event->user->role_id != 1 ) {
            $almost_expired_strs = Staf::whereRaw("TIMESTAMPDIFF(MONTH, now(), str_expiry_date) < 6 and str_expiry_date > now() and aktif = 1")->get();
            $almost_expired_sips = Staf::whereRaw("TIMESTAMPDIFF(MONTH, now(), sip_expiry_date) < 6 and sip_expiry_date > now() and aktif = 1")->get();
            $expired_strs = Staf::where('str_expiry_date', '<', date('Y-m-d'))->where('aktif', 1)->get();
            $expired_sips = Staf::where('sip_expiry_date', '<', date('Y-m-d'))->where('aktif', 1)->get();

            $warning_kuning = [];
            $warning_merah = [];
            foreach ($almost_expired_strs as $staf) {
                $str_expiry_date = Carbon::parse( $staf->str_expiry_date )->floorMonth();
                $warning_kuning[] = 'Staf atas nama <strong>' . ucwords($staf->nama) . '</strong> STR akan mendekati Habis Berlaku ' . $str_expiry_date->diffInMonths( Carbon::now()->floorMonth() ) . ' bulan lagi';
            }

            foreach ($almost_expired_sips as $staf) {
                $sip_expiry_date = Carbon::parse( $staf->sip_expiry_date )->floorMonth();
                $warning_kuning[] = 'Staf atas nama <strong>' . ucwords($staf->nama) . '</strong> STR akan mendekati Habis Berlaku ' . $sip_expiry_date->diffInMonths( Carbon::now()->floorMonth() ) . ' bulan lagi';
            }

            foreach ($expired_strs as $staf) {
                $str_expiry_date = Carbon::parse( $staf->str_expiry_date )->floorMonth();
                $warning_merah[] = 'Staf atas nama <strong>' . ucwords($staf->nama) . '</strong> Sudah habis masa berlaku STR nya. Harap segera diperbarui';
            }

            foreach ($expired_sips as $staf) {
                $sip_expiry_date = Carbon::parse( $staf->sip_expiry_date )->floorMonth();
                $warning_merah[] = 'Staf atas nama <strong>' . ucwords($staf->nama) . '</strong> Sudah habis masa berlaku SIP nya. Harap segera diperbarui';
            }

            $document_almost_expired = Document::whereRaw("TIMESTAMPDIFF(MONTH, now(), expiry_date) < 6 and expiry_date > now()")->get();
            $document_expired = Document::where('expiry_date', '<', date('Y-m-d'))->get();

            foreach ($document_almost_expired as $document) {
                $expiry_date = Carbon::parse( $document->expiry_date )->floorMonth();
                $warning_kuning[] = '<strong>' . ucwords($document->nama) . '</strong> akan mendekati Habis Berlaku ' . $expiry_date->diffInMonths( Carbon::now()->floorMonth() ) . ' bulan lagi';
            }

            foreach ($document_expired as $document) {
                $expiry_date = Carbon::parse( $document->expiry_date )->floorMonth();
                $warning_merah[] = '<strong>' . ucwords($document->nama) . '</strong> telah Habis masa berlakunya ';
            }

            $stafs_str_expiry_date_kosong = Staf::whereRaw('(str_expiry_date is null or str_expiry_date = "") and (str_image is not null and str_image not like "") and aktif = 1')->get();

            $stafs_sip_expiry_date_kosong = Staf::whereRaw('(sip_expiry_date is null or sip_expiry_date = "") and (sip_image is not null or sip_image not like "") and aktif = 1')->get();

            $warning_biru = [];
            foreach ($stafs_str_expiry_date_kosong as $staf) {
                $warning_biru[$staf->id] = '<strong>' . ucwords($staf->nama). '</strong> belum mengisi <strong>Masa Belaku STR</strong> harap dilengkapi';
            }

            foreach ($stafs_sip_expiry_date_kosong as $staf) {
                $warning_biru[$staf->id] = '<strong>' . ucwords($staf->nama). '</strong> belum mengisi <strong>Masa Belaku SIP</strong> harap dilengkapi';
            }


            if ( count($warning_kuning)  ) {
                session()->put('warning_kuning', $warning_kuning);
            }
            if ( count($warning_merah) ) {
                session()->put('warning_merah', $warning_merah);
            }
            if ( count($warning_biru) ) {
                session()->put('warning_biru', $warning_biru);
            }
        }
    }
}
