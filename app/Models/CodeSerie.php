<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class CodeSerie extends Model
{
    protected $fillable = [
        'code',
        'series',
    ];

    /**
     * makeCode function
     *
     * @param object $model
     * @return void
     */
    public function makeCode(object $model)
    {
        $codes = [
            'inventory' => 'IVT',
            'import' => 'IMP',
            'product' => 'PRO',
            'customer' => 'CUS',
            'project' => 'PRJ',
            'supplierorder' => 'SOR'
        ];

        $prefix = null;
        $basename = strtolower(class_basename($model));
        if (array_key_exists($basename, $codes)) {
            $prefix = $codes[$basename];
        } else {
            $prefix = strtoupper($basename);
        }

        DB::beginTransaction();

        try {
            $serie = $this->whereCode($prefix)->first();
            if (! $serie) {
                $serie = $this::create([
                    'code' => $prefix,
                    'series' => 0,
                ]);
            }

            $number = $serie->series + 1;
            if ($number < 10) {
                $str = '0000' . $number;
            } elseif ($number < 100) {
                $str = '000' . $number;
            } elseif ($number < 1000) {
                $str = '00' . $number;
            } elseif ($number < 10000) {
                $str = '0' . $number;
            } elseif ($number < 100000) {
                $str = $number;
            }

            $serie->series = $number;
            $serie->save();

            DB::commit();

            return $prefix . '-' . $str;
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }
}
