<?php
namespace App\Http\Controllers;
use App\SMSProcessor;

class SMSProcessorController extends Controller{

    var $KEY_SEREVER_ISRUNNING = 'serverIsRunning';
    
    public function processStatus(){
        
        return response()->json(['status'=>session($this->KEY_SEREVER_ISRUNNING, false)]);
    }
    
    public function processStart(){
        session([$this->KEY_SEREVER_ISRUNNING=>true]);
        return $this->processStatus();
    }
    public function processStop(){
        session([$this->KEY_SEREVER_ISRUNNING=>false]);
        return $this->processStatus();
    }
    public function processRun(){
        $SMSProcessor = new SMSProcessor();
        $response = $SMSProcessor->run();
        return response()->json(['status'=>$response]);
    }
    
    
}

