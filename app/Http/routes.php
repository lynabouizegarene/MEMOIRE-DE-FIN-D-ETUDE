<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('acceuil', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
/*-------------------------------------------------------------*/
Route::get('covoiturage/publier', [
    'as' => 'covoiturage/create',
    'uses' => 'CovoiturageController@create'
]);
Route::post('covoiturage/enregistrer',[
    'as' => 'covoiturage/store',
    'uses' => 'CovoiturageController@store',
]);
Route::post('covoiturage/recherche',[
    'as' => 'covoiturage/search',
    'uses' => 'CovoiturageController@search',
]);
Route::get('covoiturage/{id}', [
    'as' => 'covoiturage/show',
    'uses' => 'CovoiturageController@show'
])->where(['id' => '[0-9]+']);

Route::get('covoiturage', [
    'as' => 'covoiturage/index',
    'uses' => 'CovoiturageController@index'
]);
Route::post('covoiturage/inscription',[
    'as'=>'covoiturage/register',
    'uses'=>'CovoiturageController@register'
]);

/*-------------------------------------------------------------*/
Route::post('covoiturage/accepter',[
    'as'=>'covoiturage/accept',
    'uses'=>'CovoiturageController@accept'
]);
Route::post('covoiturage/refuser',[
    'as'=>'covoiturage/refuse',
    'uses'=>'CovoiturageController@refuse'
]);
Route::post('covoiturage/annuler',[
    'as'=>'covoiturage/cancel',
    'uses'=>'CovoiturageController@cancel'
]);
Route::post('covoiturage/annuler_resarvation',[
    'as'=>'covoiturage/cancel_reservation',
    'uses'=>'CovoiturageController@cancel_reservation'
]);
Route::post('covoiturage/supprimer',[
    'as'=>'covoiturage/destroy',
    'uses'=>'CovoiturageController@destroy'
]);
/*-------------------------------------------------------------*/
Route::get('profil/{id}', [
    'as' => 'user/show',
    'uses' => 'UserController@show'
])->where(['id' => '[0-9]+']);

Route::get('profil/editer', [
    'as'=>'user/edit',
    'uses'=>'UserController@edit'
]);
Route::post('profil/enregistrer',[
    'as'=>'user/store',
    'uses'=>'UserController@store'
]);
/*-------------------------------------------------------------*/
Route::post('commentaire/enregistrer',[
    'as'=>'comment/store',
    'uses'=>'CommentaireController@store'
]);
Route::post('note/enregistrer',[
    'as'=>'note/store',
    'uses'=>'NoteController@store'
]);

/*-------------------------------------------------------------*/
Route::get('comment_ca_marche',[
    'as'=>'comment_ca_marche',
    'uses' =>'WelcomeController@ccm'
]);

/*-------------------------------------------------------------*/
Route::get('notification',[
   'as'=>'notifier',
    'uses'=>'NotificationController@show'
]);
Route::get('notificationVu/{id}',[
    'as'=>'notificationVu',
    'uses'=>'NotificationController@notificationVu'
])->where(['id' => '[0-9]+']);

