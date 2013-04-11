<?php
namespace KapitchiFileManager\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class FileUrl extends AbstractHelper
{
    public function getUrl() {
        $this->getView()->url('file-manager/downloader');
    }
}