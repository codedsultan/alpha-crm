<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::get('/hello', function () {
//    return response()->json(['message' => 'Hello World!'], 200);
//});



Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::middleware([
        'auth:sanctum',
        'validateRole:Admin,Employee'
        ])->group(
            function () {
                Route::prefix('services')->group( function () {
                    Route::get('/', [\App\Http\Controllers\ServicesApiController::class, 'index'])->name('api-services.index');
                    Route::get('/{id}', [\App\Http\Controllers\ServicesApiController::class, 'show'])->name('api-services.show');
                    Route::post('/', [\App\Http\Controllers\ServicesApiController::class, 'store'])->name('api-services.store');
                    Route::put('/{id}', [\App\Http\Controllers\ServicesApiController::class, 'update'])->name('api-services.update');
                    Route::delete('/{id}', [\App\Http\Controllers\ServicesApiController::class, 'destroy'])->name('api-services.destroy');
                });
            }
        );
