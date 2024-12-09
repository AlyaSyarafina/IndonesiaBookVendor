<?php

namespace Tests\Unit\ImageLib;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PNDevworks\AdminPanel\Libraries\Imagelib;

/**
 * ImagelibPathDetectTest
 * @group imagelib
 */
class ImagelibPathDetectTest extends TestCase
{
    use \phpmock\phpunit\PHPMock;

    protected function setUp(): void
    {
        parent::setUp();

        config("AdminPanel")
            ->fieldDefaultOptions['file:image']['autoconvert'] = [];

        // We don't need to actually points this to a real folder folder. We'll
        // just stub the system functions so we don't have to actually do
        // anthing on the real folder.
        Imagelib::$uploadFolder = "./super/wrong/folder/";
    }


    /** 
     * @test
     * @testdox getImage function should throw exception when the folder isn't showing.
     */
    public function getImageShouldThrowExceptionIfDirIsWrong()
    {
        $isDir = $this->getFunctionMock('PNDevworks\AdminPanel\Libraries', 'is_dir');
        $isDir->expects($this->once())->willReturn(false);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("is not found.");

        Imagelib::getImages('non-existent-table', 14, true);
    }

    /** 
     * @test
     * @testdox getImage should throw unparsable random file
     */
    public function shouldIgnoreUnknownFileName()
    {
        $folderList = [
            ".",
            "..",
            "images-109824803287.orig.killuab75iprvZmRf4Kv.jpg",
            "images-22.orig.killuab75iprvZmRf4Kv.jpg",
            "random file here!.jpg",
            "images-1.500s.killuab75iprvZmRf4Kv.jpg",
            "images-1.405s.killuab75iprvZmRf4Kv.jpg",
            "images-2.405s.killuab75iprvZmRf4Kv.jpg",
            "images-3.405s.killuab75iprvZmRf4Kv.jpg",
            "images-4.405s.killuab75iprvZmRf4Kv.jpg",
            "images-14.orig.killuab75iprvZmRf4Kv.jpg",
        ];

        $expected = [
            1 => [
                [
                    "filename" => "images-1.405s.killuab75iprvZmRf4Kv.jpg",
                    "formname" => "images",
                    "size" => [
                        "name" => "405s", "size" => 405,
                        "strategy" => Imagelib::SSIZE_SQUARE,
                    ],
                    "extension" => "jpg",
                    "index" => "1",
                    "random" => "killuab75iprvZmRf4Kv",
                    "fullname" => Imagelib::$uploadFolder . "virtual-table-14/images-1.405s.killuab75iprvZmRf4Kv.jpg",
                    "path" => Imagelib::$uploadFolder . "virtual-table-14"
                ],
                [
                    "filename" => "images-1.500s.killuab75iprvZmRf4Kv.jpg",
                    "formname" => "images",
                    "size" => [
                        "name" => "500s", "size" => 500,
                        "strategy" => Imagelib::SSIZE_SQUARE,
                    ],
                    "extension" => "jpg",
                    "index" => "1",
                    "random" => "killuab75iprvZmRf4Kv",
                    "fullname" => Imagelib::$uploadFolder . "virtual-table-14/images-1.500s.killuab75iprvZmRf4Kv.jpg",
                    "path" => Imagelib::$uploadFolder . "virtual-table-14"
                ]
            ],
            2 => [[
                "filename" => "images-2.405s.killuab75iprvZmRf4Kv.jpg",
                "formname" => "images",
                "size" => [
                    "name" => "405s", "size" => 405,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "extension" => "jpg",
                "index" => "2",
                "random" => "killuab75iprvZmRf4Kv",
                "fullname" => Imagelib::$uploadFolder . "virtual-table-14/images-2.405s.killuab75iprvZmRf4Kv.jpg",
                "path" => Imagelib::$uploadFolder . "virtual-table-14"
            ]],
            3 => [[
                "filename" => "images-3.405s.killuab75iprvZmRf4Kv.jpg",
                "formname" => "images",
                "size" => [
                    "name" => "405s", "size" => 405,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "extension" => "jpg",
                "index" => "3",
                "random" => "killuab75iprvZmRf4Kv",
                "fullname" => Imagelib::$uploadFolder . "virtual-table-14/images-3.405s.killuab75iprvZmRf4Kv.jpg",
                "path" => Imagelib::$uploadFolder . "virtual-table-14"
            ]],
            4 => [[
                "filename" => "images-4.405s.killuab75iprvZmRf4Kv.jpg",
                "formname" => "images",
                "size" => [
                    "name" => "405s", "size" => 405,
                    "strategy" => Imagelib::SSIZE_SQUARE,
                ],
                "extension" => "jpg",
                "index" => "4",
                "random" => "killuab75iprvZmRf4Kv",
                "fullname" => Imagelib::$uploadFolder . "virtual-table-14/images-4.405s.killuab75iprvZmRf4Kv.jpg",
                "path" => Imagelib::$uploadFolder . "virtual-table-14"
            ]],
            14 => [[
                "filename" => "images-14.orig.killuab75iprvZmRf4Kv.jpg",
                "formname" => "images",
                "size" => [
                    "name" => "orig", "size" => null,
                    "strategy" => Imagelib::SSIZE_ORIGINAL,
                ],
                "extension" => "jpg",
                "index" => "14",
                "random" => "killuab75iprvZmRf4Kv",
                "fullname" => Imagelib::$uploadFolder . "virtual-table-14/images-14.orig.killuab75iprvZmRf4Kv.jpg",
                "path" => Imagelib::$uploadFolder . "virtual-table-14"
            ]],
            22 => [[
                "filename" => "images-22.orig.killuab75iprvZmRf4Kv.jpg",
                "formname" => "images",
                "size" => [
                    "name" => "orig", "size" => null,
                    "strategy" => Imagelib::SSIZE_ORIGINAL,
                ],
                "extension" => "jpg",
                "index" => "22",
                "random" => "killuab75iprvZmRf4Kv",
                "fullname" => Imagelib::$uploadFolder . "virtual-table-14/images-22.orig.killuab75iprvZmRf4Kv.jpg",
                "path" => Imagelib::$uploadFolder . "virtual-table-14"
            ]],
            109824803287 => [[
                "filename" => "images-109824803287.orig.killuab75iprvZmRf4Kv.jpg",
                "formname" => "images",
                "size" => [
                    "name" => "orig", "size" => null,
                    "strategy" => Imagelib::SSIZE_ORIGINAL,
                ],
                "extension" => "jpg",
                "index" => "109824803287",
                "random" => "killuab75iprvZmRf4Kv",
                "fullname" => Imagelib::$uploadFolder . "virtual-table-14/images-109824803287.orig.killuab75iprvZmRf4Kv.jpg",
                "path" => Imagelib::$uploadFolder . "virtual-table-14"
            ]],
        ];
        $isDir = $this->getFunctionMock('PNDevworks\AdminPanel\Libraries', 'is_dir');
        $isDir->expects($this->once())->willReturn(true);
        $isDir = $this->getFunctionMock('PNDevworks\AdminPanel\Libraries', 'scandir');
        $isDir->expects($this->once())->willReturn($folderList);

        $images = Imagelib::getImages('virtual-table', 14, true);
        $this->assertIsArray($images);
        $this->assertEquals($expected, $images);
    }

    /** 
     * @test
     * @testdox getImage should throw unparsable random file, even if we don't ask for info.
     */
    public function shouldIgnoreUnknownFileNameEvenIfNoInfo()
    {
        $folderList = [
            ".",
            "..",
            "images-109824803287.orig.killuab75iprvZmRf4Kv.jpg",
            "images-22.orig.killuab75iprvZmRf4Kv.jpg",
            "random file here!.jpg",
            "images-1.500s.killuab75iprvZmRf4Kv.jpg",
            "images-1.405s.killuab75iprvZmRf4Kv.jpg",
            "images-2.405s.killuab75iprvZmRf4Kv.jpg",
            "images-3.405s.killuab75iprvZmRf4Kv.jpg",
            "images-4.405s.killuab75iprvZmRf4Kv.jpg",
            "images-14.orig.killuab75iprvZmRf4Kv.jpg",
        ];

        $expected = [
            "./super/wrong/folder/virtual-table-14/images-1.405s.killuab75iprvZmRf4Kv.jpg",
            "./super/wrong/folder/virtual-table-14/images-1.500s.killuab75iprvZmRf4Kv.jpg",
            "./super/wrong/folder/virtual-table-14/images-2.405s.killuab75iprvZmRf4Kv.jpg",
            "./super/wrong/folder/virtual-table-14/images-3.405s.killuab75iprvZmRf4Kv.jpg",
            "./super/wrong/folder/virtual-table-14/images-4.405s.killuab75iprvZmRf4Kv.jpg",
            "./super/wrong/folder/virtual-table-14/images-14.orig.killuab75iprvZmRf4Kv.jpg",
            "./super/wrong/folder/virtual-table-14/images-22.orig.killuab75iprvZmRf4Kv.jpg",
            "./super/wrong/folder/virtual-table-14/images-109824803287.orig.killuab75iprvZmRf4Kv.jpg",
        ];
        $isDir = $this->getFunctionMock('PNDevworks\AdminPanel\Libraries', 'is_dir');
        $isDir->expects($this->once())->willReturn(true);
        $isDir = $this->getFunctionMock('PNDevworks\AdminPanel\Libraries', 'scandir');
        $isDir->expects($this->once())->willReturn($folderList);

        $images = Imagelib::getImages('virtual-table', 14, false);
        $this->assertIsArray($images);
        $this->assertEquals($expected, $images);
    }
}
