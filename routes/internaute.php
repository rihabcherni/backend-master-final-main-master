<?php
use App\Http\Controllers\Internaute\InternauteDashboardController;
use App\Http\Controllers\Internaute\ContactsController;
use Illuminate\Support\Facades\Route;

    Route::get('contact-us-excel', [ContactsController::class, 'exportInfoContactExcel']);
    Route::get('contact-us-csv', [ContactsController::class, 'exportInfoContactCSV']);
    Route::get('contact-us-pdf/{id}', [ContactsController::class, 'pdfContact']);
    Route::get('contact-us-all-pdf', [ContactsController::class, 'pdfAllContact']);
    Route::group(['prefix' => 'internaute'], function () {
    Route::get('/dashborad' , [InternauteDashboardController::class , 'dashbordInternaute']);
    Route::apiResource('/contact-us', ContactsController::class);

    Route::get('/quantite-dechete-totale-collecte',[InternauteDashboardController::class,'quantiteTotaleDechetCollecte']);
});

