<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Cafes;

class CafeCommentSection extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'tailwind';

    public $cafeId;
    public $commentType = 'review';
    
    public $body = '';
    public $rating_score = 5;
    public $photos = [];
    public $replyingToId = null; 
    public $reply_body = '';
    public $cafe;
    public $confirmingDeleteId = null;
    public $hasReviewed = false;
    public $hideFlash = false;
    public $isDeleteModalOpen = false;

    public function mount($cafeId){
        $this->cafeId = $cafeId;
        $this->cafe = Cafes::findOrFail($cafeId);

        if (Auth::check()) {
            $this->hasReviewed = Comment::where('cafe_id', $this->cafeId)
                ->where('user_id', Auth::id())
                ->where('type', 'review')
                ->exists();
        }
    }

    public function submitComment(){
        $this->validate([
            'body' => 'required|min:3',
            'rating_score' => $this->commentType === 'review' ? 'required|integer|between:1,5' : 'nullable',
        ]);

        if ($this->commentType === 'review') {
            $existingReview = Comment::where('cafe_id', $this->cafeId)
                ->where('user_id', Auth::id())
                ->where('type', 'review')
                ->exists();

            if ($existingReview) {
                session()->flash('error', __('messages.already_reviewed'));
                return;
            }

            if (Auth::id() === $this->cafe->user_id) {
                session()->flash('error', __('messages.owner_cannot_review'));
                return;
            }
        }

        Comment::create([
            'user_id' => Auth::id(),
            'cafe_id' => $this->cafeId,
            'type' => $this->commentType,
            'body' => $this->body,
            'rating_score' => $this->commentType === 'review' ? $this->rating_score : null,
            'images' => !empty($this->photos) ? json_encode($this->storePhotos()) : null,
        ]);

        $this->reset(['body', 'rating_score']);
        $this->photos = [];
        $this->hasReviewed = true;
        $this->hideFlash = false;
        session()->flash('success', __('messages.successfully_sent'));
    }

    public function submitReview(){
        $this->validate(['body' => 'required', 'rating_score' => 'required']);
        
        Comment::create([
            'user_id' => Auth::id(),
            'cafe_id' => $this->cafeId,
            'type' => 'review',
            'body' => $this->body,
            'rating_score' => $this->rating_score,
        ]);
    }

    public function submitDiscussion(){
        $this->validate(['body' => 'required']);
        
        Comment::create([
            'user_id' => Auth::id(),
            'cafe_id' => $this->cafeId,
            'type' => 'discussion',
            'body' => $this->body,
            'rating_score' => null,
        ]);
    }

    public function toggleReply($commentId)
    {
        if ($this->replyingToId == $commentId) {
            $this->replyingToId = null;
            $this->reply_body = '';
        } else {
            $this->replyingToId = $commentId;
            $this->reply_body = '';
        }
    }

    public function submitReply($commentId){
        $parentComment = Comment::findOrFail($commentId);
        
        if ($parentComment->type === 'review') {
            if (Auth::id() !== $this->cafe->user_id) {
                session()->flash('error', __('messages.only_owner_can_reply'));
                return;
            }
        }

        $this->validate(['reply_body' => 'required|min:3']);

        Comment::create([
            'user_id' => Auth::id(),
            'cafe_id' => $this->cafeId,
            'parent_id' => $commentId, 
            'type' => $parentComment->type, 
            'body' => $this->reply_body,
        ]);

        $this->reset(['reply_body', 'replyingToId']);
        $this->hideFlash = false;
        session()->flash('success', __('messages.reply_sent'));
    }

    public function updatingCommentType()
    {
        $this->resetPage('commentPage');
    }

    protected function storePhotos(){
        $uploadedImages = [];
    
        foreach ($this->photos as $photo) {
            $uploadedImages[] = $photo->store('cafes/reviews', 'public');
        }
        
        return $uploadedImages;
    }

    public function deleteComment(){
        if ($this->confirmingDeleteId) {
            $comment = Comment::find($this->confirmingDeleteId);
            
            if ($comment && ($comment->user_id === Auth::id() || Auth::id() === $this->cafe->user_id)) {
                $comment->delete();
                
                $this->confirmingDeleteId = null;
                $this->isDeleteModalOpen = false;
                $this->hideFlash = false;
                
                session()->flash('success', __('messages.comment_deleted'));
            }
        }
    }

    public function closeDeleteModal() {
        $this->isDeleteModalOpen = false;
        $this->confirmingDeleteId = null;
    }

    public function confirmDelete($commentId){
        $this->confirmingDeleteId = $commentId;
        $this->isDeleteModalOpen = true;
    }

    public function render(){
        // $allComments = Comment::with(['user', 'replies.user'])
        //     ->where('cafe_id', $this->cafeId)
        //     ->whereNull('parent_id')
        //     ->latest()
        //     ->get();
        
        $comments = ($this->commentType === 'review' ? $this->cafe->reviews() : $this->cafe->discussions())
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->latest()
            ->paginate(5, ['*'], 'commentPage');

        return view('livewire.⚡cafe-comment-section', [
            'comments' => $comments,
            'cafe' => $this->cafe,
        ]);
    }
}