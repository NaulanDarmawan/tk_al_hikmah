<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Uploader
{
    /**
     * Upload and compress image.
     * 
     * @param array $file $_FILES['input_name']
     * @param string $destinationFolder Absolute or relative path to save folder (without filename)
     * @param string $prefix Filename prefix
     * @return string|false filename on success, false on failure
     */
    public static function process($file, $destinationFolder, $prefix = 'IMG_')
    {
        try {
            // Basic $_FILES check
            if (!isset($file['error']) || is_array($file['error'])) {
                // Determine if this is a single file upload or malformed
                return false; 
            }

            if ($file['error'] !== UPLOAD_ERR_OK) {
                // Log error if needed
                return false;
            }

            // Create destination if valid
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }

            // Init Intervention Image
            $manager = new ImageManager(new Driver());
            
            // Read image
            $image = $manager->read($file['tmp_name']);

            // Resize if needed (Max width 1200px, maintain aspect ratio)
            if ($image->width() > 1200) {
                $image->scale(width: 1200);
            }

            // Generate Filename
            $ext = 'jpg'; // Force JPG for consistency and compression
            $filename = $prefix . uniqid() . '.' . $ext;
            
            // Save with 75% quality
            $image->toJpeg(75)->save($destinationFolder . '/' . $filename);

            return $filename;

        } catch (Exception $e) {
            // Handle exceptions (unsupported format, etc)
            error_log($e->getMessage());
            return false;
        }
    }
}
