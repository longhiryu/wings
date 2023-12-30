<?php

namespace App\Models;

use App\Traits\Livewire\HasChannel;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'address',
        'address_city_id',
        'address_district_id',
        'address_ward_id',
    ];

    public function showAddress($id)
    {
        $address = $this->find($id);
        if ($address) {
            return $address->address . ', ' . $address->ward->name . ', ' . $address->district->name . ', ' . $address->city->name;
        }

        return __('text.address_not_found');
    }
    
    public function checkBeforeDelete(){
        return $this->orders ? false : true;
    }

    public function orders(){
        return $this->hasMany(Order::class, 'address_id');
    }

    public function city()
    {
        return $this->belongsTo(AddressCity::class, 'address_city_id');
    }

    public function district()
    {
        return $this->belongsTo(AddressDistrict::class, 'address_district_id');
    }

    public function ward()
    {
        return $this->belongsTo(AddressWard::class, 'address_ward_id');
    }
}
