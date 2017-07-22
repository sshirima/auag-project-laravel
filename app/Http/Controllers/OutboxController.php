<?php

namespace App\Http\Controllers;

use App\Outbox;
class OutboxController extends Controller {
    
    public function getAllMessages(){
        return Outbox::select(Outbox::$COL_SendingDateTime,
        Outbox::$COL_DestinationNumber,
        Outbox::$COL_TextDecoded)
                ->orderBy(Outbox::$COL_InsertIntoDB, 'desc')
                ->get();
    }

}
