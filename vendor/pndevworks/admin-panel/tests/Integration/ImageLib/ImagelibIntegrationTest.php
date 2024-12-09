<?php

namespace Tests\Integration\ImageLib;

use PNDevworks\AdminPanel\Config\Services;
use PNDevworks\AdminPanel\Libraries\Imagelib;

/**
 * Imagelib integration test with the actual image.
 * 
 * Just to make sure things can work out of the box.
 * 
 * @group integration
 * @group imagelib
 */
class ImagelibTest extends \CodeIgniter\Test\CIUnitTestCase
{

    public $target = "kevin-canlas-e_mbJ0T0mes-unsplash.jpg";
    public $targetPath = __DIR__ . "/../../../public/assets/tests";
    public $uploadPath =  __DIR__ . "/../../../public/assets/uploads";

    public function setUp(): void
    {
        parent::setUp();

        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            $this->markTestSkipped('The GD or imagick extension is not available.');
        }

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }

        // purging default option for images.
        config("AdminPanel")
            ->fieldDefaultOptions['file:image']['autoconvert'] = [];

        Imagelib::$uploadFolder = $this->uploadPath;
    }

    /**
     * Remove folder and its content
     * 
     * @link https://www.php.net/manual/en/function.rmdir.php#110489
     *
     * @param [type] $dir
     * @return void
     */
    protected function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // remove upload folders.
        $this->delTree($this->uploadPath);
    }

    /**
     * Tests whether sometypes of engine able to transform images as expected.
     *
     * @covers \PNDevworks\AdminPanel\Libraries\Imagelib::transformImages
     * @covers \PNDevworks\AdminPanel\Libraries\Imagelib::getImages
     * 
     * @Depends \Tests\Unit\ImageLib\ImagelibPathDetectTest::getImageShouldThrowExceptionIfDirIsWrong
     * @Depends \Tests\Unit\ImageLib\ImagelibPathDetectTest::shouldIgnoreUnknownFileName
     * @Depends \Tests\Unit\ImageLib\ImagelibPathDetectTest::shouldIgnoreUnknownFileNameEvenIfNoInfo
     * 
     * @return void
     */
    public function testTransformImage()
    {
        $target = $this->targetPath . "/" . $this->target;

        $options = [
            "sizes" => ["150s", "1080s",],
            "formats" => [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP],
            "engine" => null,
            "filenameRandomize" => false
        ];

        // test GD engine without file randomize
        $options["engine"] = "gd";
        Imagelib::transformImages($target, "tests", "14", "0", $options);

        // test filenames
        $filenames = Imagelib::getImages("tests", 14)[0];
        $this->assertEquals(
            count($options['formats']) * count($options['sizes']),
            count($filenames)
        );

        // testing each image has expected values
        foreach ($filenames as $image) {
            $img = Services::image();
            $img->withFile($image['fullname']);
            $properties = $img->getFile()->getProperties(true);

            if ($image['size']['size'] == null) {
                continue;
            }

            $this->assertTrue(
                ($properties['width'] == $image['size']['size'] &&
                    $properties['height'] <= $image['size']['size']
                ) ||
                    ($properties['height'] == $image['size']['size'] &&
                        $properties['width'] <= $image['size']['size']
                    )
            );
        }
    }
}
