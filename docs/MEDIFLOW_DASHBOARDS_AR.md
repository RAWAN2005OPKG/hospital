# MediFlow Gaza — ملخص شامل للوحات التحكم والمسارات

> هذا الملف يصف **ما هو مربوط فعلياً في `routes/web.php`** وما يوجد في الـ Controllers كوظائف إضافية قد تحتاج ربط مسارات لاحقاً.

---

## 1) لوحة المريض (Patient)

**الصلاحية:** `role:patient`  
**المسار الأساسي:** `/patient/dashboard`

| المسار | الوظيفة |
|--------|---------|
| `GET /patient/dashboard` | لوحة رئيسية: عدد المواعيد القادمة (معلّقة + مؤكدة)، عدد السجلات الطبية، إجمالي المواعيد، قائمة بأقرب 5 مواعيد. |
| `GET /patient/appointments` | قائمة كل المواعيد مع ترقيم صفحات. |
| `POST /patient/appointments/{appointment}/cancel` | إلغاء موعد (إن لم يكن مكتملاً أو ملغىً). |
| `GET /patient/medical-records` | قائمة السجلات الطبية المرتبطة بـ `users.id` في جدول السجلات. |
| `GET /patient/medical-records/{record}` | تفاصيل سجل طبي واحد. |
| `GET /patient/ai/symptoms` | صفحة **توجيه الأعراض (AI تجريبي)** — إدخال نص عربي/إنجليزي. |
| `POST /patient/ai/symptoms` | إرسال الأعراض وعرض نتيجة القسم والأولوية (قواعد بسيطة للعرض التجريبي). |
| `GET /patient/ai/slot-suggestions` | **JSON**: اقتراح أوقات أقل ازدحاماً لطبيب وتاريخ (`doctor_id`, `date`). |
| `GET /appointments/create/{doctor?}` | حجز موعد: اختيار طبيب (اختياري من الرابط)، تاريخ، وقت، ملاحظات، سبب. |
| `POST /appointments` | حفظ الموعد بعد التحقق من عدم تعارض الوقت. |

**وظائف موجودة في `PatientController` لكن بدون مسارات في `web.php` حالياً** (يمكن ربطها لاحقاً):

- الوصفات (`prescriptions`)
- التقارير (`reports`, `downloadReport`)
- المحادثات (`chats`, `showChat`, `sendMessage`)
- المدفوعات (`payments`)

**ملاحظة:** الواجهة العامة: الأقسام، الأطباء، صفحة طبيب، تواصل — متاحة للجميع بدون تسجيل دخول كمريض.

---

## 2) لوحة الطبيب (Doctor)

**الصلاحية:** `role:doctor`  
**المسار الأساسي:** `/doctor/dashboard`

| المسار | الوظيفة |
|--------|---------|
| `GET /doctor/dashboard` | إحصائيات: مواعيد اليوم، مواعيد قادمة (5)، عدد مرضى لهم مواعيد مع هذا الطبيب، عدد الوصفات (من العلاقة في الموديل). |
| `GET /doctor/appointments` | جدول/قائمة المواعيد مع بيانات المريض. |
| `GET /doctor/appointments/{appointment}` | تفاصيل موعد + نموذج تقرير طبي / تأكيد / إلغاء (يستخدم نفس قالب تفاصيل الموعد). |
| `POST .../confirm` | تأكيد موعد معلّق → `confirmed`. |
| `POST .../cancel` | إلغاء مع إمكانية سبب في `notes`. |
| `POST .../medical-record` | إنشاء سجل طبي مرتبط بالموعد وتحديث حالة الموعد إلى `completed`. |
| `GET /doctor/schedule` | عرض جدول/تقويم تجريبي للجدولة. |
| `GET /doctor/patient-records` | قائمة بسيطة بمرضى لهم مواعيد مع الطبيب. |

---

## 3) لوحة الإدارة والاستقبال (Admin / Receptionist)

**الصلاحية:** `role:admin` أو `role:receptionist` (نفس المجموعة في المسارات الحالية).

### أ) لوحة تحكم رئيسية

| المسار | الوظيفة |
|--------|---------|
| `GET /admin/dashboard` | إجمالي المستخدمين، الأطباء، المواعيد، المعلّقة، ومخطط بسيط حسب الشهر. |

### ب) الأطباء والمستخدمون والمواعيد (صفحات إدارية)

| المسار | الوظيفة |
|--------|---------|
| `GET /admin/doctors` | قائمة الأطباء. |
| `GET /admin/doctors/create` — `POST /admin/doctors` | إنشاء طبيب (يستخدم `AdminController::storeDoctor`). |
| `GET /admin/appointments` | عرض/إدارة المواعيد (حسب تنفيذ الـ view). |
| `GET /admin/departments` | صفحة أقسام إدارية (قد تختلف عن CRUD أدناه). |
| `GET /admin/users` | إدارة المستخدمين (قائمة). |

### ج) CRUD الأقسام والتخصصات (Resource)

| المسار | الوظيفة |
|--------|---------|
| `admin/departments` | full resource (index, create, store, edit, update, destroy). |
| `admin/specializations` | full resource للتخصصات. |

**ملاحظة:** يوجد أيضاً `DepartmentController` تحت namespace `Admin` للـ CRUD، بينما المسارات العامة `GET /departments` تستخدم **نفس الكلاس** من المجلد العام — تأكد دائماً من أن `show`/`index` العامة لا تتطلب صلاحية إدارة (حالياً العامة بدون `auth` في `web.php`).

---

## 4) مشترك لكل الأدوار (بعد تسجيل الدخول)

| المسار | الوظيفة |
|--------|---------|
| `GET /profile` — `GET /profile/edit` — `POST /profile` — `POST /profile/password` | الملف الشخصي وتعديله وكلمة المرور. |

---

## 5) عام — لغة واتجاه

| المسار | الوظيفة |
|--------|---------|
| `GET /locale/{ar\|en}` | حفظ اللغة في الجلسة (`SetLocale` middleware). |

---

## 6) مصادقة

| المسار | الوظيفة |
|--------|---------|
| `GET/POST /login` | تسجيل دخول (حسب `AuthController`: معرف بريد أو جوال + كلمة مرور + **OTP تجريبي 123456**). |
| `GET/POST /register` | تسجيل مريض أو طبيب + OTP تجريبي. |
| `POST /logout` | خروج. |

---

## 7) صفحات الموقع العامة (غير لوحة تحكم)

- الرئيسية، من نحن، خدمات (طوارئ، مختبر، أشعة، صيدلة)، الأطباء، الأقسام، تواصل.

---

*آخر تحديث: يعكس `routes/web.php` والـ controllers الرئيسية في المشروع.*
