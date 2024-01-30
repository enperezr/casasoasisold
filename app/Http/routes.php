<?php

use App\Http\Controllers\PortalController;
use App\Action;
use App\TypeProperty;
use App\User;
use App\Province;
use App\Municipio;
use Illuminate\Support\Facades\Route;


//login routes
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::get('{lang?}/auth/login', 'Auth\AuthController@getLogin')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::post('{lang?}/auth/login', 'Auth\AuthController@postLogin')->where(['lang' => \App\Helper::languages4Route()]);
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('{lang?}/auth/logout', 'Auth\AuthController@getLogout')->where(['lang' => \App\Helper::languages4Route()]);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::get('{lang?}/auth/register', 'Auth\AuthController@getRegister')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::post('{lang?}/auth/register', 'Auth\AuthController@postRegister')->where(['lang' => \App\Helper::languages4Route()]);;

//admin routes
Route::controller('admin/users', 'UserAdminController');
Route::controller('{lang?}/admin/users', 'UserAdminController');
Route::controller('admin/comments', 'CommentAdminController');
Route::controller('{lang?}/admin/comments', 'CommentAdminController');
Route::controller('admin/properties', 'PropertyAdminController');
Route::controller('{lang?}/admin/properties', 'PropertyAdminController');
Route::controller('admin/ads', 'AdAdminController');
Route::controller('{lang?}/admin/ads', 'AdAdminController');
Route::controller('telegram-bot/focus', 'TelegramAntifocusController');
Route::post('admin/finances/plans/save', 'FinanceController@savePlan');
Route::post('{lang?}/admin/finances/plans/save', 'FinanceController@savePlan')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('admin/finances/plans/publish', 'FinanceController@togglePlan');
Route::post('{lang?}/admin/finances/plans/publish', 'FinanceController@togglePlan')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('admin/finances/plans/delete', 'FinanceController@deletePlan');
Route::post('{lang?}/admin/finances/plans/delete', 'FinanceController@deletePlan')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('admin/finances/commissions/save', 'FinanceController@saveCommission');
Route::post('{lang?}/finances/commissions/save', 'FinanceController@saveCommission')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('admin/finances/calculate', 'FinanceController@calculate');
Route::post('{lang?}/admin/finances/calculate', 'FinanceController@calculate')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('admin/finances/fix-register', 'FinanceController@fixRegister');
Route::post('{lang?}/admin/finances/fix-register', 'FinanceController@fixRegister')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('admin/finances/delete-register', 'FinanceController@deleteRegister');
Route::post('{lang?}/finances/delete-register', 'FinanceController@deleteRegister')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('admin/finances/custom-plan', 'FinanceController@customPlan');
Route::post('{lang?}/admin/finances/custom-plan', 'FinanceController@customPlan')->where(['lang' => \App\Helper::languages4Route()]);
Route::controller('admin/finances', 'FinanceController');
Route::controller('{lang?}/admin/finances', 'FinanceController');
Route::controller('admin', 'AdminController');
Route::controller('{lang?}/admin', 'AdminController');

//user routes
Route::get('user/modify/property/{id}', 'UserController@modifyProperty')->where('id', '[0-9]+');
Route::get('{lang?}/user/modify/property/{id}', 'UserController@modifyProperty')->where('id', '[0-9]+');
Route::post('prospect/save', 'ProspectController@save');
Route::post('{lang?}/prospect/save', 'ProspectController@save')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('prospect/update', 'ProspectController@update');
Route::post('{lang?}/prospect/update', 'ProspectController@update')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('special/save/{apk?}', 'ProspectController@specialSave');
Route::post('{lang?}/special/save/{apk?}', 'ProspectController@specialSave')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('special/update', 'ProspectController@specialUpdate');
Route::post('{lang?}/special/update', 'ProspectController@specialUpdate')->where(['lang' => \App\Helper::languages4Route()]);
Route::get('user/temporal', 'Auth\AuthController@getTemporal');
Route::get('{lang?}/user/temporal', 'Auth\AuthController@getTemporal')->where(['lang' => \App\Helper::languages4Route()]);
Route::controller('user', 'UserController');
Route::controller('{lang?}/user', 'UserController');
Route::get('user/dashboard', 'UserController@construction');
Route::get('{lang?}/user/dashboard', 'UserController@construction')->where(['lang' => \App\Helper::languages4Route()]);


//Mail routes
Route::controller('mail', 'MailController');
Route::controller('{lang?}/mail', 'MailController');

//Property add routes
Route::controller('new-property', 'PropertyController');
Route::controller('{lang?}/new-property', 'PropertyController');

//Update app routes
Route::controller('update', 'UpdateController');
Route::controller('{lang?}/update', 'UpdateController');

