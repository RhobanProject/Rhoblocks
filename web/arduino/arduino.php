<?php

require 'Arduino.php';

$configFile = __DIR__.'/config.php';

if (!file_exists($configFile)) {
    throw new \RuntimeException('No config file');
}

$config = include($configFile);

if (!$config || !isset($config['enabled']) || !$config['enabled']) {
    throw new \RuntimeException('Arduino is disabled');
}

return new Arduino($config);
