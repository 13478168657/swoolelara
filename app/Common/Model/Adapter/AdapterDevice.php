<?php

namespace App\Common\Model\Adapter;


class AdapterDevice implements Device{

    protected $device;
    public function __construct()
    {
        $this->device = new SanxingDevice();
    }

    public function usb(){

        $this->device->usbx();
    }
}
