  <?php

  namespace App\Traits;

  trait BelongsToTenant
  {
      protected function boot(){
        static::addGlobalScope(new TenantScope);
        static::creating(function($model){
            if (session()->has('tenant_id')) {
                $model->tenant_id = session()->get('tenant_id');
            }
        });
      }
  }
