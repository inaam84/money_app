<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExpenseFeatureTest extends TestCase
{
    use WithFaker;//, RefreshDatabase;

    private function randomCurrency()
    {
        $currencies = ['USD', 'GBP', 'PKR', 'AED', 'CAD', 'EUR'];

        return $currencies[array_rand($currencies)];
    } 

    public function test_it_can_create_expense(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson(route('expenses.store'), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => $this->randomCurrency(),
            'user_id' => User::pluck('id')->random(),
        ]);

        $response->assertCreated();
        $response->assertJsonPath('message', 'Expense successfully added');
    }

    public function test_invalid_amount(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson(route('expenses.store'), [
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

        $response = $this->postJson(route('expenses.store'), [
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

        $response = $this->postJson(route('expenses.store'), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => 'CHI',
            'user_id' => User::pluck('id')->random(),
        ]);

        $response->assertUnprocessable();
    }

    public function test_it_can_update_expense(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson(route('expenses.store'), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => $this->randomCurrency(),
            'user_id' => User::pluck('id')->random(),
        ]);

        $expense = Expense::inRandomOrder()->first();
        $response = $this->putJson(route('expenses.update', $expense), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => $this->randomCurrency(),
            'user_id' => User::pluck('id')->random(),
        ]);

        $response->assertOk();
    }
    
    public function test_it_can_delete_expense()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $createResponse = $this->postJson(route('expenses.store'), [
            'name' => substr($this->faker->firstName() . ' ' . $this->faker->lastName(), 0, 15),
            'amount' => $this->faker->randomFloat( rand(1, 2), 50, 1000 ),
            'currency' => $this->randomCurrency(),
            'user_id' => User::pluck('id')->random(),
        ]);

        $createResponse->assertCreated();
        
        $expense = $createResponse->assertJsonStructure(['expense'])->json();

        $id = $expense['expense']['id'];

        $deleteResponse = $this->delete(route('expenses.destroy', $id));

        $deleteResponse->assertOk();
        $deleteResponse->assertJsonPath('message', 'Expense successfully deleted');
    }
}
