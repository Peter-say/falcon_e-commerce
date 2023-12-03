<?php

namespace App\Models;

use App\Constants\CurrencyConstants;
use App\Constants\StatusConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes , SoftDeletes;
    public $table = "currencies";

    protected $fillable = [
        "name",
        "type",
        "price_per_dollar",
        "short_name",
        "logo",
        "status",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}