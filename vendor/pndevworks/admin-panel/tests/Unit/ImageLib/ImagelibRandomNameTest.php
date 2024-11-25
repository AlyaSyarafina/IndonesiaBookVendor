<?php

namespace Tests\Unit\ImageLib;

use PHPUnit\Framework\TestCase;
use PNDevworks\AdminPanel\Libraries\Imagelib;

use function PHPUnit\Framework\assertIsString;

/**
 * Imagelib Random Name generator Test
 * @group imagelib
 */
class ImagelibRandomNameTest extends TestCase
{
    /** 
     * @test
     * @testdox Imagelib's base64 should generate url-safe.
     */
    public function base64GenerateStringTest()
    {
        $guarateedToHaveEquals = Imagelib::base64UrlSafe(random_bytes(2));
        $this->assertIsString($guarateedToHaveEquals);
        $this->assertDoesNotMatchRegularExpression('/[\=\/\\\+]+/', $guarateedToHaveEquals);
    }
    
    /** 
     * @test
     * @testdox  Imagelib's random name should generate names that are url-safe.
     */
    public function randomNameShouldBeUrlSafeTest()
    {
        $generatedFileName = Imagelib::generateName('image', 1, '400s', 'png', true);
        $this->assertIsString($generatedFileName);
        $this->assertDoesNotMatchRegularExpression('/[\=\/\\\+]+/', $generatedFileName);
    }
}
