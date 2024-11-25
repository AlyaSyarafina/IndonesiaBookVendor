<?php

namespace Tests\Unit\Entities;

use PHPUnit\Framework\TestCase;
use PNDevworks\AdminPanel\Entities\UserEntities;

/**
 * User Entities Password Test
 * 
 * @group authentication
 * @group entities
 */
class UserEntitiesPasswordTest extends TestCase
{
    /** 
     * @test
     * @testdox  Password generation should follow authentication configuration.
     */
    public function passwordShouldFollowConfigTest()
    {
        $config = config('Authentication');
        $config->passwordAlgorithm = PASSWORD_BCRYPT;

        $entity = new UserEntities();

        $entity->setPassword("super-secret-password");
        $passInfo = password_get_info($entity->password);
        $this->assertEquals(PASSWORD_BCRYPT, $passInfo['algo']);

        // ---
        $config->passwordAlgorithm = PASSWORD_ARGON2ID;
        $entity->setPassword("super-secret-password");
        $passInfo = password_get_info($entity->password);
        $this->assertEquals(PASSWORD_ARGON2ID, $passInfo['algo']);
    }

    /** 
     * @test
     * @testdox  Password hash with other (supported) hash algorithm should be
     * verifyable too
     */
    public function otherHashAlgorithmShouldStillCompatibleTest()
    {
        $config = config('Authentication');
        $config->passwordAlgorithm = PASSWORD_ARGON2ID;

        $entity = new UserEntities();

        $entityBinder = function () {
            $this->attributes['password'] = password_hash("super-secret-password", PASSWORD_BCRYPT);
        };
        $entityBinder = $entityBinder->bindTo($entity, UserEntities::class);
        $entityBinder();

        $this->assertTrue($entity->verifyPassword('super-secret-password'));
        $this->assertFalse($entity->verifyPassword('super-wrong-password'));
    }

    /** 
     * @test
     * @testdox  Blank password hash should not be 
     */
    public function blankPasswordFieldShouldNotCauseErrorsTest()
    {
        $entity = new UserEntities();
        $entityBinder = function () {
            $this->attributes['password'] = null;
        };
        $entityBinder = $entityBinder->bindTo($entity, UserEntities::class);
        $entityBinder();

        $this->assertFalse($entity->verifyPassword('super-secret-password'));
        $this->assertFalse($entity->verifyPassword('super-wrong-password'));
        $this->assertFalse($entity->verifyPassword(''));

        $entityBinder = function () {
            $this->attributes['password'] = "";
        };
        $entityBinder = $entityBinder->bindTo($entity, UserEntities::class);
        $entityBinder();
        $this->assertFalse($entity->verifyPassword('super-secret-password'));
        $this->assertFalse($entity->verifyPassword('super-wrong-password'));
        $this->assertFalse($entity->verifyPassword(''));
    }
}
