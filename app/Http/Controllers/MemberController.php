<?php

namespace App\Http\Controllers;

use App\Member;
use Excel;
use Illuminate\Http\Request;

class MemberController extends Controller {

    public function postAddMember(Request $request) {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'phonenumber' => 'required|unique:members'
        ]);

        $message = 'fail';
        $firstname = $request['firstname'];
        $lastname = $request['lastname'];
        $phonenumber = $request['phonenumber'];

        $member = new Member();
        $member->firstname = $firstname;
        $member->lastname = $lastname;
        $member->phonenumber = $phonenumber;

        if ($member->save()) {
            $message = 'success';
        }

        return $message;
    }

    public function postSelectMembersAll() {
        $members = Member::orderBy('firstname')->get();
        return json_encode($members);
    }

    public function postLoadMember(Request $request) {

        $this->validate($request, [
            'id' => 'required'
        ]);

        $submitedId = $request['id'];

        $member = Member::find($submitedId);

        return response()->json($member);
    }

    public function postImportMembers(Request $request) {
        $members = $request['membersData'];
        $returnarray = array();
        $index = 1;
        $membersObj = json_decode($members, true);
        $status = 'success';

        foreach ($membersObj as $value) {
            $matchPhonenumber = array('phonenumber' => $value['phonenumber']);
            $member = Member::updateOrCreate($matchPhonenumber, ['firstname' => $value['firstname'],
                        'lastname' => $value['lastname'],
                        'phonenumber' => $value['phonenumber']]);
            if ($member->exists) {
                $message = 'Row' . $index . ' updated';
            } else {
                $message = 'Row' . $index . ' fails';
            }

            array_push($returnarray, ['message' => $message]);
            $index++;
        }

        return response()->json(['status' => $status, 'data' => $returnarray]); //redirect()->route('members-import')->with(['add_member_status' => $message]);
    }

    public function postUpdateMember(Request $request) {

        $this->validate($request, [
            'id' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'phonenumber' => 'required'
        ]);

        $member = Member::find($request['id']);

        $member->firstname = $request['firstname'];
        $member->lastname = $request['lastname'];
        $member->phonenumber = $request['phonenumber'];

        if ($member->update()) {
            $message = 'success';
            $member = Member::find($request['id']);
        } else {
            $message = 'fail';
        }

        return response()->json($member);
    }

    public function postRemoveMember(Request $request) {

        $this->validate($request, [
            'id' => 'required'
        ]);

        $submitedId = $request['id'];

        $member = Member::find($submitedId);

        return $member->delete();
    }

    public function postUploadMembers(Request $request) {

        try {
            if ($request->hasFile('upload_member_file')) {
                $path = $request->file('upload_member_file')->getRealPath();

                $data = Excel::load($path, function($reader) {
                            
                        })->get();

                if (!empty($data) && $data->count()) {

//                foreach ($data->toArray() as $key => $value) {
//                    if (!empty($value)) {
//                        foreach ($value as $v) {
//                            $membersToInsert[] = ['firstname' => $v['firstname'], 
//                                'lastname' => $v['lastname'],
//                                'phonenumber' => $v['phonenumber']];
//                        }
//                    }
//                }

                    $membersToInsert = json_encode($data->toArray());
                    if (!empty($membersToInsert)) {
                        return back()->with('success', $membersToInsert);
                    }
                }
            }
        } catch (Exception $ex) {
            return back()->with('error', 'Please Check your file, Something is wrong there.');
        }
    }

}
