<?php

namespace AppBundle\Service;

use AppBundle\Helper\ImageHelper;
use AppBundle\Helper\Utf8Helper;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ImageManagerService
{
    const ROUTE = 'image_manager';
    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function load($filterName = null, $directory = null, $target = null, $thumb = null, $page = 1) {
        if (!is_null($filterName)) {
            $filterName = urldecode($filterName);
            $filterName = rtrim(str_replace(array('../', '..\\', '..', '*'), '', $filterName), '/');
        }
        if (!is_null($directory)) {
            $directory = urldecode($directory);
            $directory = rtrim($this->container->getParameter('dir_image') . 'data/' .str_replace(array('../', '..\\', '..'), '', $directory), '/');
        } else {
            $directory = $this->container->getParameter('dir_image') . 'data';
        }

        // Get directories
        $directories = glob($directory . '/' . $filterName . '*', GLOB_ONLYDIR);

        if (!$directories) {
            $directories = array();
        }

        // Get files
        $files = glob($directory . '/' . $filterName . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

        if (!$files) {
            $files = array();
        }

        // Merge directories and files
        $images = array_merge($directories, $files);

        // Get total number of files and directories
        $image_total = count($images);

        // Split the array based on current page number and max number of items per page of 10
        $images = array_splice($images, ($page - 1) * 16, 16);

        $results = [];
        foreach ($images as $image) {
            $name = str_split(basename($image), 14);

            if (is_dir($image)) {
                $params = [];

                if (!is_null($target)) {
                    $params['target'] = urldecode($target);
                }
                if (!is_null($thumb)) {
                    $params['thumb'] = urldecode($thumb);
                }

                $params['directory'] = urlencode( Utf8Helper::utf8_substr($image,  Utf8Helper::utf8_strlen($this->container->getParameter('dir_image') . 'data/')));
                $imageManagerUrl = $this->container->get('router')->generate(
                    self::ROUTE,
                    $params,
                    UrlGeneratorInterface::ABSOLUTE_URL
                );

                $results[] = array(
                    'thumb' => '',
                    'name'  => implode(' ', $name),
                    'type'  => 'directory',
                    'path'  => Utf8Helper::utf8_substr($image, Utf8Helper::utf8_strlen($this->container->getParameter('dir_image'))),
                    'href'  => $imageManagerUrl
                );
            } elseif (is_file($image)) {
                $results[] = array(
                    'thumb' => ImageHelper::resize($this->container, Utf8Helper::utf8_substr($image, Utf8Helper::utf8_strlen($this->container->getParameter('dir_image'))), 100, 100),
                    'name'  => implode(' ', $name),
                    'type'  => 'image',
                    'path'  => Utf8Helper::utf8_substr($image, Utf8Helper::utf8_strlen($this->container->getParameter('dir_image'))),
                    'href'  => $this->container->getParameter('http_image') . Utf8Helper::utf8_substr($image, Utf8Helper::utf8_strlen($this->container->getParameter('dir_image')))
                );
            }
        }

        return $results;
    }

    /**
     * Upload File
     *
     * @param      $file
     * @param null $directory
     *
     * @return array
     */
    public function upload($file, $directory = null)
    {
        $json = [];
        // Make sure we have the correct directory
        if (!is_null($directory)) {
            $directory = urldecode($directory);
            $directory = rtrim($this->container->getParameter('dir_image') . 'data/' . str_replace(array('../', '..\\', '..'), '', $directory), '/');
        } else {
            $directory = $this->container->getParameter('dir_image') . 'data';
        }

        // Check its a directory
        if (!is_dir($directory)) {
            $json['error'] = 'error_directory';
        }

        if (!$json) {
            // Sanitize the filename
            $filename = $file->getClientOriginalName();

            // Allowed file extension types
            $allowed = array(
                'jpg',
                'jpeg',
                'gif',
                'png'
            );

            if (!in_array($file->getClientOriginalExtension(), $allowed)) {
                $json['error'] = 'error_filetype';
            }

            // Allowed file mime types
            $allowed = array(
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/x-png',
                'image/gif'
            );

            if (!in_array($file->getClientMimeType(), $allowed)) {
                $json['error'] = 'error_mimetype';
            }

        }

        if (!$json) {
            $file->move($directory, $filename);
            $json['success'] = 'File is uploaded successfully.';
        }

        return $json;
    }

    /**
     * Create new folder
     *
     * @param      $folder
     * @param null $directory
     *
     * @return array
     */
    public function folder($folder, $directory = null)
    {
        $json = [];

        // Make sure we have the correct directory
        if (!is_null($directory)) {
            $directory = urldecode($directory);
            $directory = rtrim($this->container->getParameter('dir_image') . 'data/' . str_replace(array('../', '..\\', '..'), '', $directory), '/');
        } else {
            $directory = $this->container->getParameter('dir_image') . 'data';
        }

        // Check its a directory
        if (!is_dir($directory)) {
            $json['error'] = 'Invalid direcory path.';
        }

        if (!$json) {
            // Sanitize the folder name
            $folder = urldecode($folder);
            $folder = str_replace(array('../', '..\\', '..'), '', basename(html_entity_decode($folder, ENT_QUOTES, 'UTF-8')));

            // Validate the filename length
            if ((Utf8Helper::utf8_strlen($folder) < 3) || (Utf8Helper::utf8_strlen($folder) > 128)) {
                $json['error'] = 'Invalid folder name.';
            }

            // Check if directory already exists or not
            if (is_dir($directory . '/' . $folder)) {
                $json['error'] = 'Folder allready exists.';
            }
        }

        if (!$json) {
            mkdir($directory . '/' . $folder, 0777);
            chmod($directory . '/' . $folder, 0777);

            $json['success'] = 'Folder is created successfully.';
        }

        return $json;
    }

    /**
     * Delete path
     *
     * @param $path
     *
     * @return array
     */
    public function delete($path)
    {
        $json = array();

        if (!is_null($path)) {
            $paths = $path;
        } else {
            $paths = array();
        }

        // Loop through each path to run validations
        foreach ($paths as $path) {
            $path = rtrim($this->container->getParameter('dir_image') . str_replace(array('../', '..\\', '..'), '', $path), '/');

            // Check path exsists
            if ($path == $this->container->getParameter('dir_image') . 'data') {
                $json['error'] = 'Path does not exsists.';

                break;
            }
        }

        if (!$json) {
            // Loop through each path
            foreach ($paths as $path) {
                $path = rtrim($this->container->getParameter('dir_image') . str_replace(array('../', '..\\', '..'), '', $path), '/');

                // If path is just a file delete it
                if (is_file($path)) {
                    unlink($path);

                    // If path is a directory beging deleting each file and sub folder
                } elseif (is_dir($path)) {
                    $files = array();

                    // Make path into an array
                    $path = array($path . '*');

                    // While the path array is still populated keep looping through
                    while (count($path) != 0) {
                        $next = array_shift($path);

                        foreach (glob($next) as $file) {
                            // If directory add to path array
                            if (is_dir($file)) {
                                $path[] = $file . '/*';
                            }

                            // Add the file to the files to be deleted array
                            $files[] = $file;
                        }
                    }

                    // Reverse sort the file array
                    rsort($files);

                    foreach ($files as $file) {
                        // If file just delete
                        if (is_file($file)) {
                            unlink($file);

                            // If directory use the remove directory function
                        } elseif (is_dir($file)) {
                            rmdir($file);
                        }
                    }
                }
            }

            $json['success'] = 'Path is deleted successfully.';
        }

        return $json;
    }
}