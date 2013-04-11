<?php
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