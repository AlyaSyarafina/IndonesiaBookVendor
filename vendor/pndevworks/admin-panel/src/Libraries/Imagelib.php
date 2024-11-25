<?php

namespace PNDevworks\AdminPanel\Libraries;

use CodeIgniter\Entity\Entity;
use InvalidArgumentException;

use function PNDevworks\AdminPanel\Helpers\imagelibGroupByIndex;

class Imagelib
{

    public static $randomCharLength = 8;
    public static $jpegQuality = 80;

    const
        SSIZE_ORIGINAL = "orig",
        SSIZE_SQUARE = "s",
        SSIZE_WIDTH = "w",
        SSIZE_HEIGHT = "h";

    public static $fileExtension = [
        IMAGETYPE_BMP => "bmp",
        IMAGETYPE_JPEG => "jpg",
        IMAGETYPE_GIF => "gif",
        IMAGETYPE_JPEG2000 => "jpeg",
        IMAGETYPE_PNG => "png",
        IMAGETYPE_WEBP => "webp",
    ];

    public static $uploadFolder = "assets/uploads/";

    /**
     * Get images on upload folder, this will 
     *
     * @param string|Entity $tablename The name of the table
     * @param string|int $rowId The id of the row
     * @param string|int $withSizeInfo Should we return the size info too,
     * default is yes.
     *
     * @return array List of images, grouped by its index.
     */
    public static function getImages($tablename, $rowId, $withSizeInfo = true): array
    {
        helper('imagelibExtras_helper');
        $path = rtrim(self::$uploadFolder, "/") . "/$tablename-$rowId";

        if (!is_dir($path)) {
            throw new InvalidArgumentException("$tablename-$rowId is not found.");
        }

        $images = array_slice(scandir($path), 2);
        natsort($images);

        // parse image name
        $images = array_map(
            function ($filename) use (&$withSizeInfo, &$path) {
                try {
                    $parsedFilename = self::parseFilename($filename);
                } catch (InvalidArgumentException $e) {
                    return null;
                }
                $parsedFilename['fullname'] = $path . "/" . $filename;
                $parsedFilename['path'] = $path;
                return $parsedFilename;
            },
            $images
        );

        if ($withSizeInfo) {
            // If we want size info, we don't need to run for any of the
            // expensive array_filter, because the imagelib group by index will
            // just sort it.
            return imagelibGroupByIndex(array_filter($images));
        }

        // if we want just the list, then we need to make sure it's properly
        // filtered.
        $images = array_filter($images);
        usort(
            $images,
            function ($a, $b) {
                return $a['index'] - $b['index'];
            }
        );

        $images = array_map((fn ($obj) => $obj['fullname']), $images);
        return array_values($images);
    }

    /**
     * Parse information from filename.
     *
     * @param string $filename filename only
     * @return array
     */
    public static function parseFilename(string $filename): array
    {
        /**
         * Regex explanation:
         * - ([\w\_]+) → Form name, this is set to `images` by default
         * - (\d+) → To match image's index. (One row may have several images)
         * - (\d+[hws]|orig) → Sizing information and strategy.
         *   {@see https://gitlab.com/PNDevworks/ApriliaV3/-/issues/10#note_771446927}
         *   for more information
         * - ([\w_-~]+)\.? → Match randomized character
         * - ($|\w+$) → Match extension
         */
        $parsable = "/([\w\_]+)-(\d+).(\d+[hws]|orig).([\w_-~]+).?($|\w+$)/";
        $matches = [];

        if (preg_match($parsable, $filename, $matches) == 0) {
            throw new InvalidArgumentException("Filename $filename does not match expected pattern.");
        }
        // var_dump($matches);
        $match = $matches;

        $extension = $match[4];
        $randomString = null;
        if ($match[5]) {
            $extension = $match[5];
            $randomString = $match[4];
        }

        return [
            "filename" => $filename,
            "formname" => $match[1],
            "size" => self::parseSize($match[3]),
            "index" => $match[2],
            "extension" => $extension,
            "random" => $randomString,
        ];
    }

    /**
     * Will parse sizing number to actual number (`size`), resize strategy
     * (`strategy`), and its `name`.
     *
     * @param string $sizeStrategy The size string
     * @return array An array with `size` (int|null), `strategy` (string),
     * `name` (string)
     */
    public static function parseSize(string $sizeStrategy): array
    {
        if ($sizeStrategy === self::SSIZE_ORIGINAL) {
            return [
                "size" => null,
                "strategy" => self::SSIZE_ORIGINAL,
                "name" => $sizeStrategy
            ];
        }

        $numeric = substr($sizeStrategy, 0, -1);
        $strategy = substr($sizeStrategy, -1, 1);

        return [
            "size" => intval($numeric),
            "strategy" => $strategy,
            "name" => $sizeStrategy
        ];
    }

