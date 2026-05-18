<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $chats = Chat::where("sender_id", $user->id)
                    ->orWhere("receiver_id", $user->id)
                    ->with("sender", "receiver")
                    ->orderBy("created_at", "desc")
                    ->get()
                    ->unique(function ($item) use ($user) {
                        return $item->sender_id === $user->id ? $item->receiver_id : $item->sender_id;
                    });

        return view("chats.index", compact("chats"));
    }

    public function show(User $otherUser)
    {
        $user = Auth::user();

        $messages = Chat::where(function ($query) use ($user, $otherUser) {
            $query->where("sender_id", $user->id)->where("receiver_id", $otherUser->id);
        })->orWhere(function ($query) use ($user, $otherUser) {
            $query->where("sender_id", $otherUser->id)->where("receiver_id", $user->id);
        })->with("sender", "receiver")
        ->orderBy("created_at", "asc")
        ->get();

        // Mark messages as read
        Chat::where("sender_id", $otherUser->id)
            ->where("receiver_id", $user->id)
            ->where("is_read", false)
            ->update(["is_read" => true]);

        return view("chats.show", compact("otherUser", "messages"));
    }

    public function store(Request $request, User $receiver)
    {
        $request->validate([
            "message" => "nullable|string|max:1000",
            "attachment" => "nullable|file|max:5120", // Max 5MB
        ]);

        if (!$request->message && !$request->hasFile("attachment")) {
            return back()->with("error", "الرسالة أو المرفق مطلوب.");
        }

        $attachmentPath = null;
        if ($request->hasFile("attachment")) {
            $attachmentPath = $request->file("attachment")->store("chat_attachments", "public");
        }

        Chat::create([
            "sender_id" => Auth::id(),
            "receiver_id" => $receiver->id,
            "message" => $request->message,
            "attachment" => $attachmentPath,
            "is_read" => false,
        ]);

        return back()->with("success", "تم إرسال الرسالة.");
    }
}