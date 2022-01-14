<?php

namespace App\Providers;

use App\Models\Filial;
use App\Models\Post;
use App\Models\Tv;
use App\Observers\FilialObserver;
use App\Observers\PostObserver;
use App\Observers\TvFilialObserver;
use App\Observers\TvObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
        Filial::observe(FilialObserver::class);
        Tv::observe(TvObserver::class);        
    }
}
