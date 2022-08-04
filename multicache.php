<?php

/*
 * @version 1.0.1.5
 * @package com_multicache
 * @copyright Copyright (C) OnlineMarketingConsultants.in 2015. All rights reserved.
 * @license GNU GENERAL PUBLIC LICENSE see LICENSE.txt - 
 * @author Wayne DSouza <consulting@OnlineMarketingConsultants.in> - http://OnlineMarketingConsultants.in
 */
// No direct access
defined('_JEXEC') or die();

class PlgUserMulticache extends JPlugin
{

    protected $app;

    protected $db;

    public function onUserLogin($user, $options = array())
    {
        
        // $app = JFactory::getApplication();
        // $token = JSession::getFormToken();
        if ($this->app->isAdmin())
        {
            Return;
        }
        $jmulticache_hash = $this->app->get('jmulticache_hash');
        $cookieName = 'jmulticache_logged_in_' . $jmulticache_hash;
        
        $cookieValue = $this->app->input->cookie->get($cookieName);
        if (! isset($cookieValue))
        {
            
            $lifetime = 10800; // we assume the person is going to be logged in for 3 hours
            $this->app->input->cookie->set($cookieName, true, time() + $lifetime, $this->app->get('cookie_path', '/'), $this->app->get('cookie_domain'), $this->app->isSSLConnection());
            
            // $cookieValue = $this->app->input->cookie->get($cookieName);
        }
    
    }

    public function onUserLogout($user, $options = array())
    {
        
        // $token = JSession::getFormToken();
        // $app = JFactory::getApplication();
        if ($this->app->isAdmin())
        {
            Return;
        }
        $jmulticache_hash = $this->app->get('jmulticache_hash');
        $cookieName = 'jmulticache_logged_in_' . $jmulticache_hash;
        $cookieValue = $this->app->input->cookie->get($cookieName);
        if (isset($cookieValue))
        {
            $this->app->input->cookie->set($cookieName, false, time() - 42000, $this->app->get('cookie_path', '/'), $this->app->get('cookie_domain'), $this->app->isSSLConnection());
            // $app->input->cookie->set($cookieName, false, time() - 42000, $app->get('cookie_path', '/'), $app->get('cookie_domain'), $app->isSSLConnection());
        }
    
    }

}