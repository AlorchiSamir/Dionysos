<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/step/2/hall-owner', 'MetierController@hallOwner')->name('step');
Route::get('/step/2/{id}', 'SkillController@list')->name('step'); 

Route::middleware('isuser.notprofessional')->group(function() {
    Route::get('/project', 'ProjectController@index')->name('project');
    Route::get('/project/create', 'ProjectController@edit')->name('project.edit');
    Route::get('/advice', 'AdviceController@index')->name('advice');
    Route::get('/interaction/{type}', 'InteractionController@index')->name('interest');
});

Route::middleware('professional.step')->group(function() {

    Route::get('/', 'IndexController@index')->name('home');
    Route::get('/studio', 'VideoController@index')->name('videos.index'); 
    Route::get('/messages', 'MessageController@index')->name('message');
    Route::get('/message/{id}', 'MessageController@view')->name('message.view');
    Route::get('/search', 'SearchController@index')->name('search');
    Route::get('/settings', 'SettingController@index')->name('settings');    
    Route::get('/settings/videos', 'VideoController@edit')->name('videos');
    Route::get('/settings/networks', 'SocialNetworkController@edit')->name('networks');
    Route::get('/settings/{category}', 'SettingController@index')->name('settings');    
    Route::get('/professional', 'ProfessionalController@index')->name('professionals');
    Route::get('/metier', 'MetierController@index')->name('metier'); 
    Route::get('/skill', 'SkillController@index')->name('skill'); 
    Route::get('/professional/{id}/{slug}', 'ProfessionalController@view')->name('professional');
    Route::get('/metier/{id}/{slug}', 'MetierController@view')->name('metier.view'); 
    Route::get('/skill/{id}/{slug}', 'SkillController@view')->name('skill.view'); 
    Route::get('/step/{n}', 'ProfessionalController@step')->name('step'); 
    Route::get('/address/create', 'AddressController@create')->name('address');

    Route::get('/company', 'CompanyController@index')->name('companies');
    Route::get('/company/{id}/{slug}', 'CompanyController@view')->name('company'); 

    Route::get('/hall', 'HallController@index')->name('halls');
    Route::get('/hall/{id}/{slug}', 'HallController@view')->name('hall'); 
    Route::get('/hall/{id}/{slug}/gallery', 'HallController@gallery')->name('hall.gallery');
    Route::get('/hall/create', 'HallController@edit')->name('hall.edit')->middleware('ishallowner');
    Route::get('/hall/owner-page', 'HallController@ownerPage')->name('owner-page')->middleware('ishallowner');
    Route::get('/hall/settings/{id}/{slug}', 'HallController@settings')->name('hall.settings')->middleware('ishallowner');
    Route::get('/hall/settings/{id}/{slug}/images', 'ImageController@edit')->name('hall.settings.images')->middleware('ishallowner'); 
    Route::get('/hall/settings/{id}/{slug}/{category}', 'HallController@settings')->name('hall.settings')->middleware('ishallowner');   
    
    

}); 

Route::get('/person/searching', 'SearchController@index')->name('person.ajax.metier');
Route::get('/company/searching', 'SearchController@index')->name('company.ajax.metier');
Route::get('/hall/searching', 'SearchController@index')->name('hall.ajax.metier');
Route::get('/professional/rangeBySkills', 'ProfessionalController@rangeBySkills')->name('professional.skills');

