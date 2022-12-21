<?php

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
//TOPページ
Route::get('/', 'TopController@getTopPage')->name('getTop');

//イベント用のページ
Route::get('EventSearch', 'EventController@getSearchPage');
Route::get('searchEvent', 'EventController@getSearchEvent');
Route::post('searchEvent', 'EventController@getSearchEvent');
Route::get('EventCreate', 'EventController@getCreatePage');
Route::post('createEvent', 'EventController@createEvent');
Route::get('detailAddPage', 'EventController@getEventActorAddPage')->name('getDetailAddPage');
Route::get('addActor', 'EventController@addActor');
Route::post('addActor', 'EventController@addActor');
Route::get('addUnit', 'EventController@addUnit');
Route::post('addUnit', 'EventController@addUnit');
Route::get('eventdetail', 'EventController@getDetailPage');
Route::post('addProduct', 'EventController@addProduct');
Route::get('addSetList', 'EventController@addSetList');
Route::post('addSetList', 'EventController@addSetList');
Route::get('soldOut', 'EventController@soldOut');
Route::post('soldOut', 'EventController@soldOut');
Route::get('cansel', 'EventController@cansel');
Route::post('cansel', 'EventController@cansel');
Route::get('updateEvent', 'EventController@updateEvent');
Route::post('updateEvent', 'EventController@updateEvent');

//マスタ編集用のページ
Route::get('modMaster', 'ModMasterController@getMasterTopPage');
Route::get('addActorInfo', 'ModMasterController@getActorInfoPage')->name('getAddActorInfo');
Route::get('addUnitInfo', 'ModMasterController@getUnitInfoPage')->name('getAddUnitInfo');
Route::get('addActorDetailInfo', 'ModMasterController@getActorDetailInfoPage')->name('getAddActorDetailInfo');
Route::get('addUnitDetailInfo', 'ModMasterController@getUnitDetailInfoPage')->name('getAddUnitDetailInfo');
Route::get('addMVoiceActor', 'ModMasterController@addActorInfo');
Route::post('addMVoiceActor', 'ModMasterController@addActorInfo');
Route::get('addMUnit', 'ModMasterController@addUnitInfo');
Route::post('addMUnit', 'ModMasterController@addUnitInfo');
Route::get('searchActor', 'ModMasterController@getActorInfoList');
Route::post('searchActor', 'ModMasterController@getActorInfoList');
Route::get('searchUnit', 'ModMasterController@getUnitInfoList');
Route::post('searchUnit', 'ModMasterController@getUnitInfoList');
Route::get('addMCd', 'ModMasterController@addMcd');
Route::post('addMCd', 'ModMasterController@addMcd');
Route::get('getAddMusicPage', 'ModMasterController@getAddMusicPage')->name('getAddMusicPage');
Route::get('addMusic', 'ModMasterController@addMusic');
Route::post('addMusic', 'ModMasterController@addMusic');
Route::get('getAnimeAddpage', 'ModMasterController@getAnimeAddpage')->name('getAnimeAddpage');
Route::get('addAnime', 'ModMasterController@addAnime');
Route::post('addAnime', 'ModMasterController@addAnime');
Route::get('getAnimePageLst', 'ModMasterController@getAnimePageLst');
Route::post('getAnimePageLst', 'ModMasterController@getAnimePageLst');
Route::get('getAddAnimeCastPage', 'ModMasterController@getAddAnimeCastPage')->name('getAddAnimeCastPage');
Route::get('addAnimeCast', 'ModMasterController@addAnimeCast');
Route::post('addAnimeCast', 'ModMasterController@addAnimeCast');
Route::get('getAriaAddpage', 'ModMasterController@getAriaAddpage')->name('getAriaAddpage');
Route::get('addAria', 'ModMasterController@addAria');
Route::post('addAria', 'ModMasterController@addAria');
Route::get('addMUnitMember', 'ModMasterController@addMUnitMember');
Route::post('addMUnitMember', 'ModMasterController@addMUnitMember');
Route::get('addNews', 'ModMasterController@addNews');
Route::post('addNews', 'ModMasterController@addNews');

//声優情報検索ページ
Route::get('searchActorInfoTop', 'SearchActorController@searchActorInfoTop');
Route::get('getActorPageLst', 'SearchActorController@getActorPageLst');
Route::post('getActorPageLst', 'SearchActorController@getActorPageLst');
Route::get('getUnitPageLst', 'SearchActorController@getUnitPageLst');
Route::post('getUnitPageLst', 'SearchActorController@getUnitPageLst');
Route::get('getDetailActorInfo', 'SearchActorController@getDetailActorInfo');
Route::get('getDetailUnitInfo', 'SearchActorController@getDetailUnitInfo');
Route::get('getMusicInfo', 'SearchActorController@getMusicInfo');

//個人用のページ
Route::get('Private', 'PrivateController@getTopPage')->name('getTopPage');
Route::get('getAddUserPage', 'PrivateController@getAddUserPage');
Route::post('getAddUserPage', 'PrivateController@getAddUserPage')->name('getAddUserPage');
Route::get('addUser', 'PrivateController@addUser');
Route::post('addUser', 'PrivateController@addUser');
Route::get('login', 'PrivateController@login');
Route::post('login', 'PrivateController@login');
Route::get('logout', 'PrivateController@logout');
Route::post('logout', 'PrivateController@logout');
Route::post('matchActor', 'PrivateController@matchActor');
