<?php

namespace Tests\Unit;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\TestCase;

class ExpenseTest extends TestCase
{

    use WithoutMiddleware, DatabaseMigrations, RefreshDatabase;

    /**
     * Teste de listagem de todas despesas do usuário
     *
     * @return void
     */
    public function testIndex()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);
        Expense::factory()->count(3)->create()->toArray();

        $response = $this->getJson('/api/despesas');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    "valor",
                    "data",
                    "descricao",
                    "user_id",
                    "created_at",
                    "updated_at",
                    "user" => [
                        "id",
                        "name",
                        "email",
                        "email_verified_at",
                        "created_at",
                        "updated_at",
                    ]
                ],
            ]);
    }

    /**
     * Teste de armazenamento
     *
     * @return void
     */
    public function testStore()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $fakeExpense = Expense::factory()->create()->toArray();
        $response = $this->postJson('/api/despesa', $fakeExpense);

        $response
            ->assertStatus(200);
    }

    /**
     * Teste de atualização de despesa
     *
     * @return void
     */
    public function testUpdate()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $fakeExpense = Expense::factory()->create();
        $response = $this->putJson('/api/despesa/' . $fakeExpense->id, [...$fakeExpense->toArray(), 'valor' => 1234]);

        $response
            ->assertStatus(200);
    }

    /**
     * Teste de remoção de despesa
     *
     * @return void
     */
    public function testDestroy()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $fakeExpense = Expense::factory()->create();
        $response = $this->deleteJson('/api/despesa/' . $fakeExpense->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Despesa removida com sucesso',
            ]);
    }
}
