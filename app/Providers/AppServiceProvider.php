<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        Blade::directive('year', function ($expression) {
            return "<?php echo ($expression)->format('Y'); ?>";
        });
    }
}
