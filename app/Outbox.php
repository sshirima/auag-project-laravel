<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    public $timestamps = false;
    //Table name
    protected $table = 'outbox';
    public static $COL_UpdatedInDB = 'UpdatedInDB';
    public static $COL_InsertIntoDB = 'InsertIntoDB';
    public static $COL_SendingDateTime = 'SendingDateTime';
    public static $COL_SendBefore = 'SendBefore';
    public static $COL_SendAfter = 'SendAfter';
    public static $COL_Text = 'Text';
    public static $COL_DestinationNumber = 'DestinationNumber';
    public static $COL_Coding = 'Coding';
    public static $COL_UDH = 'UDH';
    public static $COL_Class = 'Class';
    public static $COL_TextDecoded = 'TextDecoded';
    public static $COL_ID = 'ID';
    public static $COL_MultiPart = 'MultiPart';
    public static $COL_RelativeValidity = 'RelativeValidity';
    public static $COL_SenderID = 'SenderID';
    public static $COL_SendingTimeOut = 'SendingTimeOut';
    public static $COL_DeliveryReport = 'DeliveryReport';
    public static $COL_CreatorID = 'CreatorID';
}
