<?php
session_start();
unset($_SESSION["counter"]);

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

    public static $kernelCount = 0;

    public function __construct($time, $service, $message)
    {
        $this->time = $time;
        $this->service = $service;
        $this->message = $message;
        KernelFileData::$kernelCount++;
    }

    public function getDescription()
    {

        echo $this->time . " " . $this->service . " " . $this->message;
    }
}

class AuthFileData
{
    private $time, $service, $session, $message;

    public static $authCount = 0;

    public function __construct($time, $service, $session, $message)
    {
        $this->time = $time;
        $this->service = $service;
        $this->session = $session;
        $this->message = $message;
        AuthFileData::$authCount++;
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

    public static $semicolonCounter = 0;

    public function __construct($time, $service, $username, $tty, $password, $user, $command)
    {
        $this->time = $time;
        $this->service = $service;
        $this->username = $username;
        $this->tty = $tty;
        $this->password = $password;
        $this->user = $user;
        $this->command = $command;
        LogFileSemicolon::$semicolonCounter++;
    }

    public function getDescription()
    {
        echo $this->time . " " . $this->service . " " . $this->username . " " . $this->tty . " " . $this->password . " " . $this->user . " " . $this->command;
    }
}

class MySQLFileData
{
    private $time, $service, $message;

    public static $mysqlCounter = 0;

    public function __construct($time, $service, $message)
    {
        $this->time = $time;
        $this->service = $service;
        $this->message = $message;
        MySQLFileData::$mysqlCounter++;
    }

    public function getDescription()
    {

        echo $this->time . " " . $this->service . " " . $this->message;
    }
}

class CustomFileData
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

    public static $customlogCount = 0;

    public function __construct($time, $service, $message)
    {
        $this->time = $time;
        $this->service = $service;
        $this->message = $message;
        CustomFileData::$customlogCount++;
        return true;
    }

    public function getDescription()
    {

        echo $this->time . " " . $this->service . " " . $this->message;
    }
}


//load selected option
include_once("selectLogs.php");

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

//mysql_error regex MAYBE TIME & MESSAGE
    $mysqlTimeRegex = "/^\d+-\d{2}-\d{2}\s+\d+:\d+:\d+/i";
    $mysqlServiceRegex = "/(?<=\:\d{2}\s).+?\s(\w+)?(?=\:|\s)/i";
    $mysqlMessageRegex = "/(?<=\:\s).*$/i";


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
                } else if ($fileName == '/var/log/syslog') {
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
                }else if($fileName ==  '/var/www/faildomain.com/src/login_register/mainPage/logs/'.$_SESSION['customLog']){
                    $customTimeData = GetRegexMatches($syslogTimeRegex, $line);
                    $customServiceData = GetRegexMatches($syslogServiceRegex, $line);
                    $customMessageData = GetRegexMatches($syslogMessageRegex, $line);

                    //create objects
                    $customLine = new CustomFileData($customTimeData,
                        $customServiceData, $customMessageData);

                    //insert into database
                    $insertCustomSQL = "INSERT INTO Custom_log(time, service, message)
                            VALUES ('$customTimeData','$customServiceData', '$customMessageData')";
                    mysqli_query($con, $insertCustomSQL);

                    //get objects
                    $customLine->getDescription();
                }
                echo "\n";
            }

            // get line count
            if(SyslogFileData::$syslogCount>0){
                $_SESSION['counter'] = 0;
                $_SESSION['counter'] = SyslogFileData::$syslogCount;
            }elseif(MySQLFileData::$mysqlCounter>0){
                $_SESSION['counter'] = 0;
                $_SESSION['counter'] = MySQLFileData::$mysqlCounter;
            }elseif(KernelFileData::$kernelCount>0){
                $_SESSION['counter'] = 0;
                $_SESSION['counter'] = KernelFileData::$kernelCount;
            }elseif(AuthFileData::$authCount>0){
                $_SESSION['counter'] = 0;
                $_SESSION['counter'] = AuthFileData::$authCount;
            }elseif(CustomFileData::$customlogCount>0){
                $_SESSION['counter'] = 0;
                $_SESSION['counter'] = CustomFileData::$customlogCount;
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
