<?php

namespace App\Http\Controllers;

use App\Inbox;
class InboxController extends Controller {
    
    public function getAllMessages(){
        return Inbox::select(Inbox::$COL_ReceivingDateTime,
        Inbox::$COL_SenderNumber,
        Inbox::$COL_TextDecoded,
        Inbox::$COL_Processed)
                ->orderBy(Inbox::$COL_ReceivingDateTime, 'desc')
                ->get();
    }

}
