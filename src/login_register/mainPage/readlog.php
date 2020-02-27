<?php
session_start();

//object classes for the log file
class SyslogFileData
{
    private $time, $service, $message;

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getService()
    {
        return $this->service;
    }

    public function setService($service)
    {
        $this->service = $service;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public static $syslogCount = 0;

    public function __construct($time, $service, $message)
    {
        $this->time = $time;
        $this->service = $service;
        $this->message = $message;
        SyslogFileData::$syslogCount++;
        return true;
    }

    public function getDescription()
    {

        echo $this->time . " " . $this->service . " " . $this->message;
    }
}

class KernelFileData
{
    private $time, $service, $message;

    public function __construct($time, $service, $message)
    {
        $this->time = $time;
        $this->service = $service;
        $this->message = $message;
    }

    public function getDescription()
    {

        echo $this->time . " " . $this->service . " " . $this->message;
    }
}

class AuthFileData
{
    private $time, $service, $session, $message;

    public function __construct($time, $service, $session, $message)
    {
        $this->time = $time;
        $this->service = $service;
        $this->session = $session;
        $this->message = $message;
    }

    public function getDescription()
    {
        if (($this->time && $this->service) && !$this->session) {
            echo $this->time . " " . $this->service . " " .
                $this->message;
        } else {
            echo $this->time . " " . $this->service . " " .
                $this->session . " " . $this->message;
        }
    }
}

class LogFileSemicolon
{
    private $time, $service, $username, $tty, $password, $user, $command;

    public function __construct($time, $service, $username, $tty, $password, $user, $command)
    {
        $this->time = $time;
        $this->service = $service;
        $this->username = $username;
        $this->tty = $tty;
        $this->password = $password;
        $this->user = $user;
        $this->command = $command;
    }

    public function getDescription()
    {
        echo $this->time . " " . $this->service . " " . $this->username . " " . $this->tty . " " . $this->password . " " . $this->user . " " . $this->command;
    }
}

class MySQLFileData
{
    private $time, $service, $message;

    public function __construct($time, $service, $message)
    {
        $this->time = $time;
        $this->service = $service;
        $this->message = $message;
    }

