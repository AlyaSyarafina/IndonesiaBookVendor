<?php

namespace Tests\Unit\ImageLib;

use PHPUnit\Framework\TestCase;
use PNDevworks\AdminPanel\Libraries\Imagelib;

/**
 * Imagelib name parsing test.
 * 
 * Make sure things can be parsed properly.
 * 
 * @group imagelib
 */
class ImagelibInternalParserTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        // purging default option for images.
        config("AdminPanel")
            ->fieldDefaultOptions['file:image']['autoconvert'] = [];
    }


    public function filenameDataProvider()
    {
        return [
            "Full filename with secrets, s strategy" => [
                "orig" => "images-109824803287.405s.gon3jb75iprvZmRf4Kv.jpg",
                "expected" => [
                    "filename" => "images-109824803287.405s.gon3jb75iprvZmRf4Kv.jpg",
                    "formname" => "images",
                    "size" => [
                        "name" => "405s", "size" => 405,
                        "strategy" => Imagelib::SSIZE_SQUARE
                    ],
                    "extension" => "jpg",
                    "index" => "109824803287",
                    "random" => "gon3jb75iprvZmRf4Kv",
                ],
            ],
            "Full filename with secrets, original size" => [
                "orig" => "images-109824803287.orig.killuab75iprvZmRf4Kv.jpg",
                "expected" => [
                    "filename" => "images-109824803287.orig.killuab75iprvZmRf4Kv.jpg",
                    "formname" => "images",
                    "size" => [
                        "name" => "orig", "size" => null,
                        "strategy" => Imagelib::SSIZE_ORIGINAL
                    ],
                    "extension" => "jpg",
                    "index" => "109824803287",
                    "random" => "killuab75iprvZmRf4Kv",
                ],
            ],
            "Full filename with shorter secrets, s strategy" => [
                "orig" => "images-0.800s.dQw4w9WgXcQ.jpg",
                "expected" => [
                    "filename" => "images-0.800s.dQw4w9WgXcQ.jpg",
                    "formname" => "images",
                    "size" => [
                        "name" => "800s", "size" => 800,
                        "strategy" => Imagelib::SSIZE_SQUARE
                    ],
                    "extension" => "jpg",
                    "index" => "0",
                    "random" => "dQw4w9WgXcQ",
                ],
            ],
            "Normal filename, w strategy" => [
                "orig" => "gallery-0.800w.jpeg",
                "expected" => [
                    "filename" => "gallery-0.800w.jpeg",
                    "formname" => "gallery",
                    "size" => [
                        "name" => "800w", "size" => 800,
                        "strategy" => Imagelib::SSIZE_WIDTH
                    ],
                    "extension" => "jpeg",
                    "random" => null,
                ],
            ],
            "Normal filename, h strategy" => [
                "orig" => "hero-0.400h.png",
                "expected" => [
                    "filename" => "hero-0.400h.png",
                    "formname" => "hero",
                    "size" => [
                        "name" => "400h", "size" => 400,
                        "strategy" => Imagelib::SSIZE_HEIGHT
                    ],
                    "extension" => "png",
                    "random" => null,
                ]
            ],
            "Normal filename, original size" => [
                "orig" => "hero-0.orig.png",
                "expected" => [
                    "filename" => "hero-0.orig.png",
                    "formname" => "hero",
                    "size" => [
                        "name" => "orig", "size" => null,
                        "strategy" => Imagelib::SSIZE_ORIGINAL
                    ],
                    "extension" => "png",
                    "random" => null,
                ]
            ],
        ];
    }

    /**
     * @test
     * @testdox Properly parse filename
     * 
     * @dataProvider filenameDataProvider
     * 
     * @depends testSizeParsing
     * 
     * @covers \PNDevworks\AdminPanel\Libraries\Imagelib::parseFilename
     *
     * @return void
     */
    public function testFilenameParsing(string $filename, array $expected)
    {
        $parsed = Imagelib::parseFilename($filename);
        foreach ($expected as $testKey => $expectedValue) {
            $this->assertEquals($expectedValue, $parsed[$testKey]);
        }
    }



    public function sizeDataProvider()
    {
        return [
            "800s" => ["orig" => "800s", "expected" => ["size" => 800, "strategy" => Imagelib::SSIZE_SQUARE]],
            "800w" => ["orig" => "800w", "expected" => ["size" => 800, "strategy" => Imagelib::SSIZE_WIDTH]],
            "800h" => ["orig" => "800h", "expected" => ["size" => 800, "strategy" => Imagelib::SSIZE_HEIGHT]],
            "1300h" => ["orig" => "1300h", "expected" => ["size" => 1300, "strategy" => Imagelib::SSIZE_HEIGHT]],
            "orig" => ["orig" => "orig", "expected" => ["size" => null, "strategy" => Imagelib::SSIZE_ORIGINAL]],
        ];
    }

    /**
     * @test
     * @testdox Parse size
     * 
     * @dataProvider sizeDataProvider
     * 
     * @covers \PNDevworks\AdminPanel\Libraries\Imagelib::parseSize
     * 
     * @return void
     */
    public function testSizeParsing(string $orig, array $expected)
    {
        $parsed = Imagelib::parseSize($orig);
        foreach ($expected as $testKey => $expectedValue) {
            $this->assertEquals($expectedValue, $parsed[$testKey]);
        }
    }
}
