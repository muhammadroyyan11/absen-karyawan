<?php
namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkScheduleTemplateExport implements FromArray, WithHeadings
{
    protected $week;

    public function __construct($week)
    {
        $this->week = $week;
    }

    public function headings(): array
    {
        $dates = $this->getWeekDates();
        $dateColumns = array_map(function ($date) {
            return Carbon::parse($date)->format('d M');
        }, $dates);

        return array_merge(['NIK', 'NAMA'], $dateColumns);
    }

    public function array(): array
    {
        $dates = $this->getWeekDates();

        // Ambil user bawahan leader departemen
        $users = User::with('department')
            ->whereHas('department', function ($q) {
                $q->where('leader_id', auth()->id());
            })
            ->get();

        $rows = [];

        foreach ($users as $user) {
            $row = [
                $user->nik,
                $user->name,
            ];

            foreach ($dates as $date) {
                $row[] = '';
            }

            $rows[] = $row;
        }

        return $rows;
    }

    private function getWeekDates(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $weekStart = $startOfMonth->copy()->addWeeks($this->week - 1)->startOfWeek(Carbon::MONDAY);
        $weekDates = [];

        for ($i = 0; $i < 7; $i++) {
            $weekDates[] = $weekStart->copy()->addDays($i)->toDateString();
        }

        return $weekDates;
    }
}
