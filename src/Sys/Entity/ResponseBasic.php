<?php
namespace App\Sys\Entity;


use App\Sys\SysMsg;

class ResponseBasic implements \JsonSerializable
{
    public $status;
    public $message;

    public function __construct($message = "", $status=null)
    {
        $this->status = empty($status)?SysMsg::SYS_STATUS_SUCCESS:$status;
        $this->message = $message;
    }

    public function jsonSerialize()
    {
        return array(
            'status'=>$this->status,
            'message'=> $this->message
        );
    }

    public function __toString()
    {
        return json_encode($this);
    }
}