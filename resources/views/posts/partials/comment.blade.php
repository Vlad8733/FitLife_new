<div class="comment {{ $comment->parent_id ? 'reply' : '' }}" id="comment-{{ $comment->id }}" data-comment-id="{{ $comment->id }}">
    <div class="comment-head">
        <strong>{{ $comment->user->name }}</strong>
        <div class="username fs-sm text-muted">{{ '@' . $comment->user->username }}</div>
        @if($comment->parent_id && $comment->parent && $comment->parent->user)
            <div class="in-reply-to fs-sm text-muted">In reply to <a href="{{ route('profile.show', $comment->parent->user->id) }}" class="text-accent">@{{ $comment->parent->user->username }}</a></div>
        @endif
        <span class="time fs-sm text-muted">{{ $comment->created_at->diffForHumans() }}</span>
    </div>
    <div class="comment-body">
        <p>{{ $comment->content }}</p>
    </div>
    <form id="edit-comment-form-{{ $comment->id }}" action="{{ route('comments.update', $comment) }}" method="POST" style="display: none;">
        @csrf
        @method('PUT')
        <textarea name="content" rows="2" maxlength="500">{{ $comment->content }}</textarea>
        <button type="submit" class="btn">Save</button>
        <button type="button" class="btn cancel-edit-comment" data-comment-id="{{ $comment->id }}">Cancel</button>
    </form>
    <div class="comment-actions">
        <button class="action-btn like-btn {{ Auth::check() && $comment->likes()->where('user_id', Auth::id())->where('type', 'like')->exists() ? 'active' : '' }}" data-comment-id="{{ $comment->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" 
                 fill="{{ Auth::check() && $comment->likes()->where('user_id', Auth::id())->where('type', 'like')->exists() ? '#ef4444' : 'currentColor' }}">
                <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
            </svg>
            <span class="count-like">{{ $comment->likes()->where('type', 'like')->count() }}</span>
        </button>

        <button class="action-btn dislike-btn {{ Auth::check() && $comment->likes()->where('user_id', Auth::id())->where('type', 'dislike')->exists() ? 'active' : '' }}" data-comment-id="{{ $comment->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" 
                 fill="{{ Auth::check() && $comment->likes()->where('user_id', Auth::id())->where('type', 'dislike')->exists() ? '#111827' : 'currentColor' }}">
                <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-25v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
            </svg>
            <span class="count-dislike">{{ $comment->likes()->where('type', 'dislike')->count() }}</span>
        </button>

        <button type="button" class="action-btn reply-btn" data-comment-id="{{ $comment->id }}" data-post-id="{{ $post->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000fa">
                <path d="M760-200v-160q0-50-35-85t-85-35H273l144 144-57 56-240-240 240-240 57 56-144 144h367q83 0 141.5 58.5T840-360v160h-80Z"/>
            </svg>
            <span>Reply</span>
        </button>

        @if (Auth::check() && Auth::id() === $comment->user_id)
            <button type="button" class="action-btn edit-comment-btn" data-comment-id="{{ $comment->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#75FB4C">
                    <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                </svg>
                <span>Edit</span>
            </button>
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline-form delete-comment-form">
                @csrf @method('DELETE')
                <button type="submit" class="action-btn delete-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="var(--svg-fill)">
                        <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm80-160h80v-360h-80v360Zm160 0h80v-360h-80v360Z"/>
                    </svg>
                    <span>Delete</span>
                </button>
            </form>
        @endif
        @if ($comment->replies->count() > 0)
            <button type="button" class="action-btn show-replies-btn" data-comment-id="{{ $comment->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                    <path d="M480-200q-33 0-56.5-23.5T400-280v-400l-160 160-56-56 240-240 240 240-56 56-160-160v400q0 33-23.5 56.5T480-200Z"/>
                </svg>
                <span>Show {{ $comment->replies->count() }} {{ $comment->replies->count() === 1 ? 'Reply' : 'Replies' }}</span>
            </button>
        @endif
    </div>

    <form action="{{ route('posts.comment', $post) }}" method="POST" class="comment-form reply-form" data-post-id="{{ $post->id }}" data-parent-id="{{ $comment->id }}" style="display: none; margin-top: 10px;">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <textarea name="content" placeholder="Write a reply..." rows="1" maxlength="500"></textarea>
        <button type="submit" class="btn">Reply</button>
        <button type="button" class="btn cancel-reply" data-comment-id="{{ $comment->id }}">Cancel</button>
    </form>

    <div class="replies-container" id="replies-{{ $comment->id }}" style="display: none;">
        @foreach($comment->replies as $reply)
            @include('posts.partials.comment', ['comment' => $reply, 'post' => $post])
        @endforeach
    </div>
</div>