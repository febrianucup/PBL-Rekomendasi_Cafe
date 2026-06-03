<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Comment::with(['user', 'cafe']);
        
        $search = $request->get('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('body', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%")
                         ->orWhere('username', 'like', "%{$search}%");
                  })
                  ->orWhereHas('cafe', function($qc) use ($search) {
                      $qc->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $type = $request->get('type', 'all');
        if (in_array($type, ['review', 'discussion'])) {
            $query->where('type', $type);
        }

        $comments = $query->latest()->paginate(10)->withQueryString();
        
        $counts = [
            'total' => \App\Models\Comment::count(),
            'review' => \App\Models\Comment::where('type', 'review')->count(),
            'discussion' => \App\Models\Comment::where('type', 'discussion')->count(),
        ];

        return view('admin.comments', compact('comments', 'counts', 'type', 'search'));
    }

    public function destroy($id)
    {
        $comment = \App\Models\Comment::findOrFail($id);
        
        // If the comment has replies (cascade delete is configured in DB, but just in case, delete replies if they exist)
        $comment->delete();

        return redirect()->back()->with('success', __('messages.comments_deleted_success'));
    }
}
