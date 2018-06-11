<?php

namespace Ecjia\App\Notification;

use Royalcms\Component\App\AppServiceProvider;

class NotificationServiceProvider extends  AppServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-notification');
    }
    
    public function register()
    {
        
    }
    
    
    
}