<?php

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\dashboardController;
use App\Http\Controllers\admin\AdminDashboardController;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//USER_ROUTES_START

Route::get('/', function () {
    return view('pages.index');
})->name('/');

Route::get('/admin', function (Request $request) {

    return $getLatestWithdraw = \App\Models\Article::where('user_id', 62)->where('withdraw_date')->latest()->first();
     $getLatestWithdrawDate = $getLatestWithdraw->withdraw_date;


     $data = \App\Models\Article::where('created_at', '>', $getLatestWithdrawDate)
    ->orderBy('created_at')
    ->take(30)
    ->get();
    return $data->last();
    return count($data);


    $a = 'Hellow! this is my first article and i want to check plagarism';

    $submittedArticleContent = $a;

    $preprocessedSubmittedContent = Str::lower(Str::remove([' ', '\t', '\n', '\r', '\0', '\x0B'], $submittedArticleContent));

    $existingArticles = \App\Models\Article::where('article_type', 'text')->get();
// return $existingArticles;
    // Step 4 and 5: Compare Content and Calculate Plagiarism Level

    $threshold = 0.8;
    $plagiarizedArticles = [];

    foreach ($existingArticles as $existingArticle) {

        $preprocessedExistingContent = Str::lower(Str::remove([' ', '\t', '\n', '\r', '\0', '\x0B'], $existingArticle->article));
        $n = similar_text($preprocessedSubmittedContent, $preprocessedExistingContent, $similarityPercentage);
        if ($similarityPercentage >= $threshold) {
            $plagiarizedArticles[] = [
                'article' => $existingArticle,
                'similarity' => $similarityPercentage,
            ];
        }
    }

    if (!empty($plagiarizedArticles)) {
        foreach ($plagiarizedArticles as $plagiarizedArticle) {
            $article = $plagiarizedArticle['article'];
            $similarity = $plagiarizedArticle['similarity'];
            return $similarity;

            // You can log the plagiarized article or notify the user/admin about plagiarism
            // For example:
            $log=Log::warning("Submitted article is similar to Article #$article->id with $similarity% similarity.");
        }
    } else {
        return 'The article is unique, you can save it to the database';
    }

    // return view('admin.index');
});


Route::post('ajaxregister', [RegisterController::class, 'ajaxregister'])->name('ajaxregister');
Route::post('ajaxlogin', [AuthController::class, 'ajaxLogIn'])->name('ajaxlogin');

Route::get('verify', [AdminController::class, 'verify'])->name('verify');



Auth::routes();

Route::middleware(['auth:web'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('dashboard', [dashboardController::class, 'Dashboard'])->name('dashboard');

    Route::post('save_article', [dashboardController::class, 'SaveArticle'])->name('save_article');
    Route::post('withdraw_request', [dashboardController::class, 'WithdrawRequest'])->name('withdraw_request');

    Route::post('userlogout', [AuthController::class, 'UserLogOut'])->name('userlogout');


});



//USER_ROUTES_END


//ADMIN_ROUTES_START

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {

        Route::get('login', function () {
            return view('admin.auth.login');
        })->name('login');

        Route::post('check', [AdminController::class, 'check'])->name('check');
    });

    Route::middleware(['auth:admin'])->group(function () {

        Route::get('home', [AdminController::class, 'Home'])->name('home');


        Route::post('adminlogout', [AdminController::class, 'AdminLogOut'])->name('adminlogout');
        Route::get('change_status/{id}', [AdminController::class, 'ChangeStatus'])->name('change_status');
        Route::delete('users_delete/{id}', [AdminController::class, 'Delete'])->name('delete');

        Route::get('user_article', [AdminDashboardController::class, 'UserArticle'])->name('user_article');
        Route::get('article_change_status/{id}', [AdminDashboardController::class, 'changeArticleStatus'])->name('article_change_status');
        Route::delete('delete_article/{id}', [AdminDashboardController::class, 'deleteArticle'])->name('delete_article');

        Route::get('withdraw', [AdminDashboardController::class, 'withDraw'])->name('withdraw');
        Route::get('withdraw_change_status/{id}', [AdminDashboardController::class, 'withdawChangeStatus'])->name('withdraw_change_status');
        Route::delete('delete_withdraw/{id}', [AdminDashboardController::class, 'deleteWithdraw'])->name('delete_withdraw');

        Route::get('referrals', [AdminDashboardController::class, 'Referrals'])->name('referrals');
        Route::get('update_profile/{id}', [AdminController::class, 'updateProfile'])->name('update_profile');
        Route::post('save_update_profile/{id}', [AdminController::class, 'saveUpdateProfile'])->name('save_update_profile');


    });
});

//ADMIN_ROUTES_END
