<?php


namespace App\Traits;
use App\Models\Tenant;

trait WhatsappBot
{
    protected static function bootWhatsappBot()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function($model) {
            if(session()->has('tenant_id')) {
                $model->tenant_id = session()->get('tenant_id');
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
