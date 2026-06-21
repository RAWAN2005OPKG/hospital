<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Notification;
use App\Models\Prescription;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::where('notifiable_id', auth()->id())
            ->where('notifiable_type', 'App\\Models\\User')
            ->latest();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by read status
        if ($request->filled('read')) {
            if ($request->read === 'read') {
                $query->whereNotNull('read_at');
            } else {
                $query->whereNull('read_at');
            }
        }

        $notifications = $query->paginate(20);

        // Get unread count
        $unreadCount = Notification::where('notifiable_id', auth()->id())
            ->where('notifiable_type', 'App\\Models\\User')
            ->whereNull('read_at')
            ->count();

        return view('pharmacist.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->notifiable_id !== auth()->id()) {
            return back()->with('error', 'غير مصرح لك');
        }

        $notification->update(['read_at' => now()]);

        return back()->with('success', 'تم تحديد الإشعار كمقروء');
    }

    public function markAllAsRead()
    {
        Notification::where('notifiable_id', auth()->id())
            ->where('notifiable_type', 'App\\Models\\User')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة');
    }

    public function generateSystemNotifications()
    {
        $notifications = [];

        // Check for new prescriptions
        $newPrescriptions = Prescription::where('status', 'pending')
            ->where('created_at', '>=', now()->subHours(24))
            ->count();

        if ($newPrescriptions > 0) {
            $notifications[] = [
                'type' => 'new_prescription',
                'message' => "يوجد {$newPrescriptions} وصفة جديدة بانتظار المعالجة",
                'priority' => 'high'
            ];
        }

        // Check for low stock medicines
        $lowStockCount = Medicine::whereColumn('stock', '<=', 'low_stock_threshold')
            ->where('is_active', true)
            ->count();

        if ($lowStockCount > 0) {
            $notifications[] = [
                'type' => 'low_stock',
                'message' => "يوجد {$lowStockCount} دواء منخفض المخزون",
                'priority' => 'high'
            ];
        }

        // Check for expiring medicines
        $expiringCount = Medicine::where('expiration_date', '<=', now()->addDays(30))
            ->where('expiration_date', '>=', now())
            ->where('is_active', true)
            ->count();

        if ($expiringCount > 0) {
            $notifications[] = [
                'type' => 'expiring_soon',
                'message' => "يوجد {$expiringCount} دواء ستنتهي صلاحيته قريباً",
                'priority' => 'medium'
            ];
        }

        return view('pharmacist.notifications.system', compact('notifications'));
    }
}
