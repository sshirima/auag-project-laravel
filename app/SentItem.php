<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SentItem extends Model
{
    public $timestamps = false;
    //Table name
    protected $table = 'sentitems';
     public static $COL_UpdatedInDB = 'UpdatedInDB';
     public static $COL_InsertIntoDB = 'InsertIntoDB';
     public static $COL_SendingDateTime = 'SendingDateTime';
     public static $COL_DeliveryDateTime = 'DeliveryDateTime';
     public static $COL_Text = 'Text';
     public static $COL_DestinationNumber = 'DestinationNumber';
     public static $COL_Coding = 'Coding';
     public static $COL_UDH = 'UDH';
     public static $COL_SMSCNumber = 'SMSCNumber';
     public static $COL_TextDecoded = 'TextDecoded';
     public static $COL_ID = 'ID';
     public static $COL_SenderID = 'SenderID';
     public static $COL_SequencePosition = 'SequencePosition';
     public static $COL_Status = 'Status';
     public static $COL_StatusError = 'StatusError';
     public static $COL_TPMR = 'TPMR';
     public static $COL_RelativeValidity = 'RelativeValidity';
     public static $COL_CreatorID = 'CreatorID';
}
