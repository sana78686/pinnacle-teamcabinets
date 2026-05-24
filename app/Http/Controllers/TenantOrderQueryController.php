<?php

namespace App\Http\Controllers;

use App\Models\ManageEmailsContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantOrderQueryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        tenant_email()->sendToAdmin(ManageEmailsContent::SLUG_USER_QUERY, [
            'USERNAME' => tenant_panel_display_name($user),
            'EMAIL' => (string) $user->email,
            'SUBJECT' => $validated['subject'],
            'QUERY' => $validated['message'],
        ]);

        return response()->json([
            'message' => 'Your message has been sent. We will get back to you soon.',
        ]);
    }
}
