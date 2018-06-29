<?php

/**
 * DframeFramework
 * Copyright (c) Sławomir Kaleta
 *
 * @license https://github.com/dframe/dframe/blob/master/LICENCE (MIT)
 */

namespace Dframe;

use Dframe\Router;
use Dframe\Router\Response;

/**
 * Core Class
 *
 * @author Sławomir Kaleta <slaszka@gmail.com>
 */
class Core
{

    public function __construct()
    {
        
        if (!defined('APP_DIR')) {
            throw new BaseException('Please Define appDir in Main config.php', 500);
        }

        if (!defined('SALT')) {
            throw new BaseException('Please Define SALT in Main config.php', 500);
        }

        $this->baseClass = empty($bootstrap) ? new \Bootstrap() : $bootstrap;
        
        foreach ($this->baseClass->providers['core'] ?? [] as $key => $value) {
            $this->$key = new $value($this);
        }

        foreach ($this->baseClass->providers['baseClass'] ?? [] as $key => $value) {
            $this->baseClass->$key = new $value($this);
        }

        foreach ($this->baseClass->providers['module'] ?? [] as $key => $value) {
            $this->$key = new $value($this);
            $this->$key->register();
            $this->$key->boot();
        }

        return $this;
    }

    public function run()
    {
        $this->router->run();
    }

}
