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
        $person = Person::factory(5000)
            ->has(Phone::factory()->count(fake()->randomDigit(2)))
            ->has(Email::factory()->count(fake()->randomDigit(3)))
            ->has(Address::factory()->count(fake()->randomDigit(4)))
            ->create();
    }
}
