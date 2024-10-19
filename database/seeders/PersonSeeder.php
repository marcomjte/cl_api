<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Person;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Address;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $person = Person::factory(250)
            ->has(Phone::factory()->count(fake()->randomDigit()))
            ->has(Email::factory()->count(fake()->randomDigit()))
            ->has(Address::factory()->count(fake()->randomDigit()))
            ->create();
    }
}
