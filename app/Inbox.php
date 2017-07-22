<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    public $timestamps = false;
    //Table name
    protected $table = 'inbox';
    public static $COL_Processed = 'Processed';
    public static $COL_UpdatedInDB  = 'UpdatedInDB';
    public static $COL_ReceivingDateTime = 'ReceivingDateTime';
    public static $COL_Text = 'Text';
    public static $COL_SenderNumber  = 'SenderNumber';
    public static $COL_Coding = 'Coding';
    public static $COL_UDH = 'UDH';
    public static $COL_SMSCNumber = 'SMSCNumber';
    public static $COL_Class = 'Class';
    public static $COL_TextDecoded = 'TextDecoded';
    public static $COL_ID = 'ID';
    public static $COL_RecipientID = 'RecipientID';
}
