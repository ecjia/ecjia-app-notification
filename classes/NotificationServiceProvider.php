<?php

namespace Ecjia\App\Notification;

use Royalcms\Component\App\AppParentServiceProvider;

class NotificationServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-notification', null, dirname(__DIR__));
    }
    
    public function register()
    {
        
    }
    
    
    
}