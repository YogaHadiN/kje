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
        if ( $event->user->role_id != 1 ) {
            $almost_expired_strs = Staf::whereRaw("TIMESTAMPDIFF(MONTH, now(), str_expiry_date) < 6 and str_expiry_date > now()")->get();
            $almost_expired_sips = Staf::whereRaw("TIMESTAMPDIFF(MONTH, now(), sip_expiry_date) < 6 and sip_expiry_date > now()")->get();
            $expired_strs = Staf::where('str_expiry_date', '<', date('Y-m-d'))->get();
            $expired_sips = Staf::where('sip_expiry_date', '<', date('Y-m-d'))->get();

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

            if ( count($warning_kuning)  ) {
                session()->put('warning_kuning', $warning_kuning);
            }
            if ( count($warning_merah) ) {
                session()->put('warning_merah', $warning_merah);
            }
        }
    }
}
