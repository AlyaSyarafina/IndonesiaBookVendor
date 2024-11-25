<?php

namespace PNDevworks\AdminPanel\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

/**
 * @property string $id User ID
 * @property string $first_name First Name
 * @property string $last_name Last Name
 * @property string $email Email
 * @property string $password Password
 * @property Time $created_at User creation date
 * @property Time $updated_at Update date
 */
class UserEntities extends Entity
{
    protected $datamap = [
        "id" => null,
        "first_name" => null,
        "last_name" => null,
        "email" => null,
        "password" => null,
        "created_at" => null,
        "deleted_at" => null,
        "updated_at" => null,
    ];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts   = [];

    /**
     * Sets the password for this user. Password cannot be blank.
     *
     * @param string $pass password string
     * 
     * @return void
     */
    public function setPassword(string $pass): void
    {
        $this->attributes['password'] = password_hash(
            $pass,
            config("Authentication")->passwordAlgorithm
        );
    }

    /**
     * Verifies the pasword entered for this user.
     *
     * @param string $pass the challenged password for this user.
     * 
     * @return boolean
     */
    public function verifyPassword(string $pass): bool
    {
        if (!$this->attributes['password']) {
            return false;
        }

        return password_verify($pass, $this->attributes['password']);
    }
}
