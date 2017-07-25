<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounting\Http\Controllers\MemberController;
use Modules\Accounting\Http\Controllers\AccountController;
use Modules\Accounting\Http\Controllers\ShareOfferController;
use Modules\Accounting\Account;

class AccountingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('accounting::members');
    }
    
    public function displayMembers(){
            return view('accounting::members');
    }
    
    public function displayAccounts(){
        //Load all members
        $members = MemberController::getMemberAll();
            return view('accounting::accounts', ['members'=> $members]);
    }
    
    public function displayShares(){
        //Load all members
        $accounts = AccountController::getAccountByColumns(array(Account::$COL_ID, Account::$COL_Name));
            return view('accounting::shares', ['accounts'=> $accounts]);
    }
    
    public function displayLoans(){
        //Load all members
        $accounts = AccountController::getAccountByColumns(array(Account::$COL_ID, Account::$COL_Name));
        return view('accounting::loans', ['accounts'=> $accounts]);
    }
    
    public function displayFines(){
        //Load all members
        $accounts = AccountController::getAccountByColumns(array(Account::$COL_ID, Account::$COL_Name));
            return view('accounting::fines', ['accounts'=> $accounts]);
    }
    public function displayShareOffers(){
        //Load all members
        $accounts = ShareOfferController::getShareAccount();
            return view('accounting::shareoffers', ['account_share'=> $accounts]);
    }
    public function displayShareBids(){
        //Load all members
        $accounts = ShareOfferController::getShareAccount();
            return view('accounting::sharebids', ['account_share'=> $accounts]);
    }
    public function diplayLoanPayments(){
        //Load all members
        $accounts = LoanPaymentController::getLoanAccount();
            return view('accounting::loanspayments', ['loan_account'=> $accounts]);
    }
    public function displayFinePayments(){
        //Load all members
        $accounts = AccountController::getAccountAll();
            return view('accounting::finespayments', ['accounts'=> $accounts]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('accounting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('accounting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('accounting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
