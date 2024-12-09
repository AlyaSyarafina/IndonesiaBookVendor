<?php

namespace Tests\Unit\Helpers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Test\CIUnitTestCase;
use InvalidArgumentException;
use RuntimeException;
use UnexpectedValueException;

use function PNDevworks\AdminPanel\Helpers\adminDebugAutoForwardException;
use function PNDevworks\AdminPanel\Helpers\isExceptionForwardable;

/**
 * AdminDebugHelperTest
 * @group helpers
 */
class AdminDebugHelperTest extends CIUnitTestCase
{
    protected $pastENV = null;

    protected function setUp(): void
    {
        parent::setUp();
        helper('adminDebug_helper');
        if (key_exists('CI_ENVIRONMENT', $_ENV)) {
            $this->pastENV = $_ENV['CI_ENVIRONMENT'];
        }
    }

    protected function tearDown(): void
    {
        if (key_exists('CI_ENVIRONMENT', $_ENV)) {
            $_ENV['CI_ENVIRONMENT'] = $this->pastENV;
        } else {
            unset($_ENV['CI_ENVIRONMENT']);
        }
    }

    public function exceptionTestProvider()
    {
        return [
            'PageNotFound Exception should be forwarded' => [
                PageNotFoundException::forPageNotFound(),
                true
            ],
            'PageNotFound Exception should be forwarded (method variant)' => [
                PageNotFoundException::forMethodNotFound('testMethod'),
                true
            ],
            'InvalidArgument should be forwarded' => [
                new InvalidArgumentException('Test Exception'),
                true
            ],
            'UnexpectedValueException should NOT be forwarded' => [
                new UnexpectedValueException('Test Exception 2'),
                false
            ],
            'RuntimeException should NOT be forwarded' => [
                new RuntimeException('Generic Runtime Exception'),
                false
            ],
        ];
    }

    /** 
     * @test
     * @testdox  The forwarder should be able to ignore certain exception
     * 
     * @dataProvider exceptionTestProvider
     */
    public function exceptionCheckerTest($exception, $truthy)
    {
        config('AdminPanel')->debugForwardExceptionToFramework = true;
        $_ENV['CI_ENVIRONMENT'] = 'development';
        $this->assertTrue(isExceptionForwardable($exception) == $truthy);
    }

    /** 
     * @test
     * @testdox  Exception forwarder able to throw things
     * 
     * @dataProvider exceptionTestProvider
     */
    public function exceptionThrowerTest(\Throwable $exception, $truthy)
    {
        config('AdminPanel')->debugForwardExceptionToFramework = true;
        $_ENV['CI_ENVIRONMENT'] = 'development';

        if ($truthy) {
            $this->expectException(get_class($exception));
        }

        $this->assertEmpty(adminDebugAutoForwardException($exception));
    }


    /** 
     * @test
     * @testdox  The forwarder should ignore all of the exception on Production
     * 
     * @dataProvider exceptionTestProvider
     * @depends exceptionCheckerTest
     */
    public function exceptionCheckerProdTest($exception, $truthy)
    {
        config('AdminPanel')->debugForwardExceptionToFramework = true;
        $_ENV['CI_ENVIRONMENT'] = 'production';
        $this->assertFalse(isExceptionForwardable($exception));
    }

    /** 
     * @test
     * @testdox  The forwarder should ignore all of the exception if the settings are disabled
     * 
     * @dataProvider exceptionTestProvider
     * @depends exceptionCheckerTest
     */
    public function exceptionCheckerDisabledTest($exception, $truthy)
    {
        config('AdminPanel')->debugForwardExceptionToFramework = false;
        $_ENV['CI_ENVIRONMENT'] = 'development';
        $this->assertFalse(isExceptionForwardable($exception));
    }
}
