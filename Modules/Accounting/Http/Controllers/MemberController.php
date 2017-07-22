<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Member;
use Modules\Accounting\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller {

    public function getMembersAll() {
        $members = self::getMemberAll();
        return response()->json($members);
    }
    
    public static function getMemberAll(){
        $members = Member::select(Member::$COL_ID, Member::$COL_Firstname, Member::$COL_Lastname, Member::$COL_Phonenumber)
                ->orderBy(Member::$COL_Firstname, 'asc')
                ->get();
        return $members;
    }

    public function memberAdd(Request $request) {
        $result = false;
        $this->validate($request, [
            Member::$COL_Firstname => 'required',
            Member::$COL_Lastname => 'required',
            Member::$COL_Phonenumber => 'required|unique:members'
        ]);

        $member = new Member();
        $member->firstname = $request[Member::$COL_Firstname];
        $member->lastname = $request[Member::$COL_Lastname];
        $member->phonenumber = $request[Member::$COL_Phonenumber];

        if ($member->save()) {
            $result = true;
            //Add new account
            if (false) {
               $result =  $this->createMemberAccount($member);
            }
        }

        return response()->json(['response' => $result]);
    }

    public function memberUpdate(Request $request) {
        $result = false;
        $this->validate($request, [
            Member::$COL_ID => 'required',
            Member::$COL_Firstname => 'required',
            Member::$COL_Lastname => 'required',
            Member::$COL_Phonenumber => 'required'
        ]);

        $member = Member::find($request[Member::$COL_ID]);

        $member->firstname = $request[Member::$COL_Firstname];
        $member->lastname = $request[Member::$COL_Lastname];
        $member->phonenumber = $request[Member::$COL_Phonenumber];

        if ($member->update()) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function memberDelete(Request $request) {
        $result = false;
        $this->validate($request, [
            Member::$COL_ID => 'required'
        ]);

        $submitedId = $request[Member::$COL_ID];

        $member = Member::find($submitedId);

        if ($member->delete()) {
            $result = true;
        }
        return response()->json(['response' => $result]);
    }

    private function createMemberAccount($member) {
        $account = new Account();
        $account[Account::$COL_MemberID] = $member[Member::$COL_ID];
        $account[Account::$COL_Name] = $member[Member::$COL_Firstname] . '_' . $member[Member::$COL_Lastname];
        return AccountController::addAccount($account);
    }

}
