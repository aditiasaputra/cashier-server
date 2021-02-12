<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            $current_prefix = Prefix::where('active', true)->first();
            $invoice->number_sequence = Transaction::where('prefix_id', $current_prefix->id)->max('number_sequence') + 1;

            $invoice->invoice_number = $current_prefix->name . '-' . str_pad(
                $invoice->number_sequence,
                6,
                '0',
                STR_PAD_LEFT
            );
        });
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
