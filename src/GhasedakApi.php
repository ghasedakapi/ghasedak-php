<?php
namespace Ghasedak;
use Ghasedak\Exceptions\ApiException;

class GhasedakApi
{
    protected $apiKey;
    const VERSION = "1.0.0";

    public function __construct($apiKey)
    {
        if (!extension_loaded('curl')) {
            die('Curl not loaded');
            exit;
        }
        if (is_null($apiKey)) {
            die('apiKey has not been sent');
            exit;
        }
        $this->apiKey = $apiKey;
    }

    protected function runCurl($url, $parameters = null)
    {
        $headers = array(
            'apikey:' . $this->apiKey,
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'charset: utf-8'
        );
        $params = "";
        if (!is_null($parameters)) {
                $params = http_build_query($parameters);
        }
        $init = curl_init();
        curl_setopt($init, CURLOPT_URL, $url);
        curl_setopt($init, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($init, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($init, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($init, CURLOPT_POST, true);
        curl_setopt($init, CURLOPT_POSTFIELDS, $params);

        $result = curl_exec($init);
        $code = curl_getinfo($init, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($init);
        $curl_error = curl_error($init);
        try {
            if ($curl_errno) {
                throw new ApiException($curl_error, $curl_errno);
            }
        } catch (ApiException $e) {
            return $e->errorMessage();
        }
        $json_result = json_decode($result);


        if ($code != 200 && is_null($json_result)) {

            throw new ApiException("Request have errors", $code);
        } else {
            $return = $json_result->result;
            try {
                if ($return->code != 200) {
                    throw new ApiException($return->message, $return->code);
                }
            } catch (ApiException $e) {
                return $e->errorMessage();
            }
            return $json_result->items;
        }
    }

    public function SendSimple($linenumber = null, $receptor, $message, $senddate = null, $checkid = null)
    {
        $url = 'http://ghasedakapi.com/v1/sms/send/simple';
        $params = array(
            "receptor" => $receptor,
            "linenumber" => $linenumber,
            "message" => $message,
            "senddate" => $senddate,
            "checkid" => $checkid
        );
        return $this->runCurl($url, $params);
    }

    public function SendBulk($linenumber, $receptor, $message, $date, $checkid = null)
    {
        if (is_array($receptor)) {
            $receptor = implode(",", $receptor);
        }
        if (is_array($linenumber)) {
            $linenumber = implode(",", $linenumber);
        }
        if (is_array($message)) {
            $message = implode(",", $message);
        }
        if (is_array($date)) {
            $date = implode(",", $date);
        }
        $url = 'http://ghasedakapi.com/v1/sms/send/bulk';
        $params = array(
            "receptor" => $receptor,
            "linenumber" => $linenumber,
            "message" => $message,
            "senddate" => $date,
            "checkid" => $checkid
        );
        return $this->runCurl($url, $params);
    }

    public function SendBulk2($linenumber, $receptor, $message, $date = null, $checkid = null)
    {
        if (is_array($receptor)) {
            $receptor = implode(",", $receptor);
        }
        $url = 'http://ghasedakapi.com/v1/sms/send/pair';
        $params = array(
            "receptor" => $receptor,
            "linenumber" => $linenumber,
            "message" => $message,
            "senddate" => $date,
            "checkid" => $checkid
        );
        return $this->runCurl($url, $params);
    }

    public function SendVoice($receptor, $message, $date = null)
    {
        if (is_array($receptor)) {
            $receptor = implode(",", $receptor);
        }
        $url = 'http://ghasedakapi.com/v1/voice/send';
        $params = array(
            "receptor" => $receptor,
            "message" => $message,
            "senddate" => $date,
        );
        return $this->runCurl($url, $params);
    }

    public function Verify($receptor, $type, $template, $param1, $param2 = null, $param3 = null)
    {
        if (is_array($receptor)) {
            $receptor = implode(",", $receptor);
        }
        $url = 'http://ghasedakapi.com/v1/sms/template ';
        $params = array(
            "receptor" => $receptor,
            "type" => $type,
            "template" => $template,
            "param1" => $param1,
            "param2" => $param2,
            "param3" => $param3,
        );
        return $this->runCurl($url, $params);
    }

    public function Status($messageid)
    {
        if (is_array($messageid)) {
            $messageid = implode(",", $messageid);
        }
        $url = 'http://ghasedakapi.com/v1/account/status';
        $params = array(
            "messageid" =>$messageid
        );
        return $this->runCurl($url, $params);
    }

    public function Check($checkid)
    {
        if (is_array($checkid)) {
            $checkid = implode(",", $checkid);
        }
        $url = 'http://ghasedakapi.com/v1/sms/check';
        $params = array(
            "checkid" => $checkid
        );
        return $this->runCurl($url, $params);
    }

    public function Select($messageid)
    {
        if (is_array($messageid)) {
            $messageid = implode(",", $messageid);
        }
        $url = 'http://ghasedakapi.com/v1/sms/select';
        $params = array(
            "messageid" => $messageid
        );
        return $this->runCurl($url, $params);
    }

    public function AddGroup($name, $parent = null)
    {
        $url = 'http://ghasedakapi.com/v1/contact/group/add';
        $params = array(
            "name" => $name,
            "parent" => $parent
        );
        return $this->runCurl($url, $params);
    }

    public function AddNumber($groupid, $number, $firstname = null, $lastname = null, $email = null)
    {

        if (is_array($number)) {
            $number = implode(",", $number);
        }
        if (is_array($firstname)) {
            $firstname = implode(",", $firstname);
        }
        if (is_array($lastname)) {
            $lastname = implode(",", $lastname);
        }
        if (is_array($email)) {
            $email = implode(",", $email);
        }
        $url = 'http://ghasedakapi.com/v1/contact/group/number/add';
        $params = array(
            "groupid" => $groupid,
            "number" => $number,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
        );
        return $this->runCurl($url, $params);
    }

    public function GroupList($parent = null)
    {
        $url = 'http://ghasedakapi.com/v1/contact/group/list';
        $params = array(
            "parent" => $parent,
        );
        return $this->runCurl($url, $params);
    }

    public function GroupNumberList($groupid, $offset = null, $page = null)
    {
        $url = 'http://ghasedakapi.com/v1/contact/group/number/list';
        $params = array(
            "groupid" => $groupid,
            "offset" => $offset,
            "page" => $page
        );
        return $this->runCurl($url, $params);
    }

    public function GroupEdit($groupid, $name)
    {
        $url = 'http://ghasedakapi.com/v1/contact/group/edit';
        $params = array(
            "groupid" => $groupid,
            "name" => $name
        );
        return $this->runCurl($url, $params);
    }

    public function GroupRemove($groupid)
    {
        $url = 'http://ghasedakapi.com/v1/contact/group/remove';
        $params = array(
            "groupid" => $groupid
        );
        return $this->runCurl($url, $params);
    }

    public function ReceiveSms($linenumber, $isread)
    {
        $url = 'http://ghasedakapi.com/v1/sms/receive';
        $params = array(
            "linenumber" => $linenumber,
            "isread" => $isread,
        );
        return $this->runCurl($url, $params);
    }

    public function CancelSms($messageid)
    {
        if (is_array($messageid)) {
            $messageid = implode(",", $messageid);
        }
        $url = 'http://ghasedakapi.com/v1/sms/cancel';
        $params = array(
            "messageid" => $messageid,
        );
        return $this->runCurl($url, $params);
    }

    public function AccountInfo()
    {
        $url = 'http://ghasedakapi.com/v1/account/info';
        $params = array();
        return $this->runCurl($url, $params);
    }
}