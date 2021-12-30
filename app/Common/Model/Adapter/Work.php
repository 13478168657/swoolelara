<?php

namespace App\Common\Model\Adapter;


class Work{

    protected $adapter;
    public function __construct(Device $device)
    {
        $this->adapter = $device;
    }

    public function task(){

        $this->adapter->usb();
    }
}
