<?php

namespace AppBundle\Helper;

use AppBundle\Service\ImageService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageHelper
{
    public static function resize(ContainerInterface $container, $filename, $width, $height)
    {
        $dirImage = $container->getParameter('dir_image');
        $httpImage = $container->getParameter('http_image');

        if (!file_exists($dirImage . $filename) || !is_file($dirImage . $filename)) {
            return;
        }

        $info = pathinfo($filename);
        $extension = $info['extension'];

        $oldImage = $filename;
//        $newImage = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
        $newImage = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (!file_exists($dirImage . $newImage) || (filemtime($dirImage . $oldImage) > filemtime($dirImage . $newImage))) {
            $path = '';

            $directories = explode('/', dirname(str_replace('../', '', $newImage)));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!file_exists($dirImage . $path)) {
                    @mkdir($dirImage . $path, 0777);
                }
            }

            $image = new ImageService($dirImage . $oldImage);
            $image->resize($width, $height);
            $image->save($dirImage . $newImage);
        }

        return $httpImage . $newImage;
    }
}