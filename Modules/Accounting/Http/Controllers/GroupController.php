<?php
namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Accounting\Group;

class GroupController extends Controller{
    
    public static function getGroupInfo(){
        return \Modules\Accounting\Group::all()->first();
    }
    
    public function updateGroup(Request $request){
        $status = 'FAIL';
        $this->validate($request, [
            Group::$COL_ID =>'required',
            Group::$COL_LOAN_RATE =>'required',
            Group::$COL_NAME =>'required',
            Group::$COL_SHARE_LOOP_DURATION =>'required',
            Group::$COL_SHARE_MAX_OFFER =>'required',
            Group::$COL_SHARE_UNIT_PRICE =>'required'
        ]);
        
        $group = Group::find($request[Group::$COL_ID]);
        $gp = self::updateParameters($request, $group);
        if ($gp->update()){
            $status = 'OK';
        }
        return response()->json(['status' => $status, 'group'=>$gp]);
    }
    
    private static function updateParameters(Request $request, Group $group){
        $group[Group::$COL_NAME] = $request[Group::$COL_NAME];
        $group[Group::$COL_LOAN_RATE] = $request[Group::$COL_LOAN_RATE];
        $group[Group::$COL_SHARE_LOOP_DURATION] = $request[Group::$COL_SHARE_LOOP_DURATION];
        $group[Group::$COL_SHARE_MAX_OFFER] = $request[Group::$COL_SHARE_MAX_OFFER];
        $group[Group::$COL_SHARE_UNIT_PRICE] = $request[Group::$COL_SHARE_UNIT_PRICE];
        return $group;
    }
}

