<?php
session_start();
unset($_SESSION["title"]);
unset($_SESSION["counter"]);
unset($_SESSION["warn"]);
unset($_SESSION["error"]);
unset($_SESSION["debug"]);
unset($_SESSION["notice"]);
unset($_SESSION["today_new_logs"]);

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
    private $time, $service, $message;

    public static $authCount = 0;

    public function __construct($time, $service, $message)
    {
        $this->time = $time;
        $this->service = $service;
        $this->message = $message;
        AuthFileData::$authCount++;
    }

    public function getDescription()
    {
        echo $this->time . " " . $this->service . " " . $this->message;
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

class UfwFileData
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

    public static $ufwlogCount = 0;

    public function __construct($time, $service, $message)
    {
        $this->time = $time;
        $this->service = $service;
        $this->message = $message;
        UfwFileData::$ufwlogCount++;
        return true;
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

//syslog regex ALSO USED AS UFW LOG
    $syslogTimeRegex = "/^\w{3}\s+\d+\s\d{2}:\d{2}:\d{2}/i";
    $syslogServiceRegex = "/(?<=\:\d{2}\s).+?(?=\:)/i";
    $syslogMessageRegex = "/(?<=\:\s).*$/i";

//mysql_error regex MAYBE TIME & MESSAGE
    $mysqlTimeRegex = "/^\d+-\d{2}-\d{2}\s+\d+:\d+:\d+/i";
    $mysqlServiceRegex = "/(?<=\:\d{2}\s).+?\s(\w+)?(?=\:|\s)/i";
    $mysqlMessageRegex = "/(?<=\:\s).*$/i";

//auth.log regex SESSION IS NOT NECESSARY WHILE IT APPEARS FROM TIME TO TIME
    $authTimeRegex = "/^\w{3}\s+\d+\s\d{2}:\d{2}:\d{2}/i";
    $authServiceRegex = "/(?<=\:\d{2}\s).+?.+(?=\:)/i";
    $authMessageRegex = "/(?<= )[^:]*$/i";

//severities
    $syslogMessageSeverity = array();
    $mysqlMessageSeverity = array();
    $kernMessageSeverity = array();
    $authMessageSeverity = array();
    $ufwMessageSeverity = array();
    $customMessageSeverity = array();

//times
    $syslogTimeArray = array();
    $mysqlTimeArray = array();
    $kernelTimeArray = array();
    $authTimeArray = array();
    $ufwTimeArray = array();
    $customTimeArray = array();


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

                    //severity
                    $syslogMessageSeverity[] = $syslogMessageData;

                    //time
                    $syslogTimeArray[] = $syslogTimeData;

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

                    //severity
                    $kernMessageSeverity[] = $kernelMessageData;

                    //time
                    $kernelTimeArray[] = $kernelTimeData;

                    //insert into database
                    $insertKernelLogSQL = "INSERT INTO Kern_log(time, service, message)
                            VALUES ('$kernelTimeData','$kernelServiceData', '$kernelMessageData')";
                    mysqli_query($con, $insertKernelLogSQL);

                    //get objects
                    $kernelLine->getDescription();
                } else if ($fileName == "/var/log/auth.log") {
                    //store the exact regex matches
                    $authTimeData = GetRegexMatches($authTimeRegex, $line);
                    $authServiceData = GetRegexMatches($authServiceRegex, $line);
                    $authMessageData = GetRegexMatches($authMessageRegex, $line);

                    //create objects
                    $authLine = new AuthFileData($authTimeData, $authServiceData,
                        $authMessageData);

                    //severity
                    $authMessageSeverity[] = $authMessageData;

                    //time
                    $authTimeArray[] = $authTimeData;

                    //insert into database
                    $insertAuthlogSQL = "INSERT INTO Auth_log(time, service, message)
                            VALUES ('$authTimeData','$authServiceData', '$authMessageData')";
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

                    //severity
                    $mysqlMessageSeverity[] = $mysqlMessageData;

                    //time
                    $mysqlTimeArray[] = $mysqlTimeData;

                    //insert into database
                    $insertMysqlErrorlogSQL = "INSERT INTO Mysql_Error_log(time, service, message)
                            VALUES ('$mysqlTimeData','$mysqlServiceData', '$mysqlMessageData')";
                    mysqli_query($con, $insertMysqlErrorlogSQL);

                    //get objects
                    $mysqlLine->getDescription();
                }else if ($fileName == '/var/log/ufw.log') {
                    $ufwTimeData = GetRegexMatches($syslogTimeRegex, $line);
                    $ufwServiceData = GetRegexMatches($syslogServiceRegex, $line);
                    $ufwMessageData = GetRegexMatches($syslogMessageRegex, $line);

                    //create objects
                    $ufwLogLine = new SyslogFileData($ufwTimeData,
                        $ufwServiceData, $ufwMessageData);

                    //severity
                    $ufwMessageSeverity[] = $ufwMessageData;

                    //time
                    $ufwTimeArray[] = $ufwTimeData;

                    //insert into database
                    $insertUfwSQL = "INSERT INTO Ufw_log(time, service, message)
                            VALUES ('$ufwTimeData','$ufwServiceData', '$ufwMessageData')";
                    mysqli_query($con, $insertUfwSQL);

                    //get objects
                    $ufwLogLine->getDescription();
                } else if($fileName ==  '/var/www/faildomain.com/src/login_register/mainPage/logs/'.$_SESSION['customLog']){
                    $customTimeData = GetRegexMatches($syslogTimeRegex, $line);
                    $customServiceData = GetRegexMatches($syslogServiceRegex, $line);
                    $customMessageData = GetRegexMatches($syslogMessageRegex, $line);

                    //create objects
                    $customLine = new CustomFileData($customTimeData,
                        $customServiceData, $customMessageData);

                    //severity
                    $customMessageSeverity[] = $customMessageData;

                    //time
                    $customTimeArray[] = $customTimeData;

                    //insert into database
                    $insertCustomSQL = "INSERT INTO Custom_log(time, service, message)
                            VALUES ('$customTimeData','$customServiceData', '$customMessageData')";
                    mysqli_query($con, $insertCustomSQL);

                    //get objects
                    $customLine->getDescription();
                }
                echo "\n";
            }


            $_SESSION['counter'] = 0;
            $_SESSION['warn'] = 0;
            $_SESSION["error"] = 0;
            $_SESSION["debug"] = 0;
            $_SESSION["notice"] = 0;
            $_SESSION["today_new_logs"] = 0;

            //if log reading has been run
            if(SyslogFileData::$syslogCount>0){
                $_SESSION['error'] = ErrorSeverity($syslogMessageSeverity);
                $_SESSION['warn'] = WarningSeverity($syslogMessageSeverity);
                $_SESSION['debug'] = DebugSeverity($syslogMessageSeverity);
                $_SESSION['notice'] = NoticeSeverity($syslogMessageSeverity);
                $_SESSION['today_new_logs'] = TodaysLogs($syslogTimeArray);
                $_SESSION['counter'] = SyslogFileData::$syslogCount;
            }else if(MySQLFileData::$mysqlCounter>0){
                $_SESSION['error'] = ErrorSeverity($mysqlMessageSeverity);
                $_SESSION['warn'] = WarningSeverity($mysqlMessageSeverity);
                $_SESSION['debug'] = DebugSeverity($mysqlMessageSeverity);
                $_SESSION['notice'] = NoticeSeverity($mysqlMessageSeverity);
                $_SESSION['today_new_logs'] = TodaysLogs($mysqlTimeArray);
                $_SESSION['counter'] = MySQLFileData::$mysqlCounter;
            }elseif(KernelFileData::$kernelCount>0){
                $_SESSION['error'] = ErrorSeverity($kernMessageSeverity);
                $_SESSION['warn'] = WarningSeverity($kernMessageSeverity);
                $_SESSION['debug'] = DebugSeverity($kernMessageSeverity);
                $_SESSION['notice'] = NoticeSeverity($kernMessageSeverity);
                $_SESSION['today_new_logs'] = TodaysLogs($kernelTimeArray);
                $_SESSION['counter'] = KernelFileData::$kernelCount;
            }elseif(AuthFileData::$authCount>0){
                $_SESSION['error'] = ErrorSeverity($authMessageSeverity);
                $_SESSION['warn'] = WarningSeverity($authMessageSeverity);
                $_SESSION['debug'] = DebugSeverity($authMessageSeverity);
                $_SESSION['notice'] = NoticeSeverity($authMessageSeverity);
                $_SESSION['today_new_logs'] = TodaysLogs($authTimeArray);
                $_SESSION['counter'] = AuthFileData::$authCount;
            }else if(UfwFileData::$ufwlogCount>0){
                $_SESSION['error'] = ErrorSeverity($ufwMessageSeverity);
                $_SESSION['warn'] = WarningSeverity($ufwMessageSeverity);
                $_SESSION['debug'] = DebugSeverity($ufwMessageSeverity);
                $_SESSION['notice'] = NoticeSeverity($ufwMessageSeverity);
                $_SESSION['today_new_logs'] = TodaysLogs($ufwTimeArray);
                $_SESSION['counter'] = UfwFileData::$ufwlogCount;
            }elseif(CustomFileData::$customlogCount>0){
                $_SESSION['error'] = ErrorSeverity($customMessageSeverity);
                $_SESSION['warn'] = WarningSeverity($customMessageSeverity);
                $_SESSION['debug'] = DebugSeverity($customMessageSeverity);
                $_SESSION['notice'] = NoticeSeverity($customMessageSeverity);
                $_SESSION['today_new_logs'] = TodaysLogs($customTimeArray);
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
function DebugSeverity($array){
    $warning1 = "debug";
    $warning2 = "DEBUG";
    $debugCount = 0;
    foreach ($array as $item) {
        if (strpos($item, $warning1) !== false) {
            $debugCount++;
        }
        elseif (strpos($item, $warning2) !== false) {
            $debugCount++;
        }
    }
    return $debugCount;
}
function ErrorSeverity($array){
    $warning1 = "error";
    $errorCount = 0;
    foreach ($array as $item) {
        if (strpos($item, $warning1) !== false) {
            $errorCount++;
        }
    }
    return $errorCount;
}
function WarningSeverity($array){

    $warning1 = "Warning";
    $warning2 = "WARNING";
    $warningCount = 0;
    foreach ($array as $item) {
        if (strpos($item, $warning1) !== false) {
            $warningCount++;
        }
        elseif (strpos($item, $warning2) !== false) {
            $warningCount++;
        }
    }
    return $warningCount;
}
function NoticeSeverity($array){
    $warning1 = "notice";
    $warning2 = "NOTICE";
    $noticeCount = 0;
    foreach ($array as $item) {
        if (strpos($item, $warning1) !== false) {
            $noticeCount++;
        }
        elseif (strpos($item, $warning2) !== false) {
            $noticeCount++;
        }
    }
    return $noticeCount;
}
function TodaysLogs($array){
    //Mar 29 || 2020-03-29
    $currentTime1 = date('M d');
    $currentTime2 = date('Y-m-d');
    $todayCount = 0;
    foreach ($array as $item) {
        if (strpos($item, $currentTime1) !== false) {
            $todayCount++;
        }
        elseif (strpos($item, $currentTime2) !== false) {
            $todayCount++;
        }
    }
    return $todayCount;
}