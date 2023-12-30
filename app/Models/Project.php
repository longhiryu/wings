<?php

namespace App\Models;

use App\Traits\Livewire\HasChannel;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasChannel;
    
    protected $fillable = [
        'name',
        'code',
        'customer_id',
        'is_active',
        'finished',
        'tax',
        'staff_id',
        'consignee_name',
        'consignee_phone',
        'note'
    ];

    public function getTaxValue(){
        $value = $this->getProjectValue();
        
        return ($value * $this->tax / 100);
    }

    public function getProjectValue(){
        $products = ProjectProduct::where('project_id', $this->id)->get();
        $products->map(function($product){
            $product->total_price = $product->product_quantity * $product->product_price;
            return $product;
        });

        $totalValue = $products->sum('total_price');

        return $totalValue;
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function products(){
        return $this->hasMany(ProjectProduct::class, 'project_id');
    }
}
