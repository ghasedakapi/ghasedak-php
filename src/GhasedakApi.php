<?php

namespace Ghasedak;

use Ghasedak\Exceptions\HttpException;
use Ghasedak\Exceptions\ApiException;

class GhasedakApi
{
    protected $apiKey;
    private $base_url;

    const VERSION = "2.0.0";

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
        $this->base_url = 'http://api.ghasedak.io/v2/';
    }

    protected function runCurl($path, $parameters = null, $method = 'POST')
    {
        $headers = array(
            'apikey:' . $this->apiKey,
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'charset: utf-8'
        );

        $params = http_build_query($parameters);
        $url = $this->base_url . $path . '?agent=php';

        $init = curl_init();
        curl_setopt($init, CURLOPT_URL, $url);
        curl_setopt($init, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($init, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($init, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($init, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($init, CURLOPT_POSTFIELDS, $params);

        $result = curl_exec($init);
        $code = curl_getinfo($init, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($init);
        $curl_error = curl_error($init);
        if ($curl_errno) {
            throw new HttpException($curl_error, $curl_errno);
        }

        $json_result = json_decode($result);

        if ($code != 200 && is_null($json_result)) {
            throw new HttpException("Request http errors", $code);
        } else {
            $return = $json_result->result;
            if ($return->code != 200) {
                throw new ApiException($return->message, $return->code);
            }
            return $json_result;
        }
    }

    public function SendSimple($receptor, $message, $linenumber = null, $senddate = null, $checkid = null)
    {
        $path = 'sms/send/simple';
        $params = array(
            "receptor" => $receptor,
            "linenumber" => $linenumber,
            "message" => $message,
            "senddate" => $senddate,
            "checkid" => $checkid
        );
        return $this->runCurl($path, $params, 'POST');
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
        $path = 'sms/send/bulk';
        $params = array(
            "receptor" => $receptor,
            "linenumber" => $linenumber,
            "message" => $message,
            "senddate" => $date,
            "checkid" => $checkid
        );
        return $this->runCurl($path, $params);
    }

    public function SendPair($linenumber, $receptor, $message, $date = null, $checkid = null)
    {
        if (is_array($receptor)) {
            $receptor = implode(",", $receptor);
        }
        $path = 'sms/send/pair';
        $params = array(
            "receptor" => $receptor,
            "linenumber" => $linenumber,
            "message" => $message,
            "senddate" => $date,
            "checkid" => $checkid
        );
        return $this->runCurl($path, $params);
    }

    public function Verify($receptor, $type, $template, ...$args)
    {
        if (is_array($receptor)) {
            $receptor = implode(",", $receptor);
        }
        $path = 'verification/send/simple';
        $params = array(
            "receptor" => $receptor,
            "type" => $type,
            "template" => $template
        );
        if (count($args) > 10 || count($args) == 0) {
            throw new ApiException('Number of parameters exceeds maximum of 10', '409');
        }
        foreach ($args as $key => $arg) {
            $params['param' . ($key + 1)] = $arg;
        }
        return $this->runCurl($path, $params);
    }

    public function Status($id, $type)
    {
        if (is_array($id)) {
            $id = implode(",", $id);
        }
        $path = 'sms/status';
        $params = array(
            "id" => $id,
            "type" => $type
        );
        return $this->runCurl($path, $params, 'GET');
    }

    public function AddGroup($name, $parent = null)
    {
        $path = 'contact/group/new';
        $params = array(
            "name" => $name,
            "parent" => $parent
        );
        return $this->runCurl($path, $params);
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
        $path = 'contact/group/addnumber';
        $params = array(
            "groupid" => $groupid,
            "number" => $number,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
        );
        return $this->runCurl($path, $params);
    }

    public function GroupList($parent = null)
    {
        $path = 'contact/group/list';
        $params = array(
            "parent" => $parent,
        );
        return $this->runCurl($path, $params, 'GET');
    }

    public function GroupNumberList($groupid, $offset = null, $page = null)
    {
        $path = 'contact/group/listnumber';
        $params = array(
            "groupid" => $groupid,
            "offset" => $offset,
            "page" => $page
        );
        return $this->runCurl($path, $params, 'GET');
    }

    public function GroupEdit($groupid, $name)
    {
        $path = 'contact/group/edit';
        $params = array(
            "groupid" => $groupid,
            "name" => $name
        );
        return $this->runCurl($path, $params);
    }

    public function GroupRemove($groupid)
    {
        $path = 'contact/group/remove';
        $params = array(
            "groupid" => $groupid
        );
        return $this->runCurl($path, $params);
    }

    public function ReceiveSms($linenumber, $isread)
    {
        $path = 'sms/receive/last';
        $params = array(
            "linenumber" => $linenumber,
            "isread" => $isread,
        );
        return $this->runCurl($path, $params);
    }

    public function ReceivePaging($linenumber, $isread, $fromdate, $todate, $page, $offset)
    {
        $path = 'sms/receive/paging';
        $params = array(
            "linenumber" => $linenumber,
            "isread" => $isread,
            "fromdate" => $fromdate,
            "todate" => $todate,
            "page" => $page,
            "offset" => $offset,
        );
        return $this->runCurl($path, $params);
    }

    public function CancelSms($messageid)
    {
        if (is_array($messageid)) {
            $messageid = implode(",", $messageid);
        }
        $path = 'sms/cancel';
        $params = array(
            "messageid" => $messageid,
        );
        return $this->runCurl($path, $params);
    }

    public function AccountInfo()
    {
        $path = 'account/info';
        $params = array();
        return $this->runCurl($path, $params, 'GET');
    }
}