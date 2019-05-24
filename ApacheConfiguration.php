<?php


class ApacheConfiguration
{
    /**
     * @param array $domains
     * @param bool  $ssl
     */
    public static function generateVHOST($domains = [], $ssl = false)
    {
        foreach ($domains as $domain) {
            if (!file_exists(_APACHE_VHOST_DESTINATION_PATH_)) {
                mkdir(_APACHE_VHOST_DESTINATION_PATH_, 0755, true);
            }

            $ssl === true ? $file = _APACHE_VHOST_DESTINATION_PATH_ . '/ssl.conf' : $file = _APACHE_VHOST_DESTINATION_PATH_ . '/redirected.conf';

            if ($ssl === true && !file_exists(_VHOST_SSL_PATH_)) exit(_VHOST_SSL_PATH_ . ' does not exist !\nPlease read the README.md');
            if ($ssl === false && !file_exists(_VHOST_PATH_)) exit(_VHOST_PATH_ . ' does not exist !\nPlease read the README.md');
            $content = ($ssl == true) ? file_get_contents(_VHOST_SSL_PATH_) : file_get_contents(_VHOST_PATH_);

            $opened = fopen($file, 'a') or exit(-1);
            fwrite($opened, self::replaceConstants($content, $domain));
            fclose($opened);

            $message = (file_exists($file)) ? $domain . _DOMAIN_NAME_ . ( $ssl ? ' SSL' : '') . " VHOST generated" : "\e[0m\e[1;31m" . $domain . _DOMAIN_NAME_ . ( $ssl ? ' SSL' : '') . " VHOST not generated";
            e($message);
        }
    }

    /**
     * @param string $content
     * @param string $domain
     *
     * @return mixed
     */
    private static function replaceConstants($content, $domain = null)
    {
        $content = str_replace("__SITE_NAME__", $domain . _DOMAIN_NAME_, $content);
        $content = str_replace("__SSL_PATH__", _SSL_PATH_, $content);
        $content = str_replace("__WEBROOT__", _WEBROOT_, $content);
        $content = str_replace("__LOG_PATH__", _LOG_PATH_, $content);

        return $content;
    }
}
