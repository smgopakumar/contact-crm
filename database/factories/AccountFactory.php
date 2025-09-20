<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        return [
            'company_name'       => $this->faker->company(),
            'representative_name' => $this->faker->name(),
            'email'              => $this->faker->unique()->companyEmail(),
            'phone'              => $this->faker->phoneNumber(),
        ];
    }
}
