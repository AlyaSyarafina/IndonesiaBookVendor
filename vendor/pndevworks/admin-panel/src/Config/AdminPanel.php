<?php

namespace PNDevworks\AdminPanel\Config;

use CodeIgniter\Config\BaseConfig;

class AdminPanel extends BaseConfig
{
    public $admin_groups = [];

    public $admin_tables = [
        'users' => [
            'label' => 'Users',
            'allow' => ['create', 'update', 'delete'],
            'index' => [
                'cols' => ['id', 'email', 'first_name'],
                'order_by' => ['email', 'ASC'],
                'search' => ['enabled' => true, 'searchable_column' => ['email', 'first_name', 'last_name']]
            ],
            'create' => [
                'first_name' => ['type' => 'text'],
                'last_name' => ['type' => 'text'],
                'email' => ['type' => 'email'],
                'password' => ['type' => 'password'],
            ],
            'update' => [
                'first_name' => ['type' => 'text'],
                'last_name' => ['type' => 'text'],
                'email' => ['type' => 'email'],
                'password' => ['type' => 'password', 'scope' => 'all'],
                'admin_extras' => [
                    'images' => [
                        'images' => [
                            'allowed_types' => 'jpg',
                            'target_extension' => 'jpg',
                            'max_count' => 5
                        ],
                        'autoconvert' => [
                            'enable' => true
                        ]
                    ]
                ]
            ]
        ]
    ];

    public $fieldDefaultOptions = [
        "html" => [
            "options" => [
                "relative_urls" => false,
                "remove_script_host" => false,
                "convert_urls" => false,
                "plugins" => 'paste code link table lists charmap',
                "height" => 300,
                "charmap_append" => [0x0176, 'degree']
            ]
        ],
        "file:image" => [
            // @link
            // https://gitlab.com/PNDevworks/ApriliaV3/-/issues/10#note_771446927
            "autoconvert" => [

                /**
                 * Disables the autoconvert script
                 */
                "enable" => false,

                /**
                 * Sets the sizing available for the convert engine to run to.
                 *
                 * Possible values:
                 * - orig → original size (original image will still be
                 *   converted to various formats, defined on the `formats` section)
                 * - [number]s, [number]w, [number]h. This will resize the images
                 *   to [number] with the following strategy:
                 *   - s (as in square), will make sure image **contained** within that square.
                 *   - w (as in width), will make sure the width is [number] and height adjusted to that aspect ratio.
                 *   - h (as in height), will make sure the height is [number] and width adjusted.
                 */
                "sizes" => ["orig", "500w", "1024w", "1920w"],

                /**
                 * Format that this autoconvert runs with.
                 */
                "formats" => [IMAGETYPE_JPEG, IMAGETYPE_WEBP],

                /**
                 * Engine that are being used to process the image.
                 * 
                 * Possible values:
                 *  - handlers name from {@see /Config/Image::$handlers}.
                 *  - null, to use default value set on your project.
                 */
                "engine" => null,

                /**
                 * Add random string to the generated filename for the converted
                 * file. Useful for privacy-first content that need to be
                 * somewhat hard-to-guess filename.
                 *
                 * Each size will have their name randomized.
                 *
                 * Warn: You'll defenitely want to use the Imagelib.
                 */
                "filenameRandomize" => false
            ]
        ]
    ];

    public $brandingOptions = [
        "site-title" => "Admin Page",
        "logo" => "will-be-replaced-on-constructor",
        "footer" => "",
        "navbarUseLogo" => false
    ];


    /**
     * In debug environment (set via CI_ENVIRONMENT sysvar), forward all
     * uncatched exceptions to Framework instead of showing little flash
     * mesages.
     * 
     * Defaults to true.
     *
     * @var boolean
     */
    public $debugForwardExceptionToFramework = true;

    /**
     * Enable filtering by multiple file (mime) types. E.g. PNG and JPG.
     * Previously only one type possible.
     * 
     * Default to false.
     * 
     * @link https://gitlab.com/PNDevworks/deps/admin-panel/-/issues/25
     *
     * @var boolean
     */
    public $fileUploadAllowMultipleMimeTypes = false;
}
