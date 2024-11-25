<?php

namespace Tests\Unit\ImageLib;

use PHPUnit\Framework\TestCase;
use PNDevworks\AdminPanel\Libraries\Imagelib;

/**
 * Image size calculator.
 * 
 * @group imagelib
 */
class ImagelibInternalResizerTest extends TestCase
{

    /**
     * Provides test cases for image resizing data. This will correctly display
     * test case description for all of us.
     *
     * @return void
     */
    public function imageResizeData()
    {
        // array format:
        // all size will be **height** first, then **weight**
        return [
            // Make sure the width of a image will always match `size`.
            "Wide: Perfectly in size" => [
                "size" => [100, 200],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_WIDTH,
                ],
                "expected" => [100, 200]
            ],
            "Wide: Perfect balance, oversize" => [
                "size" => [200, 400],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_WIDTH,
                ],
                "expected" => [100, 200]
            ],
            "Wide: Perfect balance, undersize" => [
                "size" => [50, 100],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_WIDTH,
                ],
                "expected" => [100, 200]
            ],
            "Wide: Imperfect Aspect Ratio, oversize" => [
                "size" => [200, 400],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_WIDTH,
                ],
                "expected" => [100, 201]
            ],
            "Wide: Imperfect Aspect Ratio, undersize" => [
                "size" => [50, 100],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_WIDTH,
                ],
                "expected" => [100, 201]
            ],
            "Tall on Wide: Perfect size" => [
                "size" => [400, 200],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_WIDTH,
                ],
                "expected" => [400, 200]
            ],
            "Tall on Wide: Perfect balance, oversize" => [
                "size" => [800, 400],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_WIDTH,
                ],
                "expected" => [400, 200]
            ],
            "Tall on Wide: Perfect balance, undersize" => [
                "size" => [100, 50],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_WIDTH,
                ],
                "expected" => [400, 200]
            ],
            "Tall on Wide: Imperfect Aspect Ratio, oversize" => [
                "size" => [600, 300],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_WIDTH,
                ],
                "expected" => [402, 201]
            ],
            "Tall on Wide: Imperfect Aspect Ratio, undersize" => [
                "size" => [100, 50],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_WIDTH,
                ],
                "expected" => [402, 201]
            ],

            
            // Make sure the height of a image will always match `size`.
            "Tall: Perfectly in size" => [
                "size" => [200, 100],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_HEIGHT,
                ],
                "expected" => [200, 100]
            ],
            "Tall: Perfect balance, oversize" => [
                "size" => [400, 200],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_HEIGHT,
                ],
                "expected" => [200, 100]
            ],
            "Tall: Perfect balance, undersize" => [
                "size" => [100, 50],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_HEIGHT,
                ],
                "expected" => [200, 100]
            ],
            "Tall: Imperfect Aspect Ratio, oversize" => [
                "size" => [400, 200],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_HEIGHT,
                ],
                "expected" => [201, 100]
            ],
            "Tall: Imperfect Aspect Ratio, undersize" => [
                "size" => [100, 50],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_HEIGHT,
                ],
                "expected" => [201, 100]
            ],
            "Wide on Tall: Perfectly sized" => [
                "size" => [200, 400],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_HEIGHT,
                ],
                "expected" => [200, 400]
            ],
            "Wide on Tall: Perfect balance, oversize" => [
                "size" => [400, 800],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_HEIGHT,
                ],
                "expected" => [200, 400]
            ],
            "Wide on Tall: Perfect balance, undersize" => [
                "size" => [50, 100],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_HEIGHT,
                ],
                "expected" => [200, 400]
            ],
            "Wide on Tall: Imperfect Aspect Ratio, oversize" => [
                "size" => [400, 800],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_HEIGHT,
                ],
                "expected" => [201, 402]
            ],
            "Wide on Tall: Imperfect Aspect Ratio, undersize" => [
                "size" => [50, 100],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_HEIGHT,
                ],
                "expected" => [201, 402]
            ],



            // Test the square strategy. It will make sure, doesn't matter how
            // tall or wide the image is, it will always be in square.
            // Another name for this are... contain, as in "contain the image in a square".
            // The square size is `size` x `size`.
            "Wide on Square: Perfectly in size" => [
                "size" => [100, 200],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [100, 200]
            ],
            "Wide on Square: Perfect balance, oversize" => [
                "size" => [200, 400],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [100, 200]
            ],
            "Wide on Square: Perfect balance, undersize" => [
                "size" => [50, 100],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [100, 200]
            ],
            "Wide on Square: Imperfect Aspect Ratio, oversize" => [
                "size" => [200, 400],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [100, 201]
            ],
            "Wide on Square: Imperfect Aspect Ratio, undersize" => [
                "size" => [50, 100],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [100, 201]
            ],
            "Tall on Square: Perfectly in size" => [
                "size" => [200, 100],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [200, 100]
            ],
            "Tall on Square: Perfect balance, oversize" => [
                "size" => [400, 200],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [200, 100]
            ],
            "Tall on Square: Perfect balance, undersize" => [
                "size" => [100, 50],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [200, 100]
            ],
            "Tall on Square: Imperfect Aspect Ratio, oversize" => [
                "size" => [400, 200],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [201, 100]
            ],
            "Tall on Square: Imperfect Aspect Ratio, undersize" => [
                "size" => [100, 50],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [201, 100]
            ],
            "Square on Square: Perfectly in size" => [
                "size" => [200, 200],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [200, 200]
            ],
            "Square on Square: Perfect balance, oversize" => [
                "size" => [400, 400],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [200, 200]
            ],
            "Square on Square: Perfect balance, undersize" => [
                "size" => [100, 100],
                "strategy" => [
                    "size" => 200,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [200, 200]
            ],
            "Square on Square: Imperfect Aspect Ratio, oversize" => [
                "size" => [375, 375],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [201, 201]
            ],
            "Square on Square: Imperfect Aspect Ratio, undersize" => [
                "size" => [11, 11],
                "strategy" => [
                    "size" => 201,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "expected" => [201, 201]
            ],
            
            // Test the original strategies.
            // Will make sure the size will be left unchanged.
            "Square on Original" => [
                "size" => [200, 200],
                "strategy" => [
                    "size" => null,
                    "strategy" => Imagelib::SSIZE_ORIGINAL,
                ],
                "expected" => [200, 200]
            ],
            "Wide on Original" => [
                "size" => [200, 400],
                "strategy" => [
                    "size" => null,
                    "strategy" => Imagelib::SSIZE_ORIGINAL,
                ],
                "expected" => [200, 400]
            ],
            "Tall on Original" => [
                "size" => [400, 200],
                "strategy" => [
                    "size" => null,
                    "strategy" => Imagelib::SSIZE_ORIGINAL,
                ],
                "expected" => [400, 200]
            ],
        ];
    }

    /** 
     * @test
     * @testdox Can properly resize image
     * 
     * @dataProvider imageResizeData
     * 
     * @bug https://gitlab.com/PNDevworks/deps/admin-panel/-/issues/19
     */
    public function imageResizeTestfunction(
        array $size,
        array $strategy,
        array $expected
    ) {
        $res = Imagelib::transformSize(
            $size[0],
            $size[1],
            $strategy
        );
        $this->assertIsInt($res['h']);
        $this->assertIsInt($res['w']);
        $this->assertEquals($expected[0], $res['h']);
        $this->assertEquals($expected[1], $res['w']);
    }
}
