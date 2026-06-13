<?php

namespace App\Services\Ai;

use App\Models\Department;

/**
 * Rule-based triage for hackathon / offline demo (Arabic + English keywords).
 * Replace with OpenAI or another API when keys are available.
 */
class SymptomTriageService
{
    public function triage(string $symptoms): array
    {
        $text = mb_strtolower(trim($symptoms));

        $rules = [
            'emergency' => [
                'keywords' => ['chest pain', 'heart attack', 'cannot breathe', 'unconscious', 'stroke', 'severe bleeding', 'اختناق', 'ألم شديد في الصدر', 'نزيف شديد', 'فقدان وعي', 'سكتة'],
                'department' => 'Emergency / الطوارئ',
                'urgency' => 'critical',
            ],
            'pediatrics' => [
                'keywords' => ['child', 'baby', 'infant', 'fever child', 'طفل', 'رضيع', 'أطفال'],
                'department' => 'Pediatrics / الأطفال',
                'urgency' => 'medium',
            ],
            'obgyn' => [
                'keywords' => ['pregnancy', 'pregnant', 'menstrual', 'obgyn', 'حمل', 'حامل', 'نساء', 'ولادة'],
                'department' => 'Obstetrics & Gynecology / نساء وتوليد',
                'urgency' => 'medium',
            ],
            'dental' => [
                'keywords' => ['tooth', 'teeth', 'dental', 'gum', 'سن', 'أسنان', 'لثة'],
                'department' => 'Dental / الأسنان',
                'urgency' => 'low',
            ],
            'surgery' => [
                'keywords' => ['surgery', 'post-op', 'wound', 'جراحة', 'جراح'],
                'department' => 'Surgery / الجراحة',
                'urgency' => 'high',
            ],
        ];

        foreach ($rules as $bucket => $rule) {
            foreach ($rule['keywords'] as $kw) {
                if ($kw !== '' && str_contains($text, mb_strtolower($kw))) {
                    return [
                        'matched_rule' => $bucket,
                        'suggested_department_name' => $rule['department'],
                        'urgency' => $rule['urgency'],
                        'urgency_label' => $this->urgencyLabel($rule['urgency']),
                        'note' => __('mediflow.ai_triage_note'),
                    ];
                }
            }
        }

        $firstDept = Department::query()->orderBy('id')->value('name');

        return [
            'matched_rule' => 'general',
            'suggested_department_name' => $firstDept ? __('mediflow.general_medicine').' — '.$firstDept : __('mediflow.general_medicine'),
            'urgency' => 'low',
            'urgency_label' => $this->urgencyLabel('low'),
            'note' => __('mediflow.ai_triage_fallback'),
        ];
    }

    protected function urgencyLabel(string $urgency): string
    {
        return match ($urgency) {
            'critical' => __('mediflow.urgency_critical'),
            'high' => __('mediflow.urgency_high'),
            'medium' => __('mediflow.urgency_medium'),
            default => __('mediflow.urgency_low'),
        };
    }
}
