<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    public static $TABLENAME = 'members';
    public static $COL_ID = 'id';
    public static $COL_Firstname = 'firstname';
    public static $COL_Lastname = 'lastname';
    public static $COL_Phonenumber = 'phonenumber';
    
    public function account(){
        return $this->hasMany('Modules\Accounting\Account', Account::$COL_MemberID);
    }
}
