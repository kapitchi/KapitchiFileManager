<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiFileManager\Controller;

use Zend\Stdlib\RequestInterface as Request,
    Zend\Stdlib\ResponseInterface as Response;

class DownloaderController implements \Zend\Stdlib\DispatchableInterface
{
    protected $fileManagerService;
    protected $fileIndexService;
    
    public function dispatch(Request $request, Response $response = null)
    {
        $fm = $this->getFileManagerService();
        
        $id = $request->getQuery()->get('id');
        if(empty($id)) {
            throw new \Exception("No file path nor id defined");
        }

        $fileIndexService = $this->getFileIndexService();
        $file = $fileIndexService->find($id);
        if(!$file) {
            throw new \Exception("No file #$id");
        }
        
        $volume = $fm->getVolumeManager()->get($file->getVolumeId());
        if(!$volume instanceof \KapitchiFileManager\Volume\StreamVolumeInterface) {
            throw new \Exception("No stream volumes are not supported, yet!");
        }
        
        $response = new \Zend\Http\Response\Stream();
        $response->setStream($volume->openStream($file->getPath()));
        
        $response->getHeaders()->addHeaderLine('Content-Type', $file->getMime());
        
        $status  = $response->renderStatusLine();
        header($status);

        /** @var \Zend\Http\Header\HeaderInterface $header */
        foreach ($response->getHeaders() as $header) {
            if ($header instanceof MultipleHeaderInterface) {
                header($header->toString(), false);
                continue;
            }
            header($header->toString());
        }
        
        $str = $response->getBody();
        echo $str;
        exit;
    }
    
    /**
     * 
     * @return \KapitchiFileManager\Service\FileManager
     */
    public function getFileManagerService()
    {
        return $this->fileManagerService;
    }

    public function setFileManagerService($fileManagerService)
    {
        $this->fileManagerService = $fileManagerService;
    }

    /**
     * 
     * @return \KapitchiFileManager\Service\FileIndex
     */
    public function getFileIndexService()
    {
        return $this->fileIndexService;
    }

    public function setFileIndexService($fileIndexService)
    {
        $this->fileIndexService = $fileIndexService;
    }

}