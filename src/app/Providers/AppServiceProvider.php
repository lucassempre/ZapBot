<?php

namespace App\Providers;

use App\Domain\Repositories\BaseRepositoryInterface;
use App\Domain\Repositories\MessageRepositoryInterface;
use App\Domain\Repositories\StatusRepositoryInterface;
use App\Domain\Repositories\TelefoneRepositoryInterface;
use App\Domain\Repositories\WebhookRepositoryInterface;
use App\Infrastructure\Repositories\BaseRepository;
use App\Infrastructure\Repositories\MessageRepository;
use App\Infrastructure\Repositories\StatusRepository;
use App\Infrastructure\Repositories\TelefoneRepository;
use App\Infrastructure\Repositories\WebhookRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TelefoneRepositoryInterface::class, TelefoneRepository::class);
        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);
        $this->app->bind(WebhookRepositoryInterface::class, WebhookRepository::class);
        $this->app->bind(StatusRepositoryInterface::class, StatusRepository::class);
        $this->app->bind(BaseRepository::class, BaseRepositoryInterface::class);

    }

    public function boot()
    {
        //
    }
}
