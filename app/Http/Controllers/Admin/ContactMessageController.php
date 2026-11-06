<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    private const STATUSES = ['new', 'read', 'replied', 'archived'];

    public function index(Request $request)
    {
        $messages = ContactMessage::query()
            ->when(in_array($request->status, self::STATUSES, true), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('search'), fn ($query) => $query->where(fn ($inner) => $inner
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('subject', 'like', '%' . $request->search . '%')))
            ->latest()
            ->paginate(20)->withQueryString();

        $counts = ContactMessage::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.contacts.index', [
            'messages' => $messages,
            'counts' => $counts,
            'statuses' => self::STATUSES,
        ]);
    }

    public function show(ContactMessage $message)
    {
        if ($message->status === 'new') {
            $message->update(['status' => 'read', 'is_read' => true]);
        }

        return view('admin.contacts.show', ['message' => $message, 'statuses' => self::STATUSES]);
    }

    public function update(Request $request, ContactMessage $message)
    {
        $data = $request->validate(['status' => ['required', 'in:' . implode(',', self::STATUSES)]]);

        $message->update([
            'status' => $data['status'],
            'is_read' => $data['status'] !== 'new',
            'replied_at' => $data['status'] === 'replied' ? ($message->replied_at ?? now()) : $message->replied_at,
        ]);

        return redirect()->back()->with('success', 'Message marked as ' . $data['status'] . '.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Message deleted.');
    }
}
