<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerCheckMiddleware
{
    /**
     * Middleware que checka se o usuário logado é o que poderá realizar determinada ação
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $expenseId = $request->route('id');
        $expense = Expense::find($expenseId);

        if (!$expense) {
            return response()->json(['message' => 'Despesa não encontrada'], 404);
        }

        if ($expense->user_id !== Auth::id()) {
            return response()->json(['message' => 'Acesso não autorizado'], 403);
        }

        return $next($request);
    }
}
