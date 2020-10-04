<?php

namespace Database\Factories\Config;

use App\Models\Configuration\ESchoolResource;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConfigFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ESchoolResource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'TheCode' => $this->faker->unique()->name,
            'CompanyName' => $this->faker->company,
            'LogoUrl' => $this->faker->imageUrl(600,600),
            'dbHost' => 'localhost',
            'dbPort' => '3306',
            'dbName' => 'companyDB',
            'dbUsername' => 'company',
            'dbPassword' => '1234'
        ];
    }
}
