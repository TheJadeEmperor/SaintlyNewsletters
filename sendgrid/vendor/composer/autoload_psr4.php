<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'phpDocumentor\\Reflection\\' => array($vendorDir . '/phpdocumentor/reflection-common/src', $vendorDir . '/phpdocumentor/reflection-docblock/src', $vendorDir . '/phpdocumentor/type-resolver/src'),
    'Webmozart\\Assert\\' => array($vendorDir . '/webmozart/assert/src'),
    'Symfony\\Polyfill\\Ctype\\' => array($vendorDir . '/symfony/polyfill-ctype'),
    'Symfony\\Component\\Yaml\\' => array($vendorDir . '/symfony/yaml'),
    'Swaggest\\JsonDiff\\' => array($vendorDir . '/swaggest/json-diff/src'),
    'SendGrid\\Tests\\Unit\\' => array($baseDir . '/test/unit'),
    'SendGrid\\Tests\\Integration\\' => array($baseDir . '/test/integration'),
    'SendGrid\\Stats\\' => array($baseDir . '/lib/stats'),
    'SendGrid\\Mail\\' => array($baseDir . '/lib/mail'),
    'SendGrid\\Helper\\' => array($baseDir . '/lib/helper'),
    'SendGrid\\EventWebhook\\' => array($baseDir . '/lib/eventwebhook'),
    'SendGrid\\Contacts\\' => array($baseDir . '/lib/contacts'),
    'SendGrid\\' => array($vendorDir . '/sendgrid/php-http-client/lib'),
    'Prophecy\\' => array($vendorDir . '/phpspec/prophecy/src/Prophecy'),
    'Doctrine\\Instantiator\\' => array($vendorDir . '/doctrine/instantiator/src/Doctrine/Instantiator'),
    'DeepCopy\\' => array($vendorDir . '/myclabs/deep-copy/src/DeepCopy'),
);