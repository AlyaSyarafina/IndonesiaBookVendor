<?php

namespace PNDevworks\AdminPanel\Controllers;

use CodeIgniter\Files\Exceptions\FileNotFoundException;
use InvalidArgumentException;

class AdminAssetServe extends BaseController
{
    /**
     * Serve files from `public` path of this admin page.
     * 
     * Adopted from {@link \CodeIgniter\HTTP\DownloadResponse}
     *
     * @param string $path
     * @return void
     */
    public function get_serve(...$path)
    {
        try {
            $thePath = join(DIRECTORY_SEPARATOR, $path);
            // Path shall not starts with `.`
            if (substr($thePath, 0, 1) === '.') {
                throw new InvalidArgumentException("File contains restricted character");
            }

            // Path shall not include `../`.
            if (strpos($thePath, "../") !== false) {
                throw new InvalidArgumentException("File contains restricted character");
            }

            // Path shall not ends with `.php`.
            if (substr($thePath, -4) === ".php") {
                throw new InvalidArgumentException("File contains restricted character");
            }

            $fullpath = join(DIRECTORY_SEPARATOR, [__DIR__, "..", "..", "public", $thePath]);
            $file = new \CodeIgniter\Files\File($fullpath, true);
            $this->response->setLastModified($file->getMTime());

            if (substr($thePath, -4) === ".css") {
                $this->response->setContentType('text/css');
            } else if (substr($thePath, -3) === ".js") {
                $this->response->setContentType("application/x-javascript");
            } else {
                $this->response->setContentType($file->getMimeType());
            }

            $this->response->setHeader('Content-Transfer-Encoding', 'binary');
            $this->response->setHeader('Content-Length$', $file->getSize());

            $splFileObject = $file->openFile('rb');
            // Flush 1MB chunks of data
            while (!$splFileObject->eof() && ($data = $splFileObject->fread(1048576)) !== false) {
                echo $data;
            }
            return $this->response;
        } catch (FileNotFoundException | InvalidArgumentException $e) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
