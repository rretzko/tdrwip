<?php

namespace App\Providers;

use App\Events\FileuploadRejectionEvent;
use App\Events\MembershipRequestEvent;
use App\Listeners\FileuploadRejectionStudentEmailListener;
use App\Listeners\SendMembershipRequestEmailListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MembershipRequestEvent::class => [
            SendMembershipRequestEmailListener::class,
        ],
        FileuploadRejectionEvent::class => [
            FileuploadRejectionStudentEmailListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
