<?php

require __DIR__ . '/vendor/autoload.php';

use Inverse\TuyaClient\Session;
use Inverse\TuyaClient\ApiClient;
use Inverse\TuyaClient\Device\SwitchDevice;
use Inverse\TuyaCliuent\Biztype;

// Setup credentials
$username = getenv('TUYA_USERNAME');
$password = getenv('TUYA_PASSWORD');
$countryCode = getenv('TUYA_COUNTRYCODE');
$bizType = new BizType(BizType::TUYA);

// Make client
$session = new Session($username, $password, $countryCode, $bizType);
$apiClient = new ApiClient($session);

// Get all devices
$devices = $apiClient->discoverDevices();

// Switch on all switches
foreach ($devices as $device) {
    if ($device instanceOf SwitchDevice) {
        if (!$device->isOn()) {
            $apiClient->sendEvent($device->getOnEvent());
        }
    }
}
