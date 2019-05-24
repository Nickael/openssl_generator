<?php

class OpensslCertificate
{
    /**
     * @param array $domains
     */
    public static function generate($domains = [])
    {
        self::generateCSR($domains);
        self::generateSSL($domains);
    }

    /**
     * @param array $domains
     *
     * @return string
     */
    private static function generateCSR($domains = [])
    {
        $generatedDirPath = _OPENSSL_CERTIFICATE_DESTINATION_PATH_;
        if (!file_exists($generatedDirPath)) mkdir($generatedDirPath, 0755, true);
        if (!file_exists(_OPPENSSL_PATH_)) exit(_OPPENSSL_PATH_ . ' does not exist !\nPlease read the README.md');
        $content = file_get_contents(_OPPENSSL_PATH_);

        foreach ($domains as $key => $domain) {
            $file = $generatedDirPath . '/' . $domain . _DOMAIN_NAME_ . '.conf';
            $opened = fopen($file, 'w') or exit(-1);
            fwrite($opened, self::replaceConstants($content, $domain));
            fclose($opened);
        }

        e("SSL configuration files generated");
    }

    /**
     * @param $domains
     */
    private static function generateSSL($domains)
    {
        if (file_exists(_OPENSSL_CERTIFICATE_DESTINATION_PATH_)) {
            foreach ($domains as $key => $domain) {
                $confPath = _OPENSSL_CERTIFICATE_DESTINATION_PATH_ . "/" . $domain . _DOMAIN_NAME_ . ".conf";
                $crtFile = _OPENSSL_CERTIFICATE_DESTINATION_PATH_ . "/" . $domain . _DOMAIN_NAME_ . ".crt";
                $keyFile =  _OPENSSL_CERTIFICATE_DESTINATION_PATH_ . "/" . $domain . _DOMAIN_NAME_ . ".key";
                if (!file_exists($confPath)) exit($confPath . ' not found');
                $opensslExecCommand = "" . _OPENSSL_EXEC_ . " req -config $confPath -new -sha256 -newkey rsa:2048 -nodes -keyout "
                    . $keyFile . " -x509 -days 365 -out "
                    . $crtFile;
                $opensslExecCommand = ((substr(PHP_OS, 0, 3)) === 'WIN') ? str_replace("/", "\\", $opensslExecCommand) : $confPath;

                shell_exec($opensslExecCommand);

                $message = (file_exists($crtFile)) ? $domain . _DOMAIN_NAME_ . " CRT file generated" : "\e[0m\e[1;31m" . $domain . _DOMAIN_NAME_ . " CRT file not generated";
                e($message);
            }
        }
    }

    private static function replaceConstants($content, $domain = null)
    {
        $content = str_replace("__COMMON_NAME__", $domain . _DOMAIN_NAME_, $content);
        $content = str_replace("__COUNTRY_NAME__", __COUNTRY_NAME__, $content);
        $content = str_replace("__STATE_OR_PROVINCE_NAME__", __STATE_OR_PROVINCE_NAME__, $content);
        $content = str_replace("__LOCALITY_NAME__", __LOCALITY_NAME__, $content);
        $content = str_replace("__ORGANIZATION_NAME__", __ORGANIZATION_NAME__, $content);
        $content = str_replace("__EMAIL_ADDRESS__", __EMAIL_ADDRESS__, $content);

        return $content;
    }
}
