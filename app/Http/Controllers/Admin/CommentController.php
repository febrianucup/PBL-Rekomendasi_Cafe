<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Comment::with(['user', 'cafe']);
        
        $tab = $request->get('tab', 'all');
        if ($tab !== 'all') {
            $query->where('status', $tab);
        }

        $comments = $query->latest()->get();
        
        $counts = [
            'pending' => \App\Models\Comment::where('status', 'pending')->count(),
            'approved' => \App\Models\Comment::where('status', 'approved')->whereDate('updated_at', \Carbon\Carbon::today())->count(),
        ];

        return view('admin.comments', compact('comments', 'counts', 'tab'));
    }

    public function updateStatus(Request $request, $id)
    {
        $comment = \App\Models\Comment::findOrFail($id);
        $comment->status = $request->status;
        $comment->save();

        return redirect()->back()->with('success', 'Comment status updated successfully.');
    }

    public function destroy($id)
    {
        $comment = \App\Models\Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
