<?php

namespace App\Services\Ai;

use App\Models\Appointment;
use App\Models\Doctor;

/**
 * Suggests less crowded slots using existing bookings (demo heuristic).
 */
class AppointmentSlotSuggestionService
{
    public function suggest(Doctor $doctor, string $dateYmd, int $maxSuggestions = 4): array
    {
        $booked = Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $dateYmd)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->map(fn ($t) => substr((string) $t, 0, 5))
            ->all();

        $slots = [];
        $start = strtotime('09:00');
        $end = strtotime('17:00');
        for ($t = $start; $t < $end; $t += 30 * 60) {
            $label = date('H:i', $t);
            $slots[] = [
                'time' => $label,
                'load' => in_array($label, $booked, true) ? 'busy' : 'free',
            ];
        }

        $free = array_values(array_filter($slots, fn ($s) => $s['load'] === 'free'));
        $busyCount = count(array_filter($slots, fn ($s) => $s['load'] === 'busy'));

        return [
            'date' => $dateYmd,
            'doctor_id' => $doctor->id,
            'recommended_times' => array_slice(array_column($free, 'time'), 0, $maxSuggestions),
            'crowding_score' => min(100, $busyCount * 15),
            'message' => __('mediflow.ai_slots_message'),
        ];
    }
}