    public function getDescription()
    {

        echo $this->time . " " . $this->service . " " . $this->message;
    }
}


//load selected option
include_once("selectLogs.php");

//copy log file
function copyVarLogFileIntoFolder($fileName){
    chmod("/var/log/auth.log", 0444);
    chmod("/var/log/kern.log", 0444);
    chmod("/var/log/mysql/error.log", 0444);
    chmod("/var/log/syslog", 0444);

    if(!copy("/var/log/$fileName", "system_logs/$fileName")){
        echo "\nFailed to copy the " . $fileName . " into the folder.\nPossibly permission issue.\n";
    }
    chmod('system_logs/' . $fileName, 0777);
}

function GetRegexMatches($regexType, $line)
{
    if (preg_match($regexType, $line, $matches)) {
        foreach ($matches as $string) {
            $string = trim($string);
            return $string;
        }
    }
}

function readLinesFromLog($fileName, $con)
{
//reading from file line by line with regex
    $timeRegex = "/^\w{3}\s+\d+\s\d{2}:\d{2}:\d{2}/i";
    $serviceRegex = "/(?<=\d{2}\s).+?(?=\:)/i";
    $sessionRegex = "/(?<=\]|\:) \w{1,}\(.*?\)/i";
    $messageRegex = "/(?<=\:\s).*$/i";

//semicolon regex
    $usernameRegex = "/(?<=\w\: ).*?(?=\:)/i";
    $ttyRegex = "/\w+\=\w+\d/i";
    $passwordRegex = "/\w+\=\/\s/i";
    $userRegex = "/\w{4}\=\w+/i";
    $commandRegex = "/\w{4,}\=\/.*/i";

//syslog regex
    $syslogTimeRegex = "/^\w{3}\s+\d+\s\d{2}:\d{2}:\d{2}/i";
    $syslogServiceRegex = "/(?<=\:\d{2}\s).+?(?=\:)/i";
    $syslogMessageRegex = "/(?<=\:\s).*$/i";

//
    $mysqlTimeRegex = "/^\d+-\d{2}-\d{2}\s+\d+:\d+:\d+/i";
    $mysqlServiceRegex = "/(?<=\:\d{2}\s).+?(?=\:)/i";
    $mysqlMessageRegex = "/(?<=\:\s).*$/i";


//    $filePath = "logs/upload_test.txt";
    $file = fopen($fileName, "r");
    if ($file) {
        if (filesize($fileName) > 0) {

            //ANALISE ROWS
            while (($line = fgets($file)) !== false) {
                //handles rare rows where half of it is separated with semicolons
                $semicolonArray = explode(';', $line);

                //work with semicolon line
                if (sizeof($semicolonArray) > 1 && $fileName!="/var/log/syslog") {
                    //store the exact regex matches
                    $timeColonData = GetRegexMatches($timeRegex, $line);
                    $serviceColonData = GetRegexMatches($serviceRegex, $line);
                    $usernameData = GetRegexMatches($usernameRegex, $line);
                    $ttyData = GetRegexMatches($ttyRegex, $line);
                    $passwordData = GetRegexMatches($passwordRegex, $line);
                    $userData = GetRegexMatches($userRegex, $line);
                    $commandData = GetRegexMatches($commandRegex, $line);

                    //create objects
                    $oneColonLine = new LogFileSemicolon($timeColonData, $serviceColonData,
                        $usernameData, $ttyData, $passwordData, $userData, $commandData);

                    //get objects
                    $oneColonLine->getDescription();
                } else if ($fileName == '/var/log/syslog' || $fileName ==  '/var/www/faildomain.com/src/login_register/mainPage/logs/upload_test.txt') {
                    $syslogTimeData = GetRegexMatches($syslogTimeRegex, $line);
                    $syslogServiceData = GetRegexMatches($syslogServiceRegex, $line);
                    $syslogMessageData = GetRegexMatches($syslogMessageRegex, $line);

                    //create objects
                    $syslogLine = new SyslogFileData($syslogTimeData,
                        $syslogServiceData, $syslogMessageData);

                    //insert into database
                    $insertSyslogSQL = "INSERT INTO Syslog(time, service, message)
                            VALUES ('$syslogTimeData','$syslogServiceData', '$syslogMessageData')";
                    mysqli_query($con, $insertSyslogSQL);

                    //get objects
                    $syslogLine->getDescription();
                } else if ($fileName == '/var/log/kern.log') {
                    $kernelTimeData = GetRegexMatches($syslogTimeRegex, $line);
                    $kernelServiceData = GetRegexMatches($syslogServiceRegex, $line);
                    $kernelMessageData = GetRegexMatches($syslogMessageRegex, $line);

                    //create objects
                    $kernelLine = new KernelFileData($kernelTimeData,
                        $kernelServiceData, $kernelMessageData);

                    //insert into database
                    $insertKernlogSQL = "INSERT INTO Kern_log(time, service, message)
                            VALUES ('$kernelTimeData','$kernelServiceData', '$kernelMessageData')";
                    mysqli_query($con, $insertKernlogSQL);

                    //get objects
                    $kernelLine->getDescription();
                } else if ($fileName == "/var/log/auth.log") {
                    //store the exact regex matches
                    $authTimeData = GetRegexMatches($timeRegex, $line);
                    $authServiceData = GetRegexMatches($serviceRegex, $line);
                    $authSessionData = GetRegexMatches($sessionRegex, $line);
                    $authMessageData = GetRegexMatches($messageRegex, $line);

                    //create objects
                    $authLine = new AuthFileData($authTimeData, $authServiceData,
                        $authSessionData, $authMessageData);

                    //insert into database
                    $insertAuthlogSQL = "INSERT INTO Auth_log(time, service, session, message)
                            VALUES ('$authTimeData','$authServiceData', '$authSessionData', '$authMessageData')";
                    mysqli_query($con, $insertAuthlogSQL);

                    //get objects
                    $authLine->getDescription();
                } else if ($fileName == "/var/log/mysql/error.log") {
                    $mysqlTimeData = GetRegexMatches($mysqlTimeRegex, $line);
                    $mysqlServiceData = GetRegexMatches($mysqlServiceRegex, $line);
                    $mysqlMessageData = GetRegexMatches($mysqlMessageRegex, $line);

                    //create objects
                    $mysqlLine = new MySQLFileData($mysqlTimeData,
                        $mysqlServiceData, $mysqlMessageData);

                    //insert into database
                    $insertMysqlErrorlogSQL = "INSERT INTO Mysql_Error_log(time, service, message)
                            VALUES ('$mysqlTimeData','$mysqlServiceData', '$mysqlMessageData')";
                    mysqli_query($con, $insertMysqlErrorlogSQL);

                    //get objects
                    $mysqlLine->getDescription();
                }
                echo "\n";
            }
            $con->close();
            fclose($file);
        } else {
            echo "The log file " . $fileName . " is empty";
        }
    } else {
        echo "The filepath is incorrect! " . $fileName . " not found";
    }
}
