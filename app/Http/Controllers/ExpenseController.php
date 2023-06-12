<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Expense::class, null, [
            'except' => ['store', 'destroy', 'index', 'show', 'update']
        ]);
    }

    /**
     * Mostra todas despesas ligadas ao usuário
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::filterUser()->paginate();
        return response(new ExpenseResource($expenses), 200);
    }

    /**
     * Registra uma despesa na base de dados
     *
     * @param  \App\Http\Requests\StoreExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseRequest $request)
    {
        DB::beginTransaction();
        try {
            $expense = Expense::create($request->all());
            $expense->sendCreatedExpendeNotification();
            DB::commit();
            return response(new ExpenseResource($expense), 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Mostra uma detalhes de uma despesa específica
     *
     * @param  \App\Models\Despesa  $expense
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $expense = Expense::find($id);
            return new ExpenseResource($expense);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Despesa não encontrada ' . $e], 404);
        }
    }

    /**
     * Atualiza despesa que teve id passado 
     *
     * @param  \App\Http\Requests\UpdateExpenseRequest  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpenseRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $expense = Expense::find($id);

            $expense->update($request->all());

            DB::commit();
            return response(new ExpenseResource($expense), 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Remove despesa específica
     *
     * @param  \App\Models\Despesa  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        DB::beginTransaction();
        try {
            $expense->delete();
            DB::commit();
            return response(["message" => "Despesa removida com sucesso"], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["message" => $e->getMessage()], 400);
        }
    }
}
