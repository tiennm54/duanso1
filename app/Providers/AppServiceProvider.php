<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\CategoryFaq;
use App\Models\Information;
use View;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        View::composer('*', function($view) {
            $model_cate_menu = Category::all();
            $model_cate_faq = CategoryFaq::all();
            $model_inform = Information::orderBy("id","ASC")->get();
            $view->with('model_cate_menu', $model_cate_menu)->with('model_cate_faq', $model_cate_faq)->with('model_inform', $model_inform);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
