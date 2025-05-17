<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Shifts;
use App\Models\WorkSchedule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class WorkScheduleImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Baris pertama header
        $headers = $rows->first();
        // Mulai dari baris ke-2
        foreach ($rows->skip(1) as $row) {
            $nik = $row[0]; // kolom NIK
            $user = User::where('nik', $nik)->first();

            if (!$user) {
                continue;
            }

            for ($col = 2; $col < count($row); $col++) {
                $shiftName = trim($row[$col]);
                if (empty($shiftName)) {
                    continue;
                }

                $dateString = $headers[$col];
                try {
                    $date = Carbon::parse($dateString)->format('Y-m-d');
                } catch (\Exception $e) {
                    continue;
                }

                $shift = Shifts::where('name_shift', $shiftName)->first();
                if (!$shift) {
                    continue;
                }

                WorkSchedule::updateOrCreate(
                    ['user_id' => $user->id, 'date' => $date],
                    ['shift_id' => $shift->id]
                );
            }
        }
    }
}
