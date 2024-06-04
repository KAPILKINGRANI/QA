<?php

namespace App\Providers;

use App\Models\Question;
use App\Models\User;
use App\Policies\QuestionPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Route::bind('slug', function (string $slug) {
            return Question::where('slug', $slug)->firstOrFail();
        });

        Gate::define('edit-question', function (User $user, Question $question) {
            return $user->id === $question->user_id;
        });
        Gate::policy(Question::class, QuestionPolicy::class);
    }
}
