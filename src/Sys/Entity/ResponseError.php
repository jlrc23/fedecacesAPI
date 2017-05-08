<?php
namespace App\Sys\Entity;


use App\Sys\SERVER;
use App\Sys\SysMsg;

class ResponseError extends ResponseBasic
{
    public $tracking_code;
    public $code=0;

    public function __construct($message, $code=null )
    {
        if(!empty($code))
            $this->code = $code;

        if(!is_array($message) && strpos($message,".")!==false){
            list($this->code, $message)=explode(".",$message);
            parent::__construct(trim($message), SysMsg::SYS_STATUS_ERROR);
            $this->tracking_code = $this->getTrackingCode();
        }else{
            parent::__construct($message, 500);
        }

    }

    private function getTrackingCode()
    {
        return base64_encode(getmypid() . "|" . SERVER::getClientIP());
    }

    public function jsonSerialize()
    {
        return array(
            "status" => $this->status,
            "code"   => intval($this->code),
            "message" => $this->message,
            'tracking_code' => $this->tracking_code
        );
    }

}