<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::prefix('dashboard')->group(function () {

        // middleware to give access only for admin
        Route::middleware([
            'validateRole:Admin'
        ])->group(function () {

            Route::prefix('manage')->group( function () {
                Route::resource('users', App\Http\Controllers\UserController::class)->name('index', 'manageusers');


                Route::get('locations', function () {
                    return view('dashboard.manage-locations.index');
                })->name('managelocations');
            });



        });

        // middlleware to give access only for admin and employee
        Route::middleware([
            'validateRole:Admin,Employee'
        ])->group(function () {

            Route::prefix('manage')->group( function () {
                Route::get('services', function () {
                    return view('dashboard.manage-services.index');
                })->name('manageservices');

                Route::get('deals', function () {
                    return view('dashboard.manage-deals.index');
                })->name('managedeals');

                Route::get('categories', function () {
                    return view('dashboard.manage-categories.index');
                })->name('managecategories' );

                Route::get('categories/create', function () {
                    return view('dashboard.manage-categories.index');
                })->name('managecategories.create');

                Route::get('appointments', function () {
                    return view('dashboard.manage-appointments.index');
                })->name('manageappointments');
            } );




        });

        Route::middleware([
            'validateRole:Customer'
        ])->group(function () {




        });
    });
});
