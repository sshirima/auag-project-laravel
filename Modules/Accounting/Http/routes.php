<?php

Route::group(['middleware' => 'web', 'prefix' => 'accounting', 'namespace' => 'Modules\Accounting\Http\Controllers'], function() {

    Route::get('/', [
        'as' => 'accounting',
        'uses' => 'AccountingController@index']);

    Route::get('/members', [
        'as' => 'members',
        'uses' => 'AccountingController@displayMembers']);

    Route::get('/accounts/shares', [
        'as' => 'shares',
        'uses' => 'AccountingController@displayShares']);
    
    Route::get('/accounts/fines', [
        'as' => 'fines',
        'uses' => 'AccountingController@displayFines']);
    
    Route::get('/accounts/loans', [
        'as' => 'loans',
        'uses' => 'AccountingController@displayLoans']);

    Route::get('/transactions', [
        'as' => 'transactions',
        function () {
            return view('accounting::transactions'
            );
        }]);

    Route::get('/accounts', [
        'as' => 'accounts',
        'uses' => 'AccountingController@displayAccounts']);

     Route::get('/transactions/shareoffers', [
        'as' => 'shareoffers',
        'uses' => 'AccountingController@displayShareOffers']);
     
     Route::get('/transactions/sharebids', [
        'as' => 'sharebids',
        'uses' => 'AccountingController@displaySharebids']);
     
     Route::get('/transactions/loanpayments', [
        'as' => 'loanpayments',
        'uses' => 'AccountingController@diplayLoanPayments']);
     
     Route::get('/transactions/finepayments', [
        'as' => 'finepayments',
        'uses' => 'AccountingController@displayFinePayments']);

    /**
     * Members view Routes
     */
    Route::post('/members/getAll', [
        'uses' => 'MemberController@getMembersAll',
        'as' => 'getAllMembers']);

    Route::post('/member/add', [
        'uses' => 'MemberController@memberAdd',
        'as' => 'addMember']);

    Route::post('/member/update', [
        'uses' => 'MemberController@memberUpdate',
        'as' => 'updateMember']);

    Route::post('/member/delete', [
        'uses' => 'MemberController@memberDelete',
        'as' => 'deleteMember']);

    /**
     * Accounts view Routes
     */
    Route::post('/accounts/getAll', [
        'uses' => 'AccountController@getAccountsAll',
        'as' => 'getAllAccounts']);

    Route::post('/account/add', [
        'uses' => 'AccountController@accountAdd',
        'as' => 'addAccount']);

    Route::post('/account/update', [
        'uses' => 'AccountController@accountUpdate',
        'as' => 'updateAccount']);

    Route::post('/account/delete', [
        'uses' => 'AccountController@accountDelete',
        'as' => 'deleteAccount']);
    
    /**
     * Shares view Routes
     */
    Route::post('/shares/getAll', [
        'uses' => 'ShareController@getSharesAll',
        'as' => 'getAllShares']);

    Route::post('/shares/add', [
        'uses' => 'ShareController@shareAdd',
        'as' => 'addShare']);

    Route::post('/shares/update', [
        'uses' => 'ShareController@shareUpdate',
        'as' => 'updateShare']);

    Route::post('/shares/delete', [
        'uses' => 'ShareController@shareDelete',
        'as' => 'deleteShare']);
    
    /**
     * ShareOffers view Routes
     */
    Route::post('/shareoffer/getAll', [
        'uses' => 'ShareOfferController@getShareOffersAll',
        'as' => 'getAllShareOffers']);

    Route::post('/shareoffer/add', [
        'uses' => 'ShareOfferController@shareOfferAdd',
        'as' => 'addShareOffer']);

    Route::post('/shareoffer/update', [
        'uses' => 'ShareOfferController@shareOfferUpdate',
        'as' => 'updateShareOffer']);

    Route::post('/shareoffer/delete', [
        'uses' => 'ShareOfferController@shareOfferDelete',
        'as' => 'deleteShareOffer']);
    
    /**
     * ShareBids view Routes
     */
    Route::post('/sharebid/getAll', [
        'uses' => 'ShareBidController@getShareBidsAll',
        'as' => 'getAllShareBids']);

    Route::post('/sharebid/add', [
        'uses' => 'ShareBidController@shareBidAdd',
        'as' => 'addShareBid']);

    Route::post('/sharebid/update', [
        'uses' => 'ShareBidController@shareBidUpdate',
        'as' => 'updateShareBid']);

    Route::post('/sharebid/delete', [
        'uses' => 'ShareBidController@shareBidDelete',
        'as' => 'deleteShareBid']);
    
    /**
     * Loans view Routes
     */
    Route::post('/loan/getAll', [
        'uses' => 'LoanController@getLoansAll',
        'as' => 'getAllLoans']);

    Route::post('/loan/add', [
        'uses' => 'LoanController@loanAdd',
        'as' => 'addLoan']);

    Route::post('/loan/update', [
        'uses' => 'LoanController@loanUpdate',
        'as' => 'updateLoan']);

    Route::post('/loan/delete', [
        'uses' => 'LoanController@loanDelete',
        'as' => 'deleteLoan']);
    
    /**
     * Fines view Routes
     */
    Route::post('/fine/getAll', [
        'uses' => 'FineController@getFinesAll',
        'as' => 'getAllFines']);

    Route::post('/fine/add', [
        'uses' => 'FineController@FineAdd',
        'as' => 'addFine']);

    Route::post('/fine/update', [
        'uses' => 'FineController@FineUpdate',
        'as' => 'updateFine']);

    Route::post('/fine/delete', [
        'uses' => 'FineController@FineDelete',
        'as' => 'deleteFine']);
    
    /**
     * LoanPayments view Routes
     */
    Route::post('/loanpayment/getAll', [
        'uses' => 'LoanPaymentController@getLoanPaymentsAll',
        'as' => 'getAllLoanPayments']);

    Route::post('/loanpayment/add', [
        'uses' => 'LoanPaymentController@addLoanPayment',
        'as' => 'addLoanPayment']);

    Route::post('/loanpayment/update', [
        'uses' => 'LoanPaymentController@updateLoanPayment',
        'as' => 'updateLoanPayment']);

    Route::post('/loanpayment/delete', [
        'uses' => 'LoanPaymentController@deleteLoanPayment',
        'as' => 'deleteLoanPayment']);
    
    /**
     * FinePayments view Routes
     */
    Route::post('/finepayment/getAll', [
        'uses' => 'FinePaymentController@getFinePaymentsAll',
        'as' => 'getAllFinePayments']);

    Route::post('/finepayment/add', [
        'uses' => 'FinePaymentController@finePaymentAdd',
        'as' => 'addFinePayment']);

    Route::post('/finepayment/update', [
        'uses' => 'FinePaymentController@finePaymentUpdate',
        'as' => 'updateFinePayment']);

    Route::post('/finepayment/delete', [
        'uses' => 'FinePaymentController@finePaymentDelete',
        'as' => 'deleteFinePayment']);
    
});
