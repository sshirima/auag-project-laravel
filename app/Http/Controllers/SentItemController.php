<?php

namespace App\Http\Controllers;

use App\SentItem;

class SentItemController extends Controller {

    public function getAllMessages(){
        return SentItem::select(SentItem::$COL_SendingDateTime,
                SentItem::$COL_DestinationNumber,
                SentItem::$COL_TextDecoded)->orderBy(SentItem::$COL_SendingDateTime,'desc')
                ->get();
    }
}
