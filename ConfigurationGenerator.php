<?php

include_once 'define.inc.php';
include_once 'helper.php';
include_once 'ApacheConfiguration.php';
include_once 'OpensslCertificate.php';

class ConfigurationGenerator
{
    const CONFIGURATION_VHOST = 0;
    const CONFIGURATION_SSL = 1;

    /**
     * @param array $domains
     * @param int   $type
     * @param bool  $ssl
     */
    public static function generate($domains, $type = ConfigurationGenerator::CONFIGURATION_SSL, $ssl = false)
    {
        switch ($type) {
            case self::CONFIGURATION_VHOST:
                ApacheConfiguration::generateVHOST($domains, $ssl);
                break;
            case self::CONFIGURATION_SSL:
                OpensslCertificate::generate($domains);
                break;
        }
    }
}

