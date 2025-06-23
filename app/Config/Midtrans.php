<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    public string $serverKey;
    public string $clientKey;
    public bool $isProduction;
    public bool $isSanitized;
    public bool $is3ds;

    public function __construct()
    {
        parent::__construct();
        
        $this->serverKey = env('midtrans.serverKey', 'SB-Mid-server-YOUR_SERVER_KEY');
        $this->clientKey = env('midtrans.clientKey', 'SB-Mid-client-YOUR_CLIENT_KEY');
        $this->isProduction = env('midtrans.isProduction', false);
        $this->isSanitized = env('midtrans.isSanitized', true);
        $this->is3ds = env('midtrans.is3ds', true);
    }
}
