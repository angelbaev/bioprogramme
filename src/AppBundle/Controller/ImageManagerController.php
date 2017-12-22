<?php

namespace AppBundle\Controller;

use AppBundle\Helper\ImageHelper;
use AppBundle\Helper\Utf8Helper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ImageManagerController extends Controller
{
    /**
     * @Route("/image-manager", name="image_manager")
     */
    public function indexAction(Request $request)
    {
        $filterName = $request->get('filter_name');
        $directory = $request->get('directory');
        $target = $request->get('target');
        $thumb = $request->get('thumb');
        $page = $request->get('page', 1);

        $helper = $this->get('app.image_manager');
        $images = $helper->load($filterName, $directory, $target, $thumb, $page);

        // Parent
        $params = [];
        if (!is_null($directory)) {
            $directory = urldecode($directory);
            $pos = strrpos($directory, '/');

            if ($pos) {
                $params['directory'] = urlencode(substr($directory, 0, $pos));
            }
        }
        if (!is_null($target)) {
            $params['target'] = $target;
        }
        if (!is_null($thumb)) {
            $params['thumb'] = $thumb;
        }

        $parentUrl = $this->generateUrl(
            'image_manager',
            $params,
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        //Refresh
        $params = [];
        if (!is_null($directory)) {
            $params['directory'] = urlencode($directory);
        }
        if (!is_null($target)) {
            $params['target'] = $target;
        }
        if (!is_null($thumb)) {
            $params['thumb'] = $thumb;
        }
        $refreshUrl = $this->generateUrl(
            'image_manager',
            $params,
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return $this->render(':image_manager:index.html.twig', [
            'images' => $images,
            'total' => count($images),
            'filterName' => $filterName,
            'directory' => $directory,
            'target' => $target,
            'thumb' => $thumb,
            'page' => $page,
            'parentUrl' => $parentUrl,
            'refreshUrl' => $refreshUrl,
        ]);

    }

    /**
     * @Route("/image-manager/upload", name="image_manager_upload")
     */
    public function uploadAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $directory = $request->get('directory');
        $file = $request->files->get('file');

        return new JsonResponse($this->get('app.image_manager')->upload($file, $directory));
    }

    /**
     * @Route("/image-manager/folder", name="image_manager_folder")
     */
    public function folderAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $directory = $request->get('directory');
        $folder = $request->get('folder');

        return new JsonResponse($this->get('app.image_manager')->folder($folder, $directory));
    }

    /**
     * @Route("/image-manager/delete", name="image_manager_delete")
     */
    public function deleteAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && !$request->isMethod('POST')) {
            throw new HttpException('XMLHttpRequests/AJAX calls must be POSTed');
        }

        $path = $request->get('path');

        return new JsonResponse($this->get('app.image_manager')->delete($path));
    }
}
