<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\JobRepositoryInterface;
use App\Repositories\JobRepository;
use App\Interfaces\ApplicationRepositoryInterface;
use App\Repositories\ApplicationRepository;
use App\Interfaces\CandidateRepositoryInterface;
use App\Repositories\CandidateRepository;
use App\Interfaces\RecruiterRepositoryInterface;
use App\Repositories\RecruiterRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
        $this->app->bind(ApplicationRepositoryInterface::class, ApplicationRepository::class);
        $this->app->bind(CandidateRepositoryInterface::class, CandidateRepository::class);
        $this->app->bind(RecruiterRepositoryInterface::class, RecruiterRepository::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
