<?php

namespace App\Models;

use App\Notifications\CreatedExpense;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'despesa';

    protected $fillable = [
        'valor',
        'data',
        'descricao',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterUser($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public function sendCreatedExpendeNotification()
    {
        $this->user->notify(new CreatedExpense($this));
    }

}
