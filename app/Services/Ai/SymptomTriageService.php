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
                'keywords' => [
                    // English
                    'chest pain', 'heart attack', 'cannot breathe', 'unconscious', 'stroke', 'severe bleeding', 
                    'difficulty breathing', 'shortness of breath', 'severe headache', 'loss of consciousness',
                    'severe injury', 'poisoning', 'overdose', 'choking', 'severe allergic',
                    // Arabic
                    'ألم شديد في الصدر', 'نزيف شديد', 'فقدان وعي', 'سكتة', 'اختناق', 'صعوبة في التنفس',
                    'عدم القدرة على التنفس', 'ألم شديد جداً', 'حادث', 'إصابة خطيرة', 'تسمم', 'جرعة زائدة',
                    'حساسية شديدة', 'ضيق التنفس', 'ألم حاد في الرأس', 'نزيف حاد'
                ],
                'department' => 'Emergency / الطوارئ',
                'urgency' => 'critical',
            ],
            'pediatrics' => [
                'keywords' => [
                    // English
                    'child', 'baby', 'infant', 'fever child', 'toddler', 'newborn', 'children', 'kids',
                    // Arabic
                    'طفل', 'رضيع', 'أطفال', 'طفلة', 'حمى عند الطفل', 'الأطفال', 'صغير'
                ],
                'department' => 'Pediatrics / الأطفال',
                'urgency' => 'medium',
            ],
            'obgyn' => [
                'keywords' => [
                    // English
                    'pregnancy', 'pregnant', 'menstrual', 'obgyn', 'obstetrics', 'gynecology', 'delivery', 'labor',
                    'miscarriage', 'abortion', 'contraception', 'women health',
                    // Arabic
                    'حمل', 'حامل', 'نساء', 'ولادة', 'حيض', 'دورة شهرية', 'إجهاض', 'نزيف الحمل',
                    'الحمل', 'طبيب نساء', 'توليد', 'أمومة', 'حمل خارج الرحم'
                ],
                'department' => 'Obstetrics & Gynecology / نساء وتوليد',
                'urgency' => 'medium',
            ],
            'dental' => [
                'keywords' => [
                    // English
                    'tooth', 'teeth', 'dental', 'gum', 'cavity', 'toothache', 'root canal', 'extraction',
                    'braces', 'orthodontic', 'tooth pain', 'mouth pain',
                    // Arabic
                    'سن', 'أسنان', 'لثة', 'ألم الأسنان', 'تسوس', 'خراج', 'تنظيف أسنان',
                    'تقويم أسنان', 'خلع سن', 'ألم الفك', 'التهاب اللثة'
                ],
                'department' => 'Dental / الأسنان',
                'urgency' => 'low',
            ],
            'surgery' => [
                'keywords' => [
                    // English
                    'surgery', 'post-op', 'wound', 'surgical', 'operation', 'appendix', 'hernia', 'fracture',
                    'broken bone', 'laceration', 'sutures', 'post-surgical',
                    // Arabic
                    'جراحة', 'جراح', 'عملية جراحية', 'كسر', 'عظم مكسور', 'جرح', 'خياطة',
                    'ما بعد الجراحة', 'فتق', 'الزائدة الدودية', 'تمزق'
                ],
                'department' => 'Surgery / الجراحة',
                'urgency' => 'high',
            ],
            'cardiology' => [
                'keywords' => [
                    // English
                    'heart', 'cardiac', 'arrhythmia', 'hypertension', 'blood pressure', 'palpitation',
                    'angina', 'heart disease', 'heart condition', 'valve',
                    // Arabic
                    'قلب', 'ضربات القلب', 'ارتفاع ضغط الدم', 'انخفاض ضغط الدم', 'خفقان',
                    'مرض القلب', 'أمراض القلب', 'جلطة', 'ذبحة صدرية'
                ],
                'department' => 'Cardiology / أمراض القلب',
                'urgency' => 'high',
            ],
            'orthopedics' => [
                'keywords' => [
                    // English
                    'bone', 'joint', 'arthritis', 'osteoporosis', 'sprain', 'strain', 'tendon', 'ligament',
                    'back pain', 'neck pain', 'shoulder', 'knee', 'ankle', 'orthopedic',
                    // Arabic
                    'عظم', 'مفصل', 'التهاب المفاصل', 'ألم الظهر', 'ألم الرقبة', 'كتف',
                    'ركبة', 'كاحل', 'التواء', 'شد عضلي', 'هشاشة العظام'
                ],
                'department' => 'Orthopedics / العظام',
                'urgency' => 'medium',
            ],
            'neurology' => [
                'keywords' => [
                    // English
                    'headache', 'migraine', 'seizure', 'epilepsy', 'dizziness', 'vertigo', 'neurological',
                    'nerve', 'tremor', 'numbness', 'tingling', 'paralysis', 'brain',
                    // Arabic
                    'صداع', 'شقيقة', 'دوخة', 'دوار', 'تشنج', 'صرع', 'عصب',
                    'تنميل', 'وخز', 'شلل', 'مرض الأعصاب', 'دماغ'
                ],
                'department' => 'Neurology / الأعصاب',
                'urgency' => 'high',
            ],
            'dermatology' => [
                'keywords' => [
                    // English
                    'skin', 'rash', 'acne', 'eczema', 'psoriasis', 'dermatitis', 'mole', 'wart',
                    'allergy', 'itching', 'burn', 'wound', 'skin condition', 'dermatology',
                    // Arabic
                    'جلد', 'طفح', 'حب الشباب', 'إكزيما', 'حساسية جلدية', 'حكة',
                    'حروق', 'ثآليل', 'شامة', 'التهاب الجلد', 'أمراض جلدية'
                ],
                'department' => 'Dermatology / الجلدية',
                'urgency' => 'low',
            ],
            'gastroenterology' => [
                'keywords' => [
                    // English
                    'stomach', 'abdominal', 'diarrhea', 'constipation', 'nausea', 'vomiting', 'acid reflux',
                    'ulcer', 'gastritis', 'hepatitis', 'liver', 'digestive', 'intestinal',
                    // Arabic
                    'معدة', 'ألم البطن', 'إسهال', 'إمساك', 'غثيان', 'قيء', 'ارتجاع حمضي',
                    'قرحة', 'التهاب المعدة', 'التهاب الكبد', 'كبد', 'جهاز هضمي'
                ],
                'department' => 'Gastroenterology / الجهاز الهضمي',
                'urgency' => 'medium',
            ],
            'respiratory' => [
                'keywords' => [
                    // English
                    'cough', 'cold', 'flu', 'asthma', 'bronchitis', 'pneumonia', 'respiratory', 'lung',
                    'throat', 'sore throat', 'congestion', 'phlegm', 'wheezing', 'tuberculosis',
                    // Arabic
                    'سعال', 'برد', 'إنفلونزا', 'ربو', 'التهاب الشعب الهوائية', 'ذات الرئة',
                    'رئة', 'حلق', 'التهاب الحلق', 'احتقان', 'بلغم', 'صفير', 'سل'
                ],
                'department' => 'Respiratory / الجهاز التنفسي',
                'urgency' => 'medium',
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
                        'note' => 'تم تحليل أعراضك بنجاح. يرجى التوجه للقسم المقترح أعلاه لتلقي الرعاية المناسبة. هذا التحليل استرشادي فقط ولا يغني عن استشارة الطبيب.',
                    ];
                }
            }
        }

        $firstDept = Department::query()->orderBy('id')->value('name');

        return [
            'matched_rule' => 'general',
            'suggested_department_name' => $firstDept ? 'الطب العام — '.$firstDept : 'الطب العام',
            'urgency' => 'low',
            'urgency_label' => $this->urgencyLabel('low'),
            'note' => 'لم يتم تحديد تخصص محدد بناءً على أعراضك. يُنصح بزيارة قسم الطب العام للفحص الأولي والتوجيه للتخصص المناسب.',
        ];
    }

    protected function urgencyLabel(string $urgency): string
    {
        return match ($urgency) {
            'critical' => 'حرج جداً - توجه للطوارئ فوراً',
            'high' => 'عالي - يحتاج متابعة سريعة',
            'medium' => 'متوسط - حدد موعد قريب',
            default => 'منخفض - يمكن تحديد موعد عادي',
        };
    }
}
