<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('notLogin')->group(function () {
    Route::post('/register', 'AuthController@storeRegister')->name('post.register');
    Route::get('/register', 'AuthController@register')->name('register');
    Route::get('/login', 'AuthController@login')->name('login');
    Route::post('/login', 'AuthController@storeLogin')->name('post.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::get('/', 'QuestionController@home')->name('home');

    ##profile edit
    Route::get('/profile/edit', 'PageController@editProfile')->name('profile.edit');
    Route::post('/profile/edit', 'PageController@updateProfile')->name('profile.update');
    ##user question
    Route::get('/profile/question', 'QuestionController@userQuestion')->name('user.question');

    ##question detail
    Route::get('/question/detail/{slug}/{id}', 'QuestionController@detail')->name('question.detail');

    ##question delete
    Route::get('/question/delete/{id}', 'QuestionController@delete')->name('question.delete');

    ##question save
    Route::get('/question/save/{id}', 'QuestionController@save')->name('question.save');

    ##question unsave
    Route::get('/question/unsave/{id}', 'QuestionController@unsave')->name('question.unsave');



    ##question fix
    Route::get('/question/fix/{id}', 'QuestionController@questionFix')->name('question.fix');
    ##question unfix
    Route::get('/question/unfix/{id}', 'QuestionController@questionUnfix')->name('question.unfix');

    ##like unlike
    Route::get('/question/like/{id}', 'QuestionController@like')->name('question.like');
    Route::get('/question/unlike/{id}', 'QuestionController@unlike')->name('question.unlike');

    ##comment
    Route::post('/question/comment/send', 'QuestionController@createComment')->name('comment.create');

    ##question create
    Route::get('/question/create', 'QuestionController@createQuestion')->name('question.create');
    Route::post('/question/create', 'QuestionController@storeQuestion')->name('question.store');


});
