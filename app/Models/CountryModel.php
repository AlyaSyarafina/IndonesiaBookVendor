<?php

namespace App\Models;

use CodeIgniter\Model;

class CountryModel extends Model
{
    protected $table = 'country'; // Table name
    protected $primaryKey = 'id'; // Primary key column
    protected $allowedFields = ['name']; // Fields allowed to be mass assigned
    protected $validationRules = [
        'name' => 'required|min_length[1]|max_length[64]' // Validation rule for the country name
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'The country name is required.',
            'min_length' => 'The country name must be at least 1 character.',
            'max_length' => 'The country name can be up to 64 characters long.'
        ]
    ];

    // Fetch countries from the database
    public function getCountries()
    {
        // Find all countries from the 'country' table
        $countries = $this->findAll();

        // Return a formatted array with 'id' as key and 'name' as value for the dropdown
        return array_column($countries, 'name', 'id');
    }
}
