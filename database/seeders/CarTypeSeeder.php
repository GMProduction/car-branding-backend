<?php

namespace Database\Seeders;

use App\Models\CarType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::beginTransaction();
        try {
            $data = ['CALYA', 'SIGRA', 'AGYA', 'AYLA'];
            foreach ($data as $datum) {
                $field = [
                    'name' => $datum
                ];
                CarType::create($field);
            }
            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }

    }
}
