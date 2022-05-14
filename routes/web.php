<?php

/** Página inicial */
Route::get('/', 'Web\\WebController@filter')->name('web.home');
// Route::get('/', 'Web\\WebController@home')->name('web.home');

/** Página Destaque */
Route::get('/destaque', 'Web\\WebController@spotlight')->name('web.spotlight');

/** Página de ONGs */
Route::get('/ongs', 'Web\\WebController@companies')->name('web.companies');

/** Página de compra */
Route::get('/quero-adotar', 'Web\\WebController@buy')->name('web.buy');

/** Página de compra específica de um veículo  */
Route::get('/quero-adotar/{slug}', 'Web\\WebController@buyAutomotive')->name('web.buyAutomotive');

/** Página de filtro */
Route::match(['post', 'get'], '/filtro', 'Web\\WebController@filter')->name('web.filter');

/** Página de contato */
Route::get('/contato', 'Web\\WebController@contact')->name('web.contact');
Route::post('/contato/sendEmail', 'Web\\WebController@sendEmail')->name('web.sendEmail');
Route::get('/contato/sucesso', 'Web\\WebController@sendEmailSuccess')->name('web.sendEmailSuccess');

/** Página de Política de Privacidade */
Route::get('/politica-de-privacidade', 'Web\\WebController@policy')->name('web.policy');

/** Filtro */
Route::post('main-filter/search', 'Web\\FilterController@search')->name('component.main-filter.search');
Route::post('main-filter/city', 'Web\\FilterController@city')->name('component.main-filter.city');
Route::post('main-filter/category', 'Web\\FilterController@category')->name('component.main-filter.category');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    /** Formulário de Login */
    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login.do');

    /** Formulário de Criação de Conta */
    Route::get('new-account', 'AuthController@newAccount')->name('account');
    Route::post('create-account', 'AuthController@createAccount')->name('account.do');

    /** Recuperação Conta */
    Route::get('forgotten-account', 'AuthController@forgotten')->name('forgotten');
    Route::post('forgotten-account', 'AuthController@forgottenAccount')->name('forgotten.do');
    Route::get('reset-account/{token?}', 'AuthController@resetAccount')->name('reset');
    Route::post('reset-account', 'AuthController@resetPassword')->name('reset.do');

    /** Rotas Protegidas */
    Route::group(['middleware' => ['auth']], function () {

        /** Dashboard Home */
        Route::get('home', 'AuthController@home')->name('home');

        /** Usuários */
        Route::get('users/team', 'UserController@team')->name('users.team');
        Route::resource('users', 'UserController');

        /** Permissões */
        Route::resource('permission', 'ACL\\PermissionController');

        /** Perfis */
        Route::get('role/{role}/permissions', 'ACL\\RoleController@permissions')->name('role.permissions');
        Route::put('role/{role}/permission/sync', 'ACL\\RoleController@permissionsSync')->name('role.permissionsSync');
        Route::resource('role', 'ACL\\RoleController');

        /** Empresas */
        Route::resource('companies', 'CompanyController');

        /** Automóveis */
        Route::post('animals/image-set-cover', 'AutomotiveController@imageSetCover')->name('animals.imageSetCover');
        Route::delete('animals/image-remove', 'AutomotiveController@imageRemove')->name('animals.imageRemove');
        Route::post('animals/reactive/{automotive}', 'AutomotiveController@reactive')->name('animals.reactive');
        Route::resource('animals', 'AutomotiveController');

        /** Contratos */
        Route::post('contracts/get-data-owner', 'ContractController@getDataOwner')->name('contracts.getDataOwner');
        Route::post('contracts/get-data-acquirer', 'ContractController@getDataAcquirer')->name('contracts.getDataAcquirer');
        Route::post('contracts/get-data-property', 'ContractController@getDataProperty')->name('contracts.getDataProperty');
        Route::resource('contracts', 'ContractController');

        /** Créditos */
        // Route::get('banner', 'PaymentController@banner')->name('banner');
        Route::get('payment', 'PaymentController@payment')->name('payment');
        Route::get('contact', 'PaymentController@contact')->name('contact');
        Route::post('sendContact', 'PaymentController@sendContact')->name('sendContact');

        /** Termos */
        Route::resource('term', 'TermController');

        /** Banner */
        Route::resource('banner', 'BannerController');

        /**Configurações */
        Route::resource('config', 'ConfigController');
    });

    /** Rota de logout */
    Route::get('logout', 'AuthController@logout')->name('logout');
});


/** Página de uma ONG específica  */
Route::get('/{slug}', 'Web\\WebController@filterCompany')->name('web.filterCompany');
