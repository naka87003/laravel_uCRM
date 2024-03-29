<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Purchase;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeSearchCustomers($query, $input = null)
    {
        if (!empty($input)) {
            if (Customer::where('name', 'like', '%' . $input . '%')
                ->orWhere('kana', 'like', '%' . $input . '%')
                ->orWhere('tel', 'like', '%' . $input . '%')->exists()
            ) {
                return $query->where('name', 'like', '%' . $input . '%')
                    ->orWhere('kana', 'like', '%' . $input . '%')
                    ->orWhere('tel', 'like', '%' . $input . '%');
            }
        }
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
