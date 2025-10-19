document.addEventListener("DOMContentLoaded", () => {
    const main = document.querySelector('#main-content');
    if (!main) return;

    // DOM elements
    const els = {
        mobileToggle: document.getElementById('mobile-toggle'),
        sidebar: document.getElementById('sidebar'),
        postForm: document.getElementById('post-form'),
        postPhoto: document.getElementById('post-photo'),
        postVideo: document.getElementById('post-video'),
        imagePreview: document.getElementById('image-preview'),
        videoPreview: document.getElementById('video-preview'),
        removeMedia: document.getElementById('remove-media'),
        postCharCount: document.getElementById('post-char-count'),
        postTextarea: document.querySelector('#post-form textarea[name="content"]'),
        alert: document.querySelector('.alert-container')
    };

    const userId = document.querySelector('meta[name="user-id"]')?.content || 'guest';
    const viewedPostsKey = `viewedPosts_${userId}`;
    const viewedPosts = new Set(JSON.parse(localStorage.getItem(viewedPostsKey) || '[]'));
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    const showAlert = (message, type) => {
        if (!els.alert) return;
        els.alert.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        els.alert.style.display = 'block';
        setTimeout(() => {
            els.alert.style.display = 'none';
            els.alert.innerHTML = '';
        }, 5000);
    };

    const setupMobileMenu = () => {
        if (!els.mobileToggle || !els.sidebar) return;
        els.mobileToggle.addEventListener('click', () => {
            const isOpen = els.sidebar.classList.toggle('active');
            els.mobileToggle.setAttribute('aria-expanded', isOpen);
        });

        document.addEventListener('click', e => {
            if (els.sidebar.classList.contains('active') && 
                !els.sidebar.contains(e.target) && 
                !els.mobileToggle.contains(e.target)) {
                els.sidebar.classList.remove('active');
                els.mobileToggle.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && els.sidebar.classList.contains('active')) {
                els.sidebar.classList.remove('active');
                els.mobileToggle.setAttribute('aria-expanded', 'false');
            }
        });
    };

    const setupMediaPreview = () => {
        if (!els.postPhoto || !els.postVideo || !els.imagePreview || !els.videoPreview || !els.removeMedia) return;
        const previewContainer = els.imagePreview.parentElement;

        els.postPhoto.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    els.imagePreview.src = e.target.result;
                    els.imagePreview.style.display = 'block';
                    els.videoPreview.style.display = 'none';
                    previewContainer.style.display = 'block';
                    els.removeMedia.style.display = 'block';
                    els.postVideo.value = '';
                };
                reader.readAsDataURL(file);
            }
        });

        els.postVideo.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    els.videoPreview.src = e.target.result;
                    els.videoPreview.style.display = 'block';
                    els.imagePreview.style.display = 'none';
                    previewContainer.style.display = 'block';
                    els.removeMedia.style.display = 'block';
                    els.postPhoto.value = '';
                };
                reader.readAsDataURL(file);
            }
        });

        els.removeMedia.addEventListener('click', () => {
            els.postPhoto.value = '';
            els.postVideo.value = '';
            els.imagePreview.src = '';
            els.videoPreview.src = '';
            els.imagePreview.style.display = 'none';
            els.videoPreview.style.display = 'none';
            previewContainer.style.display = 'none';
            els.removeMedia.style.display = 'none';
        });
    };

    const setupCharCounter = () => {
        if (!els.postTextarea || !els.postCharCount) return;
        els.postTextarea.addEventListener('input', () => {
            els.postCharCount.textContent = `${els.postTextarea.value.length}/1000`;
        });
    };

    const setupCommentToggle = (scope = main) => {
        scope.querySelectorAll('.comment-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const comments = document.getElementById(`comments-${btn.dataset.postId}`);
                comments.style.display = comments.style.display === 'none' ? 'block' : 'none';
            });
        });
    };

    const handleReaction = async (btn, type, id, isComment) => {
        try {
            const response = await fetch(isComment ? `/comments/${id}/toggle-reaction` : `/posts/${id}/reaction`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ type })
            });

            const data = await response.json();
            const parent = btn.closest(isComment ? '.comment-actions' : '.post-actions');
            const likeBtn = parent.querySelector('.like-btn');
            const dislikeBtn = parent.querySelector('.dislike-btn');
            likeBtn.classList.toggle('active', data.type === 'like');
            dislikeBtn.classList.toggle('active', data.type === 'dislike');
            likeBtn.querySelector('.count-like').textContent = data.likeCount;
            dislikeBtn.querySelector('.count-dislike').textContent = data.dislikeCount;
            likeBtn.querySelector('svg').setAttribute('fill', data.type === 'like' ? '#ef4444' : 'currentColor');
            dislikeBtn.querySelector('svg').setAttribute('fill', data.type === 'dislike' ? '#ffffffff' : 'currentColor');
        } catch {
            showAlert('Failed to toggle reaction', 'error');
        }
    };

    const setupReactionButtons = (scope = main) => {
        scope.querySelectorAll('.like-btn, .dislike-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const isComment = !!btn.dataset.commentId;
                handleReaction(btn, btn.classList.contains('like-btn') ? 'like' : 'dislike', isComment ? btn.dataset.commentId : btn.dataset.postId, isComment);
            });
        });
    };

    const setupViewCounter = () => {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                const postId = entry.target.dataset.postId;
                if (entry.isIntersecting && !viewedPosts.has(postId)) {
                    const timer = setTimeout(async () => {
                        try {
                            const response = await fetch(`/posts/${postId}/views`, {
                                method: 'POST',
                                headers: { 'X-CSRF-TOKEN': csrfToken }
                            });
                            const data = await response.json();
                            document.querySelectorAll(`[data-post-id="${postId}"] .count-view`).forEach(el => el.textContent = data.views);
                            viewedPosts.add(postId);
                            localStorage.setItem(viewedPostsKey, JSON.stringify([...viewedPosts]));
                        } catch {
                            console.error('Failed to increment view count');
                        }
                    }, 5000);
                    entry.target.dataset.viewTimer = timer;
                } else {
                    clearTimeout(entry.target.dataset.viewTimer);
                }
            });
        }, { threshold: 0.3 });

        main.querySelectorAll('.post-card').forEach(post => observer.observe(post));
    };

    const setupPostForm = () => {
        if (!els.postForm) return;
        els.postForm.addEventListener('submit', async e => {
            e.preventDefault();
            try {
                const response = await fetch(els.postForm.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: new FormData(els.postForm)
                });
                const data = await response.json();
                if (data.success) {
                    showAlert('Post created successfully', 'success');
                    els.postForm.reset();
                    els.imagePreview.src = '';
                    els.videoPreview.src = '';
                    els.imagePreview.style.display = 'none';
                    els.videoPreview.style.display = 'none';
                    els.removeMedia.style.display = 'none';
                    els.postCharCount.textContent = '0/1000';

                    const postsFeed = document.querySelector('.posts-feed');
                    const newPost = createPostElement(data.post, csrfToken);
                    postsFeed.insertBefore(newPost, postsFeed.firstChild);
                    attachPostEventListeners(newPost);
                    setupReactionButtons(newPost);
                    attachCommentFormListeners(newPost);
                    setupCommentToggle(newPost);
                    setupReplyButtons(newPost);
                    restoreReplyDrafts(newPost);
                } else {
                    showAlert(data.message || 'Failed to create post', 'error');
                }
            } catch {
                showAlert('Failed to create post', 'error');
            }
        });
    };

    const createPostElement = (post, csrfToken) => {
        const postElement = document.createElement('article');
        postElement.className = 'post-card';
        postElement.id = `post-${post.id}`;
        postElement.dataset.postId = post.id;
        postElement.innerHTML = `
            <div class="post-top">
                <div class="avatar">
                    <img src="${post.user.avatar ? '/storage/' + post.user.avatar : '/storage/logo/defaultPhoto.jpg'}" alt="${post.user.name}'s Avatar">
                </div>
                <div class="meta">
                    <a href="${post.user.profile_url}" class="name">${post.user.name}</a>
                    <div class="username">@${post.user.username}</div>
                    <div class="time">${post.created_at_diff || 'just now'}</div>
                </div>
            </div>
            <div class="post-body" id="post-body-${post.id}">
                <p>${post.content}</p>
                ${post.media_path ? (post.media_type === 'image' ? 
                    `<img src="/storage/${post.media_path}" alt="Post image" class="post-img" loading="lazy" />` : 
                    `<video src="/storage/${post.media_path}" controls class="post-video" style="max-height: 200px; border-radius: var(--radius);"></video>`) : ''}
            </div>
            <form id="edit-post-form-${post.id}" action="/posts/${post.id}" method="POST" enctype="multipart/form-data" style="display: none;">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="_method" value="PUT">
                <textarea name="content" rows="3" maxlength="1000">${post.content}</textarea>
                <div class="preview-container" style="position: relative;">
                    ${post.media_path && post.media_type === 'image' ? 
                        `<img id="edit-image-preview-${post.id}" src="/storage/${post.media_path}" alt="Image preview" />` : 
                        `<img id="edit-image-preview-${post.id}" alt="Image preview" style="display: none;" />`}
                    ${post.media_path && post.media_type === 'video' ? 
                        `<video id="edit-video-preview-${post.id}" src="/storage/${post.media_path}" controls style="max-height: 200px; border-radius: var(--radius);"></video>` : 
                        `<video id="edit-video-preview-${post.id}" controls style="display: none; max-height: 200px; border-radius: var(--radius);" alt="Video preview"></video>`}
                    <button type="button" class="remove-media" data-post-id="${post.id}">×</button>
                </div>
                <label class="file-label" title="Attach photo">
                    <input type="file" name="photo" accept="image/*" class="edit-post-photo">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                        <path d="M160-160q-33 0-56.5-23.5T80-240v-400q0-33 23.5-56.5T160-720h240l80-80h320q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm73-280h207v-207L233-440Zm-73-40 160-160H160v160Zm0 120v120h640v-480H520v280q0 33-23.5 56.5T440-360H160Zm280-160Z"/>
                    </svg>
                </label>
                <label class="file-label" title="Attach video">
                    <input type="file" name="video" accept="video/mp4,video/mpeg,video/ogg,video/webm" class="edit-post-video">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                        <path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm0-80h640v-480H160v480Zm160-80 240-160-240-160v320Zm-160 80v-480 480Z"/>
                    </svg>
                </label>
                <button type="submit" class="btn">Save</button>
                <button type="button" class="btn cancel-edit" data-post-id="${post.id}">Cancel</button>
            </form>
            <div class="post-actions">
                <button class="action-btn like-btn ${post.user_liked ? 'active' : ''}" data-post-id="${post.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="${post.user_liked ? '#ef4444' : 'currentColor'}">
                        <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                    </svg>
                    <span class="count-like">${post.like_count || 0}</span>
                </button>
                <button class="action-btn dislike-btn ${post.user_disliked ? 'active' : ''}" data-post-id="${post.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="${post.user_disliked ? '#ffffffff' : 'currentColor'}">
                        <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                    </svg>
                    <span class="count-dislike">${post.dislike_count || 0}</span>
                </button>
                <button class="action-btn comment-toggle" data-post-id="${post.id}" data-count="${post.comment_count || 0}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                        <path d="M240-400h480v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z"/>
                    </svg>
                    <span class="comment-count">${post.comment_count || 0}</span> Comments
                </button>
                <span class="view-count">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#6b7280">
                        <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
                    </svg>
                    <span class="count-view">${post.views || 0}</span>
                </span>
                ${post.can_update ? `<button type="button" class="action-btn edit-post-btn" data-post-id="${post.id}">Edit</button>` : ''}
                ${post.can_delete ? `<form action="/posts/${post.id}" method="POST" class="inline-form delete-post-form"><input type="hidden" name="_token" value="${csrfToken}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="action-btn delete-btn">Delete</button></form>` : ''}
            </div>
            <div class="comments" id="comments-${post.id}" style="display:none">
                <form action="/posts/${post.id}/comment" method="POST" class="comment-form" data-post-id="${post.id}">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <textarea name="content" placeholder="Write a comment..." rows="1" maxlength="500"></textarea>
                    <button type="submit" class="btn"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#006400"><path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z"/></svg></button>
                </form>
            </div>
        `;
        return postElement;
    };

    const createCommentElement = (comment, postId, csrfToken) => {
        const commentElement = document.createElement('div');
        commentElement.className = 'comment';
        commentElement.id = `comment-${comment.id}`;
        commentElement.dataset.commentId = comment.id;
        commentElement.style.marginLeft = comment.parent_id ? '20px' : '0';
        commentElement.innerHTML = `
            <div class="comment-head">
                <strong>${comment.user_name}</strong>
                <div class="username">@${comment.user?.username || ''}</div>
                <span class="time">${comment.created_at_diff || 'just now'}</span>
            </div>
            <div class="comment-body">
                <p>${comment.content}</p>
            </div>
            <form id="edit-comment-form-${comment.id}" action="/comments/${comment.id}" method="POST" style="display: none;">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="_method" value="PUT">
                <textarea name="content" rows="2" maxlength="500">${comment.content}</textarea>
                <button type="submit" class="btn">Save</button>
                <button type="button" class="btn cancel-edit-comment" data-comment-id="${comment.id}">Cancel</button>
            </form>
            <div class="comment-actions">
                <button class="action-btn like-btn ${comment.user_liked ? 'active' : ''}" data-comment-id="${comment.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="${comment.user_liked ? '#ef4444' : 'currentColor'}">
                        <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                    </svg>
                    <span class="count-like">${comment.like_count || 0}</span>
                </button>
                <button class="action-btn dislike-btn ${comment.user_disliked ? 'active' : ''}" data-comment-id="${comment.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="${comment.user_disliked ? '#ffffffff' : 'currentColor'}">
                        <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                    </svg>
                    <span class="count-dislike">${comment.dislike_count || 0}</span>
                </button>
                <button type="button" class="action-btn reply-btn" data-comment-id="${comment.id}" data-post-id="${postId}">Reply</button>
                ${comment.can_update ? `<button type="button" class="action-btn edit-comment-btn" data-comment-id="${comment.id}">Edit</button>` : ''}
                ${comment.can_delete ? `<form action="/comments/${comment.id}" method="POST" class="inline-form delete-comment-form"><input type="hidden" name="_token" value="${csrfToken}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="action-btn delete-btn">Delete</button></form>` : ''}
            </div>
            <form action="/posts/${postId}/comment" method="POST" class="comment-form reply-form" data-post-id="${postId}" data-parent-id="${comment.id}" style="display: none; margin-top: 10px;">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="parent_id" value="${comment.id}">
                <textarea name="content" placeholder="Write a reply..." rows="1" maxlength="500"></textarea>
                <button type="submit" class="btn"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#006400"><path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z"/></svg></button>
                <button type="button" class="btn cancel-reply" data-comment-id="${comment.id}">Cancel</button>
            </form>
        `;
        return commentElement;
    };

    const restoreReplyDrafts = (scope = main) => {
        scope.querySelectorAll('.reply-form').forEach(form => {
            const postId = form.dataset.postId;
            const parentId = form.dataset.parentId;
            const draftKey = `replyDraft_${postId}_${parentId}`;
            const draft = localStorage.getItem(draftKey);
            if (draft) {
                form.querySelector('textarea').value = draft;
                form.style.display = 'block';
            }
            form.querySelector('textarea').addEventListener('input', () => {
                localStorage.setItem(draftKey, form.querySelector('textarea').value);
            });
        });
    };

    const setupReplyButtons = (scope = main) => {
        scope.querySelectorAll('.reply-btn').forEach(btn => {
            btn.removeEventListener('click', toggleReplyForm);
            btn.addEventListener('click', toggleReplyForm);
        });
    };

    const toggleReplyForm = (e) => {
        const btn = e.target.closest('.reply-btn');
        const commentId = btn.dataset.commentId;
        const postId = btn.dataset.postId;
        const form = document.querySelector(`.reply-form[data-parent-id="${commentId}"]`);
        if (form) {
            const isVisible = form.style.display === 'block';
            document.querySelectorAll(`.reply-form[data-post-id="${postId}"]`).forEach(f => {
                f.style.display = 'none';
            });
            form.style.display = isVisible ? 'none' : 'block';
            if (!isVisible) {
                form.querySelector('textarea').focus();
            }
        } else {
            console.error(`Reply form for comment ${commentId} not found`);
        }
    };

    const attachCommentFormListeners = (scope = main) => {
        scope.querySelectorAll('.comment-form').forEach(form => {
            form.removeEventListener('submit', submitCommentForm);
            form.addEventListener('submit', submitCommentForm);

            const cancelReply = form.querySelector('.cancel-reply');
            if (cancelReply) {
                cancelReply.removeEventListener('click', cancelReplyForm);
                cancelReply.addEventListener('click', cancelReplyForm);
            }
        });
    };

    const submitCommentForm = async (e) => {
        e.preventDefault();
        const form = e.target;
        const postId = form.dataset.postId;
        const parentId = form.dataset.parentId;
        const textarea = form.querySelector('textarea');
        if (!textarea.value.trim()) {
            showAlert('Comment cannot be empty', 'error');
            return;
        }

        form.querySelector('button[type="submit"]').disabled = true;
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: new FormData(form)
            });
            const data = await response.json();
            if (data.success) {
                showAlert('Comment added successfully', 'success');
                textarea.value = '';
                if (parentId) {
                    localStorage.removeItem(`replyDraft_${postId}_${parentId}`);
                    form.style.display = 'none';
                }
                const comments = document.getElementById(`comments-${postId}`);
                const existingComment = document.getElementById(`comment-${data.comment.id}`);
                if (!existingComment) {
                    const comment = createCommentElement(data.comment, postId, csrfToken);
                    const parent = data.comment.parent_id ? document.querySelector(`#comment-${data.comment.parent_id}`) : comments;
                    parent.insertBefore(comment, parent.lastElementChild || parent.firstChild);
                    attachCommentEventListeners(comment);
                    attachCommentFormListeners(comment);
                    setupReactionButtons(comment);
                    setupReplyButtons(comment);
                    restoreReplyDrafts(comment);
                    const toggle = document.querySelector(`.comment-toggle[data-post-id="${postId}"]`);
                    toggle.querySelector('.comment-count').textContent = +toggle.dataset.count + 1;
                    toggle.dataset.count = +toggle.dataset.count + 1;
                    comments.style.display = 'block';
                }
            } else {
                showAlert(data.message || 'Failed to add comment', 'error');
            }
        } catch {
            showAlert('Failed to add comment', 'error');
        } finally {
            form.querySelector('button[type="submit"]').disabled = false;
        }
    };

    const cancelReplyForm = (e) => {
        const form = e.target.closest('.reply-form');
        form.querySelector('textarea').value = '';
        localStorage.removeItem(`replyDraft_${form.dataset.postId}_${form.dataset.parentId}`);
        form.style.display = 'none';
    };

    const attachCommentEventListeners = (scope = main) => {
        scope.querySelectorAll('.comment').forEach(comment => {
            const commentId = comment.dataset.commentId;
            const editBtn = comment.querySelector('.edit-comment-btn');
            const editForm = comment.querySelector(`#edit-comment-form-${commentId}`);
            const commentBody = comment.querySelector('.comment-body');
            const cancelEdit = comment.querySelector(`.cancel-edit-comment[data-comment-id="${commentId}"]`);
            const deleteForm = comment.querySelector('.delete-comment-form');

            if (editBtn && editForm && commentBody && cancelEdit) {
                editBtn.removeEventListener('click', toggleEditForm);
                editBtn.addEventListener('click', toggleEditForm);

                cancelEdit.removeEventListener('click', cancelEditForm);
                cancelEdit.addEventListener('click', cancelEditForm);

                editForm.removeEventListener('submit', submitEditForm);
                editForm.addEventListener('submit', submitEditForm);
            }

            if (deleteForm) {
                deleteForm.removeEventListener('submit', submitDeleteForm);
                deleteForm.addEventListener('submit', submitDeleteForm);
            }
        });
    };

    const toggleEditForm = (e) => {
        const comment = e.target.closest('.comment');
        const commentId = comment.dataset.commentId;
        const commentBody = comment.querySelector('.comment-body');
        const editForm = comment.querySelector(`#edit-comment-form-${commentId}`);
        commentBody.style.display = 'none';
        editForm.style.display = 'block';
    };

    const cancelEditForm = (e) => {
        const comment = e.target.closest('.comment');
        const commentId = comment.dataset.commentId;
        const commentBody = comment.querySelector('.comment-body');
        const editForm = comment.querySelector(`#edit-comment-form-${commentId}`);
        commentBody.style.display = 'block';
        editForm.style.display = 'none';
    };

    const submitEditForm = async (e) => {
        e.preventDefault();
        const form = e.target;
        const commentId = form.id.replace('edit-comment-form-', '');
        const comment = document.querySelector(`#comment-${commentId}`);
        const commentBody = comment.querySelector('.comment-body');
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: new FormData(form)
            });
            const data = await response.json();
            if (data.success) {
                showAlert('Comment updated successfully', 'success');
                commentBody.innerHTML = `<p>${data.comment.content}</p>`;
                commentBody.style.display = 'block';
                form.style.display = 'none';
            } else {
                showAlert(data.message || 'Failed to update comment', 'error');
            }
        } catch {
            showAlert('Failed to update comment', 'error');
        }
    };

    const submitDeleteForm = async (e) => {
        e.preventDefault();
        const form = e.target;
        const comment = form.closest('.comment');
        const postId = comment.closest('.post-card').dataset.postId;
        if (!confirm('Are you sure you want to delete this comment?')) return;
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: new FormData(form)
            });
            const data = await response.json();
            if (data.success) {
                showAlert('Comment deleted successfully', 'success');
                comment.remove();
                const toggle = document.querySelector(`.comment-toggle[data-post-id="${postId}"]`);
                toggle.querySelector('.comment-count').textContent = +toggle.dataset.count - 1;
                toggle.dataset.count = +toggle.dataset.count - 1;
            } else {
                showAlert(data.message || 'Failed to delete comment', 'error');
            }
        } catch {
            showAlert('Failed to delete comment', 'error');
        }
    };

    const attachPostEventListeners = (post) => {
        const postId = post.dataset.postId;
        const editBtn = post.querySelector('.edit-post-btn');
        const editForm = post.querySelector(`#edit-post-form-${postId}`);
        const postBody = post.querySelector(`#post-body-${postId}`);
        const cancelEdit = post.querySelector(`.cancel-edit[data-post-id="${postId}"]`);
        const editPhotoInput = post.querySelector('.edit-post-photo');
        const editVideoInput = post.querySelector('.edit-post-video');
        const editImagePreview = post.querySelector(`#edit-image-preview-${postId}`);
        const editVideoPreview = post.querySelector(`#edit-video-preview-${postId}`);
        const removeEditMedia = post.querySelector(`.remove-media[data-post-id="${postId}"]`);
        const deleteForm = post.querySelector('.delete-post-form');

        if (editBtn) {
            editBtn.addEventListener('click', () => {
                postBody.style.display = 'none';
                editForm.style.display = 'block';
                if (editImagePreview.src && editImagePreview.src !== window.location.origin + '/storage/logo/defaultPhoto.jpg') {
                    editImagePreview.style.display = 'block';
                    editVideoPreview.style.display = 'none';
                    removeEditMedia.style.display = 'block';
                } else if (editVideoPreview.src) {
                    editVideoPreview.style.display = 'block';
                    editImagePreview.style.display = 'none';
                    removeEditMedia.style.display = 'block';
                }
            });
        }

        if (cancelEdit) {
            cancelEdit.addEventListener('click', () => {
                postBody.style.display = 'block';
                editForm.style.display = 'none';
                editImagePreview.src = post.querySelector('.post-img')?.src || '';
                editVideoPreview.src = post.querySelector('.post-video')?.src || '';
                editImagePreview.style.display = post.querySelector('.post-img') ? 'block' : 'none';
                editVideoPreview.style.display = post.querySelector('.post-video') ? 'block' : 'none';
                removeEditMedia.style.display = (editImagePreview.src || editVideoPreview.src) ? 'block' : 'none';
                editPhotoInput.value = '';
                editVideoInput.value = '';
            });
        }

        if (editPhotoInput) {
            editPhotoInput.addEventListener('change', () => {
                const file = editPhotoInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        editImagePreview.src = e.target.result;
                        editImagePreview.style.display = 'block';
                        editVideoPreview.style.display = 'none';
                        removeEditMedia.style.display = 'block';
                        editVideoInput.value = '';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (editVideoInput) {
            editVideoInput.addEventListener('change', () => {
                const file = editVideoInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        editVideoPreview.src = e.target.result;
                        editVideoPreview.style.display = 'block';
                        editImagePreview.style.display = 'none';
                        removeEditMedia.style.display = 'block';
                        editPhotoInput.value = '';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (removeEditMedia) {
            removeEditMedia.addEventListener('click', () => {
                editPhotoInput.value = '';
                editVideoInput.value = '';
                editImagePreview.src = '';
                editVideoPreview.src = '';
                editImagePreview.style.display = 'none';
                editVideoPreview.style.display = 'none';
                removeEditMedia.style.display = 'none';
                const removeMediaInput = document.createElement('input');
                removeMediaInput.type = 'hidden';
                removeMediaInput.name = 'remove_media';
                removeMediaInput.value = '1';
                editForm.appendChild(removeMediaInput);
            });
        }

        if (editForm) {
            editForm.addEventListener('submit', async e => {
                e.preventDefault();
                try {
                    const response = await fetch(editForm.action, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        body: new FormData(editForm)
                    });
                    const data = await response.json();
                    if (data.success) {
                        showAlert('Post updated successfully', 'success');
                        postBody.innerHTML = `
                            <p>${data.post.content}</p>
                            ${data.post.media_path ? (data.post.media_type === 'image' ? 
                                `<img src="/storage/${data.post.media_path}" alt="Post image" class="post-img" loading="lazy" />` : 
                                `<video src="/storage/${data.post.media_path}" controls class="post-video" style="max-height: 200px; border-radius: var(--radius);"></video>`) : ''}
                        `;
                        postBody.style.display = 'block';
                        editForm.style.display = 'none';
                    } else {
                        showAlert(data.message || 'Failed to update post', 'error');
                    }
                } catch {
                    showAlert('Failed to update post', 'error');
                }
            });
        }

        if (deleteForm) {
            deleteForm.addEventListener('submit', async e => {
                e.preventDefault();
                if (!confirm('Are you sure you want to delete this post?')) return;
                try {
                    const response = await fetch(deleteForm.action, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        body: new FormData(deleteForm)
                    });
                    const data = await response.json();
                    if (data.success) {
                        showAlert('Post deleted successfully', 'success');
                        post.remove();
                    } else {
                        showAlert(data.message || 'Failed to delete post', 'error');
                    }
                } catch {
                    showAlert('Failed to delete post', 'error');
                }
            });
        }
    };

    // Initialize all event listeners
    setupMobileMenu();
    setupMediaPreview();
    setupCharCounter();
    setupCommentToggle();
    setupReactionButtons();
    setupViewCounter();
    setupPostForm();
    attachCommentFormListeners();
    attachCommentEventListeners();
    setupReplyButtons();
    restoreReplyDrafts();

    main.querySelectorAll('.post-card').forEach(post => {
        attachPostEventListeners(post);
    });
});