    /**
     * Transform the current image size with the desired target size and
     * strategy. Available strategies:
     *   - orig, original size.
     *   - s (as in square), will make sure image **contained** within that
     *     square.
     *   - w (as in width), will make sure the width is [number] and height
     *     adjusted to that aspect ratio.
     *   - h (as in height), will make sure the height is [number] and width
     *     adjusted.
     *
     * @param integer $height Original image height
     * @param integer $width Original image width
     * @param array $targetSize Key-value array with `size` as intended size for
     * the strategy, and `strategy` as the strategy.
     *
     * @return array Key-value array with `w` as final width, and `h` as height.
     */
    public static function transformSize(int $height, int $width, array $targetSize): array
    {
        $finalSize = [
            'w' => $width,
            'h' => $height,
        ];

        if ($targetSize['strategy'] == self::SSIZE_SQUARE) {
            if ($width > $height) {
                // image is landscape, make sure we fit the image in a
                // square
                $targetSize['strategy'] = self::SSIZE_WIDTH;
            } else {
                $targetSize['strategy'] = self::SSIZE_HEIGHT;
            }
        }

        if ($targetSize['strategy'] == self::SSIZE_WIDTH) {
            // Set width = final size, and height adjusted.
            $finalSize['w'] = $targetSize['size'];
            $finalSize['h'] = $height / $width * $targetSize['size'];
        } else if ($targetSize['strategy'] == self::SSIZE_HEIGHT) {
            // This one is for height. Height = final size, width will follow.
            $finalSize['h'] = $targetSize['size'];
            $finalSize['w'] = $width / $height * $targetSize['size'];
        }

        // make sure it's all int all the way.
        $finalSize['h'] = intval($finalSize['h']);
        $finalSize['w'] = intval($finalSize['w']);
        return $finalSize;
    }

    /**
     * Transforms image to several files. This will load default option from
     * {@see Config/AdminPanel} then apply settings from $options.
     *
     *
     * @param string $originFile
     * @param string $tablename
     * @param string $rowId
     * @param string $imageIndex
     * @param array $options
     * @return array Filenames (in full path)
     */
    public static function transformImages(string $originFile, string $tablename, string $rowId, string $imageIndex, array $options = []): array
    {
        $config = config("AdminPanel")
            ->fieldDefaultOptions['file:image']['autoconvert'];

        // Merge default config and overrider:
        $config = array_merge($config, $options);

        $imageEngine = \Config\Services::image($config['engine']);

        $imageSource = $imageEngine->withFile($originFile);
        $properties = $imageSource->getFile()->getProperties(true);

        // prepare folder
        $path = rtrim(self::$uploadFolder, "/") . "/$tablename-$rowId";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // parse sizing
        $sizes = array_map(
            function ($size) {
                return self::parseSize($size);
            },
            $config['sizes']
        );

        $filenames = [];
        // do the actual sizing
        foreach ($sizes as $targetSize) {
            $finalSize = self::transformSize(
                $properties['height'],
                $properties['width'],
                $targetSize
            );

            foreach ($config['formats'] as $targetFormat) {
                $img = $imageEngine->withFile($originFile);

                // Make sure resource loaded.
                // Ref: https://github.com/codeigniter4/CodeIgniter4/blob/v4.1.5/tests/system/Images/GDHandlerTest.php#L399
                // what a ffing duck.
                $img->getResource();

                $img->convert($targetFormat);
                $img->resize($finalSize['w'], $finalSize['h']);

                $filename = self::generateName(
                    "images",
                    $imageIndex,
                    $targetSize['name'],
                    self::$fileExtension[$targetFormat],
                    $config['filenameRandomize']
                );

                $img->save("$path/$filename", self::$jpegQuality);
                $filenames[] = $filename;
            }
        }

        return $filenames;
    }

    /**
     * Convert things to base64, but in url-safe format.
     * 
     *
     * @param mixed $string Things to base64-ize.
     * @return void 
     */
    public static function base64UrlSafe($string)
    {
        return strtr(base64_encode($string), '+/=', '~_-');
    }


    /**
     * Generate filename from following information
     *
     * @param string $formname
     * @param integer $index
     * @param string $size size name
     * @param string $extension filename extension
     * @param string|bool $randomize Add randomized character. If value is `true`, new random character will be generated.
     * @return string
     */
    public static function generateName(string $formname, int $index, string $size, string $extension, $randomize = null): string
    {
        $fname = sprintf("%s-%s.%s", $formname, $index, $size);
        if ($randomize) {
            if ($randomize === true) {
                $randomize = self::base64UrlSafe(
                    bin2hex(
                        random_bytes(self::$randomCharLength)
                    )
                );
            }

            $fname .= ".$randomize";
        }

        $fname .= ".$extension";
        return $fname;
    }
}
