<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public static $TABLENAME = 'groups';
    public static $COL_ID = 'group_id';
    public static $COL_NAME = 'group_name';
    public static $COL_SHARE_UNIT_PRICE = 'groupsh_price';
    public static $COL_SHARE_MAX_OFFER = 'groupsh_max';
    public static $COL_SHARE_LOOP_DURATION = 'groupsh_duration';
    public static $COL_LOAN_RATE = 'groupln_rate';
    
    protected $primaryKey= 'group_id';
}
