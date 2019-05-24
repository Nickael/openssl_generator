<?php

include_once 'ConfigurationGenerator.php';
include_once 'Domains.php';

var_dump(Domains::getInstance()->getDomains());
ConfigurationGenerator::generate(Domains::getInstance()->getDomains(), ConfigurationGenerator::CONFIGURATION_SSL);
//ConfigurationGenerator::generate(Domains::getInstance()->getDomains(), ConfigurationGenerator::CONFIGURATION_VHOST, true);
//ConfigurationGenerator::generate(Domains::getInstance()->getDomains(), ConfigurationGenerator::CONFIGURATION_VHOST, false);
