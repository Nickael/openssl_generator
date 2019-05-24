<?php
include_once 'define.inc.php';

class Domains
{

    /**
     * @var Domains $_instance
     */
    protected static $_instance = null;

    /**
     * @var array $domains
     */
    private $domains = [];

    private function __construct()
    {
        if (file_exists(_DOMAINS_CONTAINER_)) {
            $file = fopen('domains', 'r');
            while (! feof($file)) {
                $domain = fgets($file);
                array_push($this->domains, rtrim($domain, "\ \t\n\r\0\x0B"));
            }
            $this->domains = array_filter($this->domains);
            fclose($file);
        }
    }

    /**
     * @return Domains
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Domains();
        }

        return self::$_instance;
    }

    /**
     * @return array
     */
    public function getDomains()
    {
        return $this->domains;
    }
}
