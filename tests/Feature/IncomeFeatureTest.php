<?php

namespace Tests\Feature;

use App\Models\Income;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IncomeFeatureTest extends TestCase
{
    use WithFaker;//, RefreshDatabase;

    private function randomCurrency()
    {
        $currencies = ['USD', 'GBP', 'PKR', 'AED', 'CAD', 'EUR'];

        return $currencies[array_rand($currencies)];
    } 

    public function test_it_can_create_income(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson(route('incomes.store'), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => $this->randomCurrency(),
            'user_id' => User::pluck('id')->random(),
        ]);

        $response->assertCreated();
        $response->assertJsonPath('message', 'Income successfully added');
    }

    public function test_invalid_amount(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson(route('incomes.store'), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->word(),
            'currency' => $this->randomCurrency(),
            'user_id' => User::pluck('id')->random(),
        ]);

        $response->assertUnprocessable();
    }
    
    public function test_invalid_user_id(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson(route('incomes.store'), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => $this->randomCurrency(),
            'user_id' => rand(1000, 2000),
        ]);

        $response->assertUnprocessable();
    }

    public function test_invalid_currency(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson(route('incomes.store'), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => 'CHI',
            'user_id' => User::pluck('id')->random(),
        ]);

        $response->assertUnprocessable();
    }

    public function test_it_can_update_income(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson(route('incomes.store'), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => $this->randomCurrency(),
            'user_id' => User::pluck('id')->random(),
        ]);

        $income = Income::inRandomOrder()->first();
        $response = $this->putJson(route('incomes.update', $income), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => $this->randomCurrency(),
            'user_id' => User::pluck('id')->random(),
        ]);

        $response->assertOk();
    }
    
    public function test_it_can_delete_income()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $createResponse = $this->postJson(route('incomes.store'), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => $this->randomCurrency(),
            'user_id' => User::pluck('id')->random(),
        ]);

        $createResponse->assertCreated();
        
        $income = $createResponse->assertJsonStructure(['income'])->json();

        $id = $income['income']['id'];

        $deleteResponse = $this->delete(route('incomes.destroy', $id));

        $deleteResponse->assertOk();
        $deleteResponse->assertJsonPath('message', 'Income successfully deleted');
    }
}
