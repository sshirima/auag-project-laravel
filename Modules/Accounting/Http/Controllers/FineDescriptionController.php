<?php
namespace Modules\Accounting\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Accounting\FineDescription;

class FineDescriptionController extends Controller{
    public static function getFineDescAll(){
       return $descriptions = \Illuminate\Support\Facades\DB::table(FineDescription::$TABLENAME)
            ->select(FineDescription::$COL_ID, 
                    FineDescription::$COL_DESCRIPTION, FineDescription::$COL_AMOUNT)->get();
    }
}