Route::post('/message/send', 'MessageController@edit')->name('message.send');
Route::post('/hall/create', 'HallController@edit')->name('hall.edit');
Route::post('/advice/add', 'AdviceController@add')->name('advice.add');
Route::post('/professional/skill/add', 'SkillController@add')->name('skill.add');
Route::post('/settings/videos', 'VideoController@edit')->name('videos');
Route::post('/settings/networks', 'SocialNetworkController@edit')->name('networks');
Route::post('/settings/{category}', 'SettingController@index')->name('settings');
Route::post('/company/create', 'CompanyController@edit')->name('company.edit');
Route::post('/address/create', 'AddressController@create')->name('address');
Route::post('/address/update/{id}', 'AddressController@update')->name('address.update');
Route::post('/address/hall/update/{id}/{slug}', 'AddressController@updateHall')->name('address.hall.update');
Route::post('/settings', 'SettingController@index')->name('settings');
Route::post('/metier/skill/{id}', 'SkillController@stepList')->name('skill.ajaxList');
Route::post('/metier', 'MetierController@stepList')->name('metier.ajaxList');
Route::post('/project/create', 'ProjectController@edit')->name('project.edit');
Route::post('/hall/settings/{id}/{slug}', 'HallController@settings')->name('hall.settings')->middleware('ishallowner');
Route::post('/hall/settings/{id}/{slug}/images', 'ImageController@edit')->name('hall.settings.images')->middleware('ishallowner');
Route::post('/hall/settings/{id}/{slug}/{category}', 'HallController@settings')->name('hall.settings')->middleware('ishallowner');   

Route::post('/professional/rangeByMetier', 'ProfessionalController@rangeByMetierWithAjax')->name('professional.ajax.metier');
Route::post('/person/searching', 'ProfessionalController@searching')->name('professional.ajax.searching');
Route::post('/professional/rangeBySkillsAndCities', 'ProfessionalController@rangeBySkillsAndCitiesWithAjax')->name('professional.ajax.skills');

Route::post('/company/rangeByMetier', 'CompanyController@rangeByMetierWithAjax')->name('company.ajax.metier');
Route::post('/company/searching', 'CompanyController@searching')->name('company.ajax.searching');
Route::post('/company/rangeBySkillsAndCities', 'CompanyController@rangeBySkillsAndCitiesWithAjax')->name('company.ajax.skills');

Route::post('/hall/searching', 'HallController@searching')->name('hall.ajax.searching');

Route::post('/metier/getOptions', 'MetierController@getOptions')->name('metier.ajax.options');
Route::post('/interaction/rangeByMetier', 'InteractionController@rangeByMetier')->name('interaction.ajax.metier');
Route::post('/interaction/allMetier', 'InteractionController@allMetier')->name('interaction.ajax.metier');
Route::post('/user/interaction', 'InteractionController@interaction');
Route::post('/advice/report', 'AdviceController@report');
Route::post('/search/register', 'SearchController@register');

Route::middleware('admin')->group(function() {

    Route::get('/admin', 'Admin\AdminController@index')->name('admin');

    Route::get('/admin/professional', 'Admin\ProfessionalController@index')->name('admin.professional');
    Route::get('/admin/professional/validate/{id}', 'Admin\ProfessionalController@validated')->name('admin.professional.validated');

    Route::get('/admin/metier', 'Admin\MetierController@index')->name('admin.metier');
    Route::get('/admin/metier/create', 'Admin\MetierController@create')->name('admin.metier.create');
    Route::post('/admin/metier/create', 'Admin\MetierController@create')->name('admin.metier.create');    
    Route::get('/admin/metier/update/{id}', 'Admin\MetierController@update')->name('admin.metier.update');
    Route::post('/admin/metier/update/{id}', 'Admin\MetierController@update')->name('admin.metier.update');

    Route::get('/admin/metier/skill/{id}', 'Admin\SkillController@index')->name('admin.skill');
    Route::get('/admin/metier/skill/create/{id}', 'Admin\SkillController@create')->name('admin.skill.create');
    Route::post('/admin/metier/skill/create/{id}', 'Admin\SkillController@create')->name('admin.skill.create');    
    Route::get('/admin/metier/skill/update/{id}', 'Admin\SkillController@update')->name('admin.skill.update');
    Route::post('/admin/metier/skill/update/{id}', 'Admin\SkillController@update')->name('admin.skill.update');

    Route::get('/admin/message', 'Admin\MessageController@index')->name('admin.message');
    Route::get('/admin/advice', 'Admin\AdviceController@index')->name('admin.advice');
});