//routes for search

//old Urls Redirect
Route::get('{action}/propiedad', function ($action) {
  return redirect()->route('bigsearch', ['lang' => 'es', 'action' => $action, 'type_property' => 'viviendas'], 301);
});

Route::get('listado-casas-venta-permuta-cuba', function () {
   return redirect()->route('bigsearch', ['lang' => 'es', 'action' => 'permuta', 'type_property' => 'viviendas'], 301);
});

Route::get('{lang?}/listado-casas-venta-permuta-cuba', function ($lang) {
   return redirect()->route('bigsearch', ['lang' => $lang, 'action' => 'permuta', 'type_property' => 'viviendas'], 301);
});

// End old Urls redirects

//Route for searchs

Route::get(
   '{lang}/{action}/{type_property}/{province?}/{municipio?}/{locality?}/{identifier?}',
   [
      'as' => 'bigsearch', 'uses' => 'PortalController@getSearch'
   ]
)->where(['province' => Province::getUrls(), 'action' => Action::getUrls(), 'lang' => \App\Helper::languages4Route(), 'type_property'=> TypeProperty::getPluralUrls()]);


//Redirect olds Urls
Route::get('{lang}/{action}/casa/{province?}/{municipio?}/{locality?}/{identifier?}', function ($lang, $action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => $lang, 'action' => $action,'type_property'=> "casas", 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{action}/casa/{province?}/{municipio?}/{locality?}/{identifier?}', function ($action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => 'es', 'action' => $action,'type_property'=> "casas", 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{lang}/{action}/casa-independiente/{province?}/{municipio?}/{locality?}/{identifier?}', function ($lang, $action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => $lang, 'action' => $action, 'type_property' => 'casas-independientes', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{action}/casa-independiente/{province?}/{municipio?}/{locality?}/{identifier?}', function ($action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => 'es', 'action' => $action, 'type_property' => 'casas-independientes', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{lang}/{action}/colonial/{province?}/{municipio?}/{locality?}/{identifier?}', function ($lang, $action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => $lang, 'action' => $action, 'type_property' => 'coloniales', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{action}/colonial/{province?}/{municipio?}/{locality?}/{identifier?}', function ($action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => 'es', 'action' => $action, 'type_property' => 'coloniales', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});


Route::get('{lang}/{action}/chalet/{province?}/{municipio?}/{locality?}/{identifier?}', function ($lang, $action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => $lang, 'action' => $action, 'type_property' => 'chalets', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{action}/chalet/{province?}/{municipio?}/{locality?}/{identifier?}', function ($action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => 'es', 'action' => $action, 'type_property' => 'chalets', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});


Route::get('{lang}/{action}/biplanta/{province?}/{municipio?}/{locality?}/{identifier?}', function ($lang, $action, $province = null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => $lang, 'action' => $action, 'type_property' => 'biplantas', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{action}/biplanta/{province?}/{municipio?}/{locality?}/{identifier?}', function ($action, $province = null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => 'es', 'action' => $action, 'type_property' => 'biplantas', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});


Route::get('{lang}/{action}/casa-de-campo/{province?}/{municipio?}/{locality?}/{identifier?}', function ($lang, $action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => $lang, 'action' => $action, 'type_property' => 'casas-de-campo', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{action}/casa-de-campo/{province?}/{municipio?}/{locality?}/{identifier?}', function ($action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => 'es', 'action' => $action, 'type_property' => 'casas-de-campo', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{lang}/{action}/apartamento/{province?}/{municipio?}/{locality?}/{identifier?}', function ($lang, $action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => $lang, 'action' => $action, 'type_property' => 'apartamentos', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{action}/apartamento/{province?}/{municipio?}/{locality?}/{identifier?}', function ($action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => 'es', 'action' => $action, 'type_property' => 'apartamentos', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{lang}/{action}/terreno/{province?}/{municipio?}/{locality?}/{identifier?}', function ($lang, $action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => $lang, 'action' => $action, 'type_property' => 'terrenos', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{action}/terreno/{province?}/{municipio?}/{locality?}/{identifier?}', function ($action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => 'es', 'action' => $action, 'type_property' => 'terrenos', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{lang}/{action}/local/{province?}/{municipio?}/{locality?}/{identifier?}', function ($lang, $action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => $lang, 'action' => $action, 'type_property' => 'locales', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

Route::get('{action}/local/{province?}/{municipio?}/{locality?}/{identifier?}', function ($action, $province=null, $municipio = null, $locality = null, $identifier = null) {
   return redirect()->route('bigsearch', ['lang' => 'es', 'action' => $action, 'type_property' => 'locales', 'province' => $province, 'municipio' => $municipio, 'locality' => $locality, 'identifier' => $identifier], 301);
});

//end redirec to old urls

//-------------------- Ajax search --------------------------

Route::get('{lang}/search', 'PortalController@getAjaxSearch')->where(['lang' => \App\Helper::languages4Route()]);

Route::get('search/', 'PortalController@getAjaxSearch');

//------------------- ajax localization urls ----------------

Route::get('properties/{action}/{type?}/{province?}', 'AjaxController@getPropertiesCount');
Route::get('{lang?}/properties/{action}/{type?}/{province?}', 'AjaxController@getPropertiesCount')->where(['lang' => \App\Helper::languages4Route()]);
Route::get('municipios/{province_id}', 'AjaxController@getMunicipiosLocalities');
Route::get('{lang?}/municipios/{province_id}', 'AjaxController@getMunicipiosLocalities')->where(['lang' => \App\Helper::languages4Route()]);
Route::get('localities/{municipio_id}', 'AjaxController@getLocalities');
Route::get('{lang?}/localities/{municipio_id}', 'AjaxController@getLocalities')->where(['lang' => \App\Helper::languages4Route()]);

//-------------------- commodities urls -----------------

Route::get('{lang}/commodities/{group_id}', 'AjaxController@getCommodities')->where(['lang' => \App\Helper::languages4Route()]);

//------------------- new property urls -----------------

Route::get('{lang}/nueva/propiedad/{apk?}', 'PortalController@getNewProperty')->where(['lang' => \App\Helper::languages4Route()]);
Route::get('{lang}/nueva/especial/{apk?}', 'PortalController@getNewSpecial')->where(['lang' => \App\Helper::languages4Route()]);

//------------------ add comment urls -------------------

Route::post('{lang}/property/addcomment', 'PortalController@postComment')->where(['lang' => \App\Helper::languages4Route()]);

//------------------ contact urls ------------------

Route::get('{lang}/contactenos', 'PortalController@getContactenos')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('contactenos/send', 'PortalController@postSendMail');
Route::post('{lang?}/contactenos/send', 'PortalController@postSendMail')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('contactowner/send', 'PortalController@postSendMailOwners');
Route::post('{lang?}/contactowner/send', 'PortalController@postSendMailOwners')->where(['lang' => \App\Helper::languages4Route()]);

//-------------------------------------------------------

Route::post('property/rate/{property}/{value}', 'AjaxController@postRateProperty');
Route::post('{lang?}/property/rate/{property}/{value}', 'AjaxController@postRateProperty')->where(['lang' => \App\Helper::languages4Route()]);
Route::get('property/{property_id}/images/', 'AjaxController@getPropertyImages');
Route::get('{lang?}/property/{property_id}/images/', 'AjaxController@getPropertyImages')->where(['lang' => \App\Helper::languages4Route()]);
Route::post('process/images', 'ImagesController@postNewImage');
Route::post('{lang?}/process/images', 'ImagesController@postNewImage')->where(['lang' => \App\Helper::languages4Route()]);

//--------------------- download urls-----------------------------

Route::get('{lang}/descargas', 'DownloadsController@getIndex')->where(['lang' => \App\Helper::languages4Route()]);
Route::get('descargas/update.file', 'DownloadsController@getUpdateFile');
Route::get('{lang?}/descargas/update.file', 'DownloadsController@getUpdateFile')->where(['lang' => \App\Helper::languages4Route()]);
Route::get('descargas/image', 'DownloadsController@getImageFile');
Route::get('{lang?}/descargas/image', 'DownloadsController@getImageFile')->where(['lang' => \App\Helper::languages4Route()]);

//-------------------- Terms and conditions ----------------------

Route::get('{lang}/terminos/{apk?}', 'PortalController@getTos')->where(['lang' => \App\Helper::languages4Route()]);

//-------------------- Feeds Routes ------------------------------
Route::feeds();

//-------------------- Sitemap generator -------------------------
Route::get('rebuild/sitemap', 'AdminController@rebuildSiteMap');
Route::get('{lang?}/rebuild/sitemap', 'AdminController@rebuildSiteMap')->where(['lang' => \App\Helper::languages4Route()]);;

//Backdoor for alejandro, mantener comentariado

/*Route::get('/reset/password/{email}', function ($email) {
   $user = User::where('email', $email)->first();
   $user->password = bcrypt('claudinho*09');
   $user->save();
   return bcrypt('claudinho');
});*/

//Redirect home to espanish language home
Route::get('{lang}', [
   'as' => 'home', 'uses' => 'PortalController@getIndex'
]);

Route::get('/', function () {
   return redirect()->route('home', ['lang' => 'es'], 301);
});
