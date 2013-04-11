<?php
namespace KapitchiFileManager\Volume;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
interface VolumeInterface
{
    public function setId($id);
    public function getId();
    
    public function mount(Manager $manager);
    public function unmount(Manager $manager);
    
    public function copy($fromPath, $toPath);
    public function rename($fromPath, $toPath);
    public function remove($path);
    public function store($path, $content);
    public function read($path);
    
    /**
     * 
     * @param string $path
     * @param type $sortOrder - TODO
     * @throws NotDirectoryException - if not directory
     */
    public function ls($path, $sortOrder = null);
    
}