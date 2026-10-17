<?php
// Saves an uploaded picture safely. Returns the new file name, or null if the file is not an acceptable image.
function save_image_upload(array $file, string $dir): ?string
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    if ($file['size'] > 2 * 1024 * 1024) {          // 2 MB limit
        return null;
    }
    $info = @getimagesize($file['tmp_name']);        // must really be an image
    $allowed = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG  => 'png',
        IMAGETYPE_GIF  => 'gif',
        IMAGETYPE_WEBP => 'webp',
    ];
    if (!$info || !isset($allowed[$info[2]])) {
        return null;
    }
    $name = bin2hex(random_bytes(12)) . '.' . $allowed[$info[2]];   // random name, never the visitor's file name
    if (!move_uploaded_file($file['tmp_name'], rtrim($dir, '/') . '/' . $name)) {
        return null;
    }
    return $name;
}
