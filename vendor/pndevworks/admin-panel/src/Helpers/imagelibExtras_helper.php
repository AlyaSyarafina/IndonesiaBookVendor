<?php

namespace PNDevworks\AdminPanel\Helpers;

use InvalidArgumentException;
use PNDevworks\AdminPanel\Libraries\Imagelib;

if (!function_exists('imagelibGroupByIndex')) {

    /**
     * Group Imagelib images info based on its indexes.
     *
     * @param array $images Parsed filenames with its file info
     * @return array Indexed groups of image's filename
     */
    function imagelibGroupByIndex(array $images): array
    {
        $indexes = [];
        foreach ($images as $img) {
            if (!array($img)) {
                throw new InvalidArgumentException("Image fullpath info only is unsupported.");
            }
            $indexes[$img['index']][] = $img;
        }

        return $indexes;
    }
}


if (!function_exists('imagelibRenameByIndex')) {
    /**
     * Rename Imagelib images group to certain index. Randomized part of the
     * filename will be preserved (if any).
     *
     * @param array $group a bunch of Imagelib images info
     * @param integer $to Updated index
     * @return array Updated filename and index of the group.
     *
     */
    function imagelibRenameByIndex(array &$group, int $to): array
    {
        foreach ($group as &$img) {
            if (!array($img)) {
                throw new InvalidArgumentException("Image fullpath info only is unsupported.");
            }
            $name = Imagelib::generateName(
                $img['formname'],
                $to,
                $img['size']['name'],
                $img['extension'],
                $img['random']
            );

            rename($img['fullname'], $img['path'] . "/" . ($name));
            $img['filename'] = $name;
            $img['fullname'] = $img['path'] . "/" . ($name);
            $img['index'] = $to;
        }
        return $group;
    }
}


if (!function_exists('imagelibGenerateSrcset')) {
    /**
     * Generates sourceset for <source>.
     *
     * @param array $group Grouped images for current index
     * @return array An array with mime-type as its key and srcset string as its value.
     */
    function imagelibGenerateSrcset(array $group): array
    {
        // will return 
        $sets = [];

        foreach ($group as $image) {
            $set = base_url("/" . $image['fullname']);
            if ($image['size']['strategy'] != Imagelib::SSIZE_ORIGINAL) {
                $set .=   " " . $image['size']['size'] . "w";
            }

            $sets[mime_content_type($image['fullname'])][] = $set;
        }

        // flatten the array
        $sets = array_map(
            function ($sets) {
                return join(",", $sets);
            },
            $sets
        );

        // Make sure the WebP is the first to be prioritized.
        krsort($sets);

        return $sets;
    }
}
