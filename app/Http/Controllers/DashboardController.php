<?php

namespace App\Http\Controllers;

use App\Phone;
use App\SMSService;
use App\SMSProcessor;
use Illuminate\Http\Request;

class DashBoardController extends Controller {

    /**
     * 
     * @return type JSON array of list of phones
     */
    public function selectPhonesAll() {
        return Phone::all();
    }

    public function getSMSServiceStatus() {
        $response = SMSService::getSMSServiceStatus();
        if (preg_match("/No tasks/", $response)) {
            $message = ['state' => 'stopped', 'content' => $response];
        } else if (preg_match("/PID/", $response)) {
            $pid = substr($response, 188, 4);
            $message = ['state' => 'running', 'content' => $response, 'pid' => $pid];
        } else {
            $message = ['state' => 'failed', 'content' => $response];
        }
        return $message;
    }

    public function getDashboardMonitoring() {
        return view('dashboard-monitoring', ['phones' => [$this->selectPhonesAll()], 'smsd' => $this->getSMSServiceStatus()]);
    }

    public function getDashboardSettings() {
        return view('dashboard-device-settings', ['configs' => json_decode($this->getSmsdConfig())]);
    }

    public function smsdStart() {
        $isRunning = FALSE;
        $response = '';
        while (!$isRunning) {
            //Check runnning status
            $status = $this->getSMSServiceStatus();
            if ($status['state'] == 'running') {
                $isRunning = TRUE;
                $response = $status['pid'];
            } else {
                SMSService::smsdStart();
            }
        }
        return response()->json(['status' => 'started', 'pid' => $response]);
    }

    public function smsdStop() {
        //taskkill /IM gammu-smsd.exe /F
        $response = SMSService::smsdStop();
        return response()->json(['status' => 'stopped', 'response' => $response]);
    }

    public function smsdSaveConfig(Request $request) {
        $configs = $request['configs'];
        $smsService = new SMSService();
        if ($smsService->saveSmsdConfigs($configs)){
            $response = ['status' => 'OK'];
        } else {
             $response = ['status' => 'FAIL'];
        }
        return response()->json(['response' => $response]);
    }

    public function getSmsdConfig() {
        $smsService = new SMSService();
        $response = $smsService->getConfigFile();

        return $response;
    }
    
    public function gammuSaveConfig(Request $request) {
        $configs = $request['configs'];
        $smsService = new SMSService();
        if ($smsService->saveGammuConfigs($configs)){
            $response = ['status' => 'OK'];
        } else {
             $response = ['status' => 'FAIL'];
        }
        return response()->json(['response' => $response]);
    }
    
    public function postModemIdentify(){
        $smsService = new SMSService();
        $status = $this->getSMSServiceStatus();
        $wasRunning = FALSE;
        
        if ($status['state'] == 'running') {
            $this->smsdStop();
            $wasRunning = TRUE;
        }
        
        $response = $smsService->identifyModem();
        
        if ($wasRunning){
            $this->smsdStart();
        }
        
        return response()->json(['response' => $response]);
    }
    
    public function startServer(Request $request){
        $KEY_SEREVER_ISRUNNING = 'serverIsRunning';
        $status = session($KEY_SEREVER_ISRUNNING, false);
        $requestStatus = $request['status'];
        if ($status){
           if ($requestStatus ==='true'){
                //Stop the server
                session([$KEY_SEREVER_ISRUNNING=>false]);
            } else {
                //Process SMS
                $smsprocessor = new SMSProcessor();
                $smsprocessor->run();
            }
        }else {
            if ($requestStatus ==='true'){
                //Start the server
                session([$KEY_SEREVER_ISRUNNING=>true]);
            }
        }
        
        return response()->json(['status'=> session($KEY_SEREVER_ISRUNNING, false)]);
    }
}
