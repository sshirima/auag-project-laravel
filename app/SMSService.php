<?php

namespace App;

use Symfony\Component\Process\Process;
use \SplFileObject;
use Symfony\Component\Process\Exception\RuntimeException;

class SMSService {

    public static $FILEPATH = 'C:\xampp\htdocs\laravel\Gammu\Gammu_1.33.0\bin\smsdrc';
    public static $FILEPATH_TEMP = 'C:\xampp\htdocs\laravel\Gammu\Gammu_1.33.0\bin\smsdrc.temp';
    var $device;
    var $connection;
    var $logfile;
    var $service;
    var $driver;
    var $host;
    var $sql;
    var $username;
    var $password;
    var $database;
    var $checksecurity;
    var $inboxpath;
    var $outboxpath;
    var $sentsmspath;
    var $errorsmspath;
    var $inboxformat;
    var $transmitformat;
    var $outboxformat;

    public function __construct() {
        
    }

    public static function runCommand($command) {
        $process = new Process($command);
        $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new RuntimeException($process->getErrorOutput());
        }
        return $process->getOutput();
    }

    public static function getSMSServiceStatus() {
        $command = 'tasklist /FI "IMAGENAME eq gammu-smsd.exe"';
        return SMSService::runCommand($command);
    }

    public static function smsdStart() {
        $command = 'C:\xampp\htdocs\laravel\Gammu\Gammu_1.33.0\bin\gammu-smsd.exe -c C:\xampp\htdocs\laravel\Gammu\Gammu_1.33.0\bin\smsdrc';
        if (substr(php_uname(), 0, 7) == "Windows") {
            pclose(popen("start /B " . $command, "r"));
        } else {
            exec($command . " > /dev/null &");
        }
    }

    public static function smsdStop() {
        $command = 'taskkill /IM gammu-smsd.exe /F';
        $process = new Process($command);
        $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new RuntimeException($process->getErrorOutput());
        }
        return $process->getOutput();
    }

    public function getConfigFile() {
        //Load config file

        $filename = new SplFileObject(SMSService::$FILEPATH);
        $this->readConfigFile($filename);
        return json_encode($this);
    }

    private function readConfigFile($filename) {
        while (!$filename->eof()) {
            $linetext = $filename->fgets();
            if (StringManipulator::str_starts_with($linetext, 'logfile')) {
                $this->logfile = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'device')) {
                $this->device = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'connection')) {
                $this->connection = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'Service')) {
                $this->service = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'Driver')) {
                $this->driver = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'Host')) {
                $this->host = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'SQL')) {
                $this->sql = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'User')) {
                $this->username = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'Password')) {
                $this->password = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'Database')) {
                $this->database = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'CheckSecurity')) {
                $this->checksecurity = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'inboxpath')) {
                $this->inboxpath = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'outboxpath')) {
                $this->outboxpath = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'sentsmspath')) {
                $this->sentsmspath = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'errorsmspath')) {
                $this->errorsmspath = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'inboxformat')) {
                $this->inboxformat = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'transmitformat')) {
                $this->transmitformat = StringManipulator::after('=', $linetext);
            } else
            if (StringManipulator::str_starts_with($linetext, 'outboxformat')) {
                $this->outboxformat = StringManipulator::after('=', $linetext);
            }
        }
    }

    public function saveSmsdConfigs($configs) {
        $service = $configs['service'];
        $driver = $configs['driver'];
        $host = $configs['host'];
        $sql = $configs['sql'];
        $username = $configs['user'];
        $password = $configs['password'];
        $database = $configs['database'];
        $replaced = false;
        $file_reading = fopen(SMSService::$FILEPATH, 'r');
        $file_writing = fopen(SMSService::$FILEPATH_TEMP, 'w');
        $responce = false;
        while (!feof($file_reading)) {
            $linetext = fgets($file_reading);
            if (StringManipulator::str_starts_with($linetext, 'Service')) {
                $linetext = "Service = " . $service . "\n";
                $replaced = true;
            }
            if (StringManipulator::str_starts_with($linetext, 'Driver')) {
                $linetext = "Driver = " . $driver . "\n";
                $replaced = true;
            }
            if (StringManipulator::str_starts_with($linetext, 'Host')) {
                $linetext = "Host = " . $host . "\n";
                $replaced = true;
            }
            if (StringManipulator::str_starts_with($linetext, 'SQL')) {
                $linetext = "SQL = " . $sql . "\n";
                $replaced = true;
            }
            if (StringManipulator::str_starts_with($linetext, 'User')) {
                $linetext = "User = " . $username . "\n";
                $replaced = true;
            }
            if (StringManipulator::str_starts_with($linetext, 'Password')) {
                $linetext = "Password = " . $password . "\n";
                $replaced = true;
            }
            if (StringManipulator::str_starts_with($linetext, 'Database')) {
                $linetext = "Database = " . $database . "\n";
                $replaced = true;
            }
            fputs($file_writing, $linetext);
        }
        fclose($file_reading);
        fclose($file_writing);

        if ($replaced) {
            unlink(SMSService::$FILEPATH);
            rename(SMSService::$FILEPATH_TEMP, SMSService::$FILEPATH);
            $responce = true;
        } else {
            unlink(SMSService::$FILEPATH_TEMP);
        }
        return $responce;
    }

    public function saveGammuConfigs($configs) {
        $device = $configs['device'];
        $connection = $configs['connection'];
        $logfile = $configs['logfile'];
        $replaced = false;
        $file_reading = fopen(SMSService::$FILEPATH, 'r');
        $file_writing = fopen(SMSService::$FILEPATH_TEMP, 'w');
        $responce = false;

        while (!feof($file_reading)) {
            $linetext = fgets($file_reading);
            if (StringManipulator::str_starts_with($linetext, 'device')) {
                $linetext = "device = " . $device . "\n";
                $replaced = true;
            }
            if (StringManipulator::str_starts_with($linetext, 'connection')) {
                $linetext = "connection = " . $connection . "\n";
                $replaced = true;
            }
            if (StringManipulator::str_starts_with($linetext, 'logfile')) {
                $linetext = "logfile = " . $logfile . "\n";
                $replaced = true;
            }
            fputs($file_writing, $linetext);
        }
        fclose($file_reading);
        fclose($file_writing);
        if ($replaced) {
            unlink(SMSService::$FILEPATH);
            rename(SMSService::$FILEPATH_TEMP, SMSService::$FILEPATH);
            $responce = true;
        } else {
            unlink(SMSService::$FILEPATH_TEMP);
        }
        return $responce;
    }

    public function identifyModem() {
        $command = 'C:\xampp\htdocs\laravel\Gammu\Gammu_1.33.0\bin\gammu.exe -c C:\xampp\htdocs\laravel\Gammu\Gammu_1.33.0\bin\smsdrc --identify';
        $response = shell_exec($command);
        //Process output ot command
        if (StringManipulator::str_starts_with($response, 'Device')) {
            $status = 'OK';
            $processed = $this->processoutput($response);
        } else {
            $status = 'FAIL';
            $processed = $response;
        }
        return ['status' => $status, 'output' => $processed];
    }

    public function processoutput($response) {
        $device='';
        $manufacture='';
        $model = '';
        $firmaware = '';
        $IMEI = '';
        $IMSI = '';
        $separator = "\n";
        $line = strtok($response, $separator);
        while ($line !== false) {
            # do something with $line
            if (StringManipulator::str_starts_with($line, 'Device')) {$device = StringManipulator::after(':', $line);
            } else
            if (StringManipulator::str_starts_with($line, 'Manufacturer')) {$manufacture = StringManipulator::after(':', $line);
            } else
            if (StringManipulator::str_starts_with($line, 'Model')) {$model = StringManipulator::after(':', $line);
            } else
            if (StringManipulator::str_starts_with($line, 'Firmware')) {$firmaware = StringManipulator::after(':', $line);
            } else
            if (StringManipulator::str_starts_with($line, 'IMEI')) {$IMEI = StringManipulator::after(':', $line);
            } else
            if (StringManipulator::str_starts_with($line, 'SIM')) {$IMSI = StringManipulator::after(':', $line);
            }
            $line = strtok($separator);
        }
        return ['Device'=>$device,
            'Manufacturer'=>$manufacture,
            'Model'=>$model,
            'Firmware'=>$firmaware,
            'IMEI'=>$IMEI,
            'IMSI'=>$IMSI];
    }

}
