<?php
namespace KapitchiFileManager\Volume;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
interface StreamVolumeInterface
{
    /**
     * Opens stream/resource readable (only) by fread function
     * @param string $path
     */
    public function openStream($path);
    public function closeStream($resource);
    
}