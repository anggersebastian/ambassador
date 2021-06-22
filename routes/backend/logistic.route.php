<?php

Route::group(['prefix' => 'logistic', 'as' => 'logistic.', 'namespace' => 'Logistic'], function () {
    Route::get('/', 'LogisticController@indexBatch');
    Route::get('/detail-batch/{id?}', 'LogisticController@detailBatch');
    Route::get('/form-batch/{id?}', 'LogisticController@formBatch');
    Route::post('/save-batch/{id?}', 'LogisticController@saveBatch');
    Route::get('/delete-batch/{id?}', 'LogisticController@deleteBatch');

    //

    Route::get('/reconciliation-form-ninja-csv', 'LogisticController@reconciliationFormNinjaCsv');
    Route::post('/show-reconciliation-csv-ninja', 'LogisticController@displayReconciliationFormCsvNinja');
    Route::post('/save-reconciliation-csv-ninja', 'LogisticController@saveReconciliationFormCsvNinja');

    //
    Route::get('/form-bulk-receipt', 'LogisticController@formBulkByReceipt');
    Route::post('/show-form-bulk', 'LogisticController@displayBulkReceipt');

    Route::get('/form-csv', 'LogisticController@formOrderCsv');
    Route::post('/show-csv', 'LogisticController@displayFormCsv');
    Route::post('/save-order-csv/{batch_id?}', 'LogisticController@saveOrder');

    Route::get('/orders', 'LogisticController@indexOrders');
    Route::get('/order-form/{id?}', 'LogisticController@orderForm');
    Route::get('/order-detail/{id?}', 'LogisticController@orderDetail');
    Route::post('/order-save/{id?}', 'LogisticController@orderSave');
    Route::get('/order-delete/{id?}', 'LogisticController@deleteOrder');

    //
    Route::get('/order-export-csv/{id?}', 'LogisticController@orderExportCsv');
    Route::get('/order-export-csv-order/{id?}', 'LogisticController@orderExportCsvOrderOnline');

    Route::get('/form-ninja-csv', 'LogisticController@formNinjaCsv');
    Route::post('/show-csv-ninja', 'LogisticController@displayFormCsvNinja');
    Route::post('/save-order-ninja-csv/', 'LogisticController@saveOrderNinja');

    Route::post('/update-receipt', 'LogisticController@updateReceiptOrder');


    Route::get('/cs', 'LogisticController@indexCs');
    
    // json
    Route::get('batch/json', 'LogisticController@batchJson');

    // Jurnal
    // Route::get('jurnal/custom-id-fill', 'LogisticController@jurnalCustomId'); // not used, for tested only
    Route::get('jurnal/checking-product/{batch_id?}', 'LogisticController@jurnalCheckProduct');
    Route::post('jurnal/create-product', 'LogisticController@jurnalCreateProduct');
    Route::get('jurnal/push-list-batch/{batch_id?}', 'LogisticController@jurnalListBatch');

    // Excel
    Route::get('export-excel', 'LogisticController@exportToExcel');
});