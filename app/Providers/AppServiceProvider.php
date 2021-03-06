<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Permissions
        Gate::define('manage_categories', function(User $user) {
            return $user->is_admin == 1;
        });
        Gate::define('manage_addresses', function(User $user) {
            return $user->is_admin == 1;
        });

        // Blade directives
        Blade::directive('camel', function ($expression) {
            return "<?php echo Illuminate\Support\Str::camel($expression); ?>";
        });
        Blade::directive('currency', function ($expression) {
            return "<?php echo number_format($expression, 2, ',', ' '); ?>";
        });
        Blade::directive('date', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y'); ?>";
        });
        Blade::directive('datedit', function ($expression) {
            return "<?php echo ($expression)->format('Y-m-d'); ?>";
        });
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y @ H:i'); ?>";
        });
        Blade::directive('gravatar', function ($expression) {
            return "<?php echo md5(strtolower(trim($expression))); ?>";
        });
        Blade::directive('leadingzero', function ($expression) {
            return "<?php echo str_pad($expression, 2, '0', STR_PAD_LEFT); ?>";
        });
        Blade::directive('lcfirst', function ($expression) {
            return "<?php echo lcfirst($expression); ?>";
        });
        Blade::directive('lowercase', function ($expression) {
            return "<?php echo strtolower($expression); ?>";
        });
        Blade::directive('nl2br', function ($expression) {
            return sprintf('<?php echo nl2br(e(%s)); ?>', $expression);
        });
        Blade::directive('slug', function ($expression) {
            return "<?php echo str_replace('_', ' ', $expression); ?>";
        });
        Blade::directive('time', function ($expression) {
            return "<?php echo ($expression)->format('H:i:s'); ?>";
        });
        Blade::directive('ucfirst', function ($expression) {
            return "<?php echo ucfirst($expression); ?>";
        });
        Blade::directive('uppercase', function ($expression) {
            return "<?php echo strtoupper($expression); ?>";
        });
        Blade::directive('urlencode', function ($expression) {
            return "<?php echo urlencode($expression); ?>";
        });
        Blade::directive('urlhost', function ($expression) {
            return "<?php echo parse_url($expression, PHP_URL_HOST); ?>";
        });
        Blade::directive('year', function ($expression) {
            return "<?php echo ($expression)->format('Y'); ?>";
        });
    }
}
