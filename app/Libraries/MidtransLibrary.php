<?php

namespace App\Libraries;

use Config\Midtrans as MidtransConfig;

class MidtransLibrary
{
    private $serverKey;
    private $clientKey;
    private $isProduction;
    private $isSanitized;
    private $is3ds;

    public function __construct()
    {
        $config = new MidtransConfig();
        
        $this->serverKey = $config->serverKey;
        $this->clientKey = $config->clientKey;
        $this->isProduction = $config->isProduction;
        $this->isSanitized = $config->isSanitized;
        $this->is3ds = $config->is3ds;

        // Set Midtrans configuration
        \Midtrans\Config::$serverKey = $this->serverKey;
        \Midtrans\Config::$isProduction = $this->isProduction;
        \Midtrans\Config::$isSanitized = $this->isSanitized;
        \Midtrans\Config::$is3ds = $this->is3ds;
    }

    public function createTransaction($params)
    {
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return [
                'success' => true,
                'snap_token' => $snapToken,
                'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getTransactionStatus($orderId)
    {
        try {
            $status = \Midtrans\Transaction::status($orderId);
            return [
                'success' => true,
                'data' => $status
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function verifySignature($orderId, $statusCode, $grossAmount, $serverKey)
    {
        $mySignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        return $mySignature;
    }

    public function getClientKey()
    {
        return $this->clientKey;
    }
}
