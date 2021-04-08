<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TentType;
use App\Models\Manufacturer;

class Tent extends Model
{
    use HasFactory;

    protected $table = 'tent';
    
    protected $primaryKey = 'PK_Tent';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Price',
        'Name',
        'BerthsNumber',
        'MinimizedDimensions',
        'MaximizedDimensions',
        'MinTemperature',
        'MaxTemperature',
        'Amount',
        'Weight',
        'ImgPath',
        'Description',
        'ShortDescription',
        'PK_TentType',
        'PK_Manufacturer',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function tentType()
    {
        return $this->belongsTo(TentType::class, 'PK_TentType', 'PK_TentType');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'PK_Manufacturer', 'PK_Manufacturer');
    }
}
