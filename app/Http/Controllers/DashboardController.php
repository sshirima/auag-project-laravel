<?php

namespace App\Http\Controllers;

use App\Phone;
use App\SMSService;
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
        $response = SMSService::getStatus('tasklist /FI "IMAGENAME eq gammu-smsd.exe"');
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
                SMSService::smsdStart('C:\xampp\htdocs\laravel\Gammu\Gammu_1.33.0\bin\gammu-smsd.exe -c C:\xampp\htdocs\laravel\Gammu\Gammu_1.33.0\bin\smsdrc');
            }
        }
        return response()->json(['status' => 'started', 'pid' => $response]);
    }

    public function smsdStop() {
        //taskkill /IM gammu-smsd.exe /F
        $response = SMSService::smsdStop('taskkill /IM gammu-smsd.exe /F');
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
}
