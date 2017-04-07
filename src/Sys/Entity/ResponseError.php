<?php
namespace App\Sys\Entity;


use App\Sys\SERVER;
use App\Sys\SysMsg;

class ResponseError extends ResponseBasic
{
    public $tracking_code;
    public $code=0;

    public function __construct($message = "")
    {
        if(strpos($message,".")!==false)
            list($this->code, $message)=explode(".",$message);
        parent::__construct($message, SysMsg::SYS_STATUS_ERROR);

        $this->tracking_code = $this->getTrackingCode();
    }

    private function getTrackingCode()
    {
        return base64_encode(getmypid() . "|" . SERVER::getClientIP());
    }

    public function jsonSerialize()
    {
        return array(
            "status" => $this->status,
            "code"   => $this->code,
            "message" => $this->message,
            'tracking_code' => $this->tracking_code
        );
    }

    public function __toString()
    {
        return json_encode($this);
    }
}