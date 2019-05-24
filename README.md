APACHE VHOST SSL GENERATOR
===

## Prerequisites
* PHP (5.6 - 7.3)

## Initialization

First copy the configuration file :

>cp config.inc.sample.php config.inc.php

Now updated the configuration file depending on your needs

# Running generator

Run it by entering these commands on your cli : 

> php run

This will generate all crt, public & private key files + each virtual host files with ssl encryption configured for apache by default

> php run 0

Will generate virtual hosts for apache by default

> php run 1

Will generate openssl crt, public & private key files

# Change configuration files and list of domain names

You can update an custom configuration base on the **\*.sample.\*** files.
These are the list of files you can update : 

```
> openssl.sample.conf
> vhost.sample.conf
> vhost-ssl.sample.conf
> domains.sample
> define.inc.sample.php
```
