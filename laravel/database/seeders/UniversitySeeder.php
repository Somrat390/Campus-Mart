<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\University;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        $universities = [
            ['name' => 'University of Asia Pacific', 'domain' => 'uap-bd.edu'],
            ['name' => 'Dhaka University', 'domain' => 'du.ac.bd'],
            ['name' => 'BUET', 'domain' => 'buet.ac.bd'],
            ['name' => 'BRAC University', 'domain' => 'bracu.ac.bd'],
            ['name' => 'North South University', 'domain' => 'northsouth.edu'],
            ['name' => 'United International University', 'domain' => 'uiu.ac.bd'],
            ['name' => 'Daffodil International University', 'domain' => 'diu.edu.bd'],
            ['name' => 'Ahsanullah University of Science and Technology', 'domain' => 'aust.edu'],
        ];

        foreach ($universities as $uni) {
            University::updateOrCreate(
                ['domain' => $uni['domain']], // Check if domain exists
                ['name' => $uni['name']]       // If yes, update name; if no, create new
            );
        }
    }
}