<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiFileManager\View\Helper;

use Zend\View\Helper\AbstractHelper;

class AbstractFileManager extends AbstractHelper
{
    public function __invoke()
    {
        return $this->render();
    }
    
    public function render() {
        return "Please install <a href=\"https://github.com/kapitchi/KapitchiFileManager\">KapitchiElfinder</a> module";
    }
}