document.addEventListener("DOMContentLoaded", () => {
    const main = document.querySelector('#main-content');
    if (!main) return;

    const els = {
        mobileToggle: document.getElementById('mobile-toggle'),
        sidebar: document.getElementById('sidebar'),
        postForm: document.getElementById('post-form'),
        postPhoto: document.getElementById('post-photo'),
        imagePreview: document.getElementById('image-preview'),
        removePhoto: document.getElementById('remove-photo'),
        postCharCount: document.getElementById('post-char-count'),
        postTextarea: document.querySelector('#post-form textarea[name="content"]'),
        alert: document.querySelector('.alert-container')
    };

    const viewedPosts = new Set(JSON.parse(localStorage.getItem('viewedPosts') || '[]'));
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Показ уведомления
    const showAlert = (msg, type) => {
        if (els.alert) {
            els.alert.innerHTML = `<div class="alert alert-${type}">${msg}</div>`;
            els.alert.style.display = 'block';
            setTimeout(() => {
                els.alert.style.display = 'none';
                els.alert.innerHTML = '';
            }, 5000);
        }
    };

    // Мобильное меню
    if (els.mobileToggle && els.sidebar) {
        els.mobileToggle.addEventListener('click', () => {
            const isOpen = els.sidebar.classList.toggle('active');
            els.mobileToggle.setAttribute('aria-expanded', isOpen);
        });
        document.addEventListener('click', e => {
            if (els.sidebar.classList.contains('active') && !els.sidebar.contains(e.target) && !els.mobileToggle.contains(e.target)) {
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
    }

    // Предпросмотр изображения
    if (els.postPhoto && els.imagePreview && els.removePhoto) {
        const previewContainer = els.imagePreview.parentElement;
        els.postPhoto.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    els.imagePreview.src = e.target.result;
                    previewContainer.style.display = 'block';
                    els.removePhoto.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
                els.removePhoto.style.display = 'none';
            }
        });
        els.removePhoto.addEventListener('click', () => {
            els.postPhoto.value = '';
            previewContainer.style.display = 'none';
            els.removePhoto.style.display = 'none';
        });
    }

    // Счетчик символов
    if (els.postTextarea && els.postCharCount) {
        els.postTextarea.addEventListener('input', () => {
            els.postCharCount.textContent = `${els.postTextarea.value.length}/1000`;
        });
    }

    // Переключение комментариев
    main.querySelectorAll('.comment-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const comments = document.getElementById(`comments-${btn.dataset.postId}`);
            comments.style.display = comments.style.display === 'none' ? 'block' : 'none';
        });
    });

    // Лайки/дизлайки для постов и комментариев
    const handleReaction = (btn, type, id, isComment) => {
        axios.post(isComment ? `/comments/${id}/toggle-reaction` : `/posts/${id}/reaction`, { type }, {
            headers: { 'X-CSRF-TOKEN': csrfToken }
        }).then(data => {
            const parent = btn.closest(isComment ? '.comment-actions' : '.post-actions');
            const likeBtn = parent.querySelector('.like-btn');
            const dislikeBtn = parent.querySelector('.dislike-btn');
            likeBtn.classList.toggle('active', data.data.type === 'like');
            dislikeBtn.classList.toggle('active', data.data.type === 'dislike');
            likeBtn.querySelector('.count-like').textContent = data.data.likeCount;
            dislikeBtn.querySelector('.count-dislike').textContent = data.data.dislikeCount;
            likeBtn.querySelector('svg').setAttribute('fill', data.data.type === 'like' ? '#ef4444' : 'currentColor');
            dislikeBtn.querySelector('svg').setAttribute('fill', data.data.type === 'dislike' ? '#111827' : 'currentColor');
        }).catch(() => showAlert(`Failed to update ${isComment ? 'comment' : 'post'} reaction.`, 'error'));
    };

    main.querySelectorAll('.post-card .like-btn, .post-card .dislike-btn').forEach(btn => {
        btn.addEventListener('click', () => handleReaction(btn, btn.classList.contains('like-btn') ? 'like' : 'dislike', btn.dataset.postId, false));
    });

    main.querySelectorAll('.comment .like-btn, .comment .dislike-btn').forEach(btn => {
        btn.addEventListener('click', () => handleReaction(btn, btn.classList.contains('like-btn') ? 'like' : 'dislike', btn.dataset.commentId, true));
    });

    // Счетчик просмотров
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !viewedPosts.has(entry.target.dataset.postId)) {
                const timer = setTimeout(() => {
                    axios.post(`/posts/${entry.target.dataset.postId}/views`, {}, {
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    }).then(data => {
                        entry.target.querySelector('.count-view').textContent = data.data.views;
                        viewedPosts.add(entry.target.dataset.postId);
                        localStorage.setItem('viewedPosts', JSON.stringify([...viewedPosts]));
                    }).catch(err => console.error('View error:', err));
                }, 5000);
                entry.target.dataset.viewTimer = timer;
            } else {
                clearTimeout(entry.target.dataset.viewTimer);
            }
        });
    }, { threshold: 0.3 });

    main.querySelectorAll('.post-card').forEach(post => observer.observe(post));

    // Создание поста
    if (els.postForm) {
        els.postForm.addEventListener('submit', e => {
            e.preventDefault();
            axios.post(els.postForm.action, new FormData(els.postForm), {
                headers: { 'X-CSRF-TOKEN': csrfToken }
            }).then(data => {
                if (data.data.success) {
                    showAlert(data.data.success, 'success');
                    els.postForm.reset();
                    if (els.imagePreview) els.imagePreview.parentElement.style.display = 'none';
                    if (els.removePhoto) els.removePhoto.style.display = 'none';
                    els.postCharCount.textContent = '0/1000';

                    const postsFeed = document.querySelector('.posts-feed');
                    const newPost = document.createElement('article');
                    newPost.className = 'post-card';
                    newPost.id = `post-${data.data.post.id}`;
                    newPost.dataset.postId = data.data.post.id;
                    newPost.innerHTML = `
                        <div class="post-top">
                            <div class="avatar">
                                <img src="${data.data.post.user.avatar ? '/storage/' + data.data.post.user.avatar : '/storage/logo/defaultPhoto.jpg'}" alt="${data.data.post.user.name}'s Avatar">
                            </div>
                            <div class="meta">
                                <a href="${data.data.post.user.profile_url}" class="name">${data.data.post.user.name}</a>
                                <div class="time">just now</div>
                            </div>
                        </div>
                        <div class="post-body" id="post-body-${data.data.post.id}">
                            <p>${data.data.post.content}</p>
                            ${data.data.post.photo_path ? `<img src="/storage/${data.data.post.photo_path}" alt="Post image" class="post-img" loading="lazy" />` : ''}
                        </div>
                        <form id="edit-post-form-${data.data.post.id}" action="/posts/${data.data.post.id}" method="POST" enctype="multipart/form-data" style="display: none;">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="PUT">
                            <textarea name="content" rows="3" maxlength="1000">${data.data.post.content}</textarea>
                            <div class="preview-container" style="position: relative;">
                                ${data.data.post.photo_path ? `<img id="edit-image-preview-${data.data.post.id}" src="/storage/${data.data.post.photo_path}" alt="Image preview" />` : `<img id="edit-image-preview-${data.data.post.id}" alt="Image preview" style="display: none;" />`}
                                <button type="button" class="remove-photo" data-post-id="${data.data.post.id}">×</button>
                            </div>
                            <label class="file-label" title="Attach photo">
                                <input type="file" name="photo" accept="image/*" class="edit-post-photo">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                    <path d="M160-160q-33 0-56.5-23.5T80-240v-400q0-33 23.5-56.5T160-720h240l80-80h320q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm73-280h207v-207L233-440Zm-73-40 160-160H160v160Zm0 120v120h640v-480H520v280q0 33-23.5 56.5T440-360H160Zm280-160Z"/>
                                </svg>
                            </label>
                            <button type="submit" class="btn">Save</button>
                            <button type="button" class="btn cancel-edit" data-post-id="${data.data.post.id}">Cancel</button>
                        </form>
                        <div class="post-actions">
                            <button class="action-btn like-btn" data-post-id="${data.data.post.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor">
                                    <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                </svg>
                                <span class="count-like">0</span>
                            </button>
                            <button class="action-btn dislike-btn" data-post-id="${data.data.post.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor">
                                    <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                                </svg>
                                <span class="count-dislike">0</span>
                            </button>
                            <button class="action-btn comment-toggle" data-post-id="${data.data.post.id}" data-count="0">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                    <path d="M240-400h480v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z"/>
                                </svg>
                                <span class="comment-count">0</span> Comments
                            </button>
                            <span class="view-count">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#6b7280">
                                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
                                </svg>
                                <span class="count-view">0</span> Views
                            </span>
                            ${data.data.can_update ? `<button type="button" class="action-btn edit-post-btn" data-post-id="${data.data.post.id}">Edit</button>` : ''}
                            ${data.data.can_delete ? `<form action="/posts/${data.data.post.id}" method="POST" class="inline-form delete-post-form"><input type="hidden" name="_token" value="${csrfToken}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="action-btn delete-btn">Delete</button></form>` : ''}
                        </div>
                        <div class="comments" id="comments-${data.data.post.id}" style="display:none">
                            <form action="/posts/${data.data.post.id}/comment" method="POST" class="comment-form" data-post-id="${data.data.post.id}">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <textarea name="content" placeholder="Write a comment..." rows="1" maxlength="500"></textarea>
                                <button type="submit" class="btn">Comment</button>
                            </form>
                        </div>
                    `;
                    postsFeed.insertBefore(newPost, postsFeed.firstChild);
                    attachPostEventListeners(newPost);
                    observer.observe(newPost);
                } else {
                    showAlert(data.data.error || 'Failed to create post.', 'error');
                }
            }).catch(() => showAlert('Failed to create post.', 'error'));
        });
    }

    // Комментарии
    const attachCommentFormListeners = form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            const postId = form.dataset.postId;
            const textarea = form.querySelector('textarea');
            if (!textarea.value.trim()) return showAlert('Please enter a comment.', 'error');

            axios.post(form.action, new FormData(form), {
                headers: { 'X-CSRF-TOKEN': csrfToken }
            }).then(data => {
                if (data.data.success) {
                    showAlert(data.data.success, 'success');
                    textarea.value = '';
                    const comments = document.getElementById(`comments-${postId}`);
                    const comment = document.createElement('div');
                    comment.className = 'comment';
                    comment.id = `comment-${data.data.comment.id}`;
                    comment.dataset.commentId = data.data.comment.id;
                    comment.style.marginLeft = data.data.comment.parent_id ? '20px' : '0';
                    comment.innerHTML = `
                        <div class="comment-head">
                            <strong>${data.data.comment.user_name}</strong>
                            <span class="time">just now</span>
                        </div>
                        <div class="comment-body">
                            <p>${data.data.comment.content}</p>
                        </div>
                        <form id="edit-comment-form-${data.data.comment.id}" action="/comments/${data.data.comment.id}" method="POST" style="display: none;">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="PUT">
                            <textarea name="content" rows="2" maxlength="500">${data.data.comment.content}</textarea>
                            <button type="submit" class="btn">Save</button>
                            <button type="button" class="btn cancel-edit-comment" data-comment-id="${data.data.comment.id}">Cancel</button>
                        </form>
                        <div class="comment-actions">
                            <button class="action-btn like-btn" data-comment-id="${data.data.comment.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor">
                                    <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                </svg>
                                <span class="count-like">0</span>
                            </button>
                            <button class="action-btn dislike-btn" data-comment-id="${data.data.comment.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor">
                                    <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                                </svg>
                                <span class="count-dislike">0</span>
                            </button>
                            ${data.data.can_update ? `<button type="button" class="action-btn edit-comment-btn" data-comment-id="${data.data.comment.id}">Edit</button>` : ''}
                            ${data.data.can_delete ? `<form action="/comments/${data.data.comment.id}" method="POST" class="inline-form delete-comment-form"><input type="hidden" name="_token" value="${csrfToken}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="action-btn delete-btn">Delete</button></form>` : ''}
                        </div>
                        <form action="/posts/${postId}/comment" method="POST" class="comment-form" data-post-id="${postId}" data-parent-id="${data.data.comment.id}">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="parent_id" value="${data.data.comment.id}">
                            <textarea name="content" placeholder="Write a reply..." rows="1" maxlength="500"></textarea>
                            <button type="submit" class="btn reply-btn">Reply</button>
                        </form>
                    `;
                    const parent = data.data.comment.parent_id ? document.querySelector(`#comment-${data.data.comment.parent_id}`) : null;
                    (parent ? parent : comments.lastElementChild).insertAdjacentElement(parent ? 'afterend' : 'beforebegin', comment);
                    attachCommentEventListeners(comment);
                    const toggle = document.querySelector(`.comment-toggle[data-post-id="${postId}"]`);
                    toggle.querySelector('.comment-count').textContent = +toggle.dataset.count + 1;
                    toggle.dataset.count = +toggle.dataset.count + 1;
                    comments.style.display = 'block';
                } else {
                    showAlert(data.data.error || 'Failed to add comment.', 'error');
                }
            }).catch(() => showAlert('Failed to add comment.', 'error'));
        });
    };

    // Обработка постов
    const attachPostEventListeners = post => {
        const postId = post.dataset.postId;
        const editBtn = post.querySelector('.edit-post-btn');
        const editForm = post.querySelector(`#edit-post-form-${postId}`);
        const postBody = post.querySelector(`#post-body-${postId}`);
        const cancelEdit = post.querySelector(`.cancel-edit[data-post-id="${postId}"]`);
        const editPhotoInput = post.querySelector('.edit-post-photo');
        const editImagePreview = post.querySelector(`#edit-image-preview-${postId}`);
        const removeEditPhoto = post.querySelector(`.remove-photo[data-post-id="${postId}"]`);

        if (editBtn) {
            editBtn.addEventListener('click', () => {
                postBody.style.display = 'none';
                editForm.style.display = 'block';
                if (editImagePreview.src && editImagePreview.src !== window.location.origin + '/storage/logo/defaultPhoto.jpg') {
                    removeEditPhoto.style.display = 'block';
                }
            });
        }

        if (cancelEdit) {
            cancelEdit.addEventListener('click', () => {
                postBody.style.display = 'block';
                editForm.style.display = 'none';
                editImagePreview.src = post.querySelector('.post-img')?.src || '';
                removeEditPhoto.style.display = editImagePreview.src ? 'block' : 'none';
                editPhotoInput.value = '';
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
                        removeEditPhoto.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (removeEditPhoto) {
            removeEditPhoto.addEventListener('click', () => {
                editPhotoInput.value = '';
                editImagePreview.style.display = 'none';
                removeEditPhoto.style.display = 'none';
            });
        }

        if (editForm) {
            editForm.addEventListener('submit', e => {
                e.preventDefault();
                axios.post(editForm.action, new FormData(editForm), {
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                }).then(data => {
                    if (data.data.success) {
                        showAlert(data.data.success, 'success');
                        postBody.innerHTML = `<p>${data.data.post.content}</p>${data.data.post.photo_path ? `<img src="/storage/${data.data.post.photo_path}" alt="Post image" class="post-img" loading="lazy" />` : ''}`;
                        postBody.style.display = 'block';
                        editForm.style.display = 'none';
                    } else {
                        showAlert(data.data.error || 'Failed to update post.', 'error');
                    }
                }).catch(() => showAlert('Failed to update post.', 'error'));
            });
        }

        const deleteForm = post.querySelector('.delete-post-form');
        if (deleteForm) {
            deleteForm.addEventListener('submit', e => {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this post?')) {
                    axios.post(deleteForm.action, new FormData(deleteForm), {
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    }).then(data => {
                        if (data.data.success) {
                            showAlert(data.data.success, 'success');
                            post.remove();
                        } else {
                            showAlert(data.data.error || 'Failed to delete post.', 'error');
                        }
                    }).catch(() => showAlert('Failed to delete post.', 'error'));
                }
            });
        }
    };

    // Обработка комментариев
    const attachCommentEventListeners = comment => {
        const commentId = comment.dataset.commentId;
        const editBtn = comment.querySelector('.edit-comment-btn');
        const editForm = comment.querySelector(`#edit-comment-form-${commentId}`);
        const commentBody = comment.querySelector('.comment-body');
        const cancelEdit = comment.querySelector(`.cancel-edit-comment[data-comment-id="${commentId}"]`);

        if (editBtn) {
            editBtn.addEventListener('click', () => {
                commentBody.style.display = 'none';
                editForm.style.display = 'block';
            });
        }

        if (cancelEdit) {
            cancelEdit.addEventListener('click', () => {
                commentBody.style.display = 'block';
                editForm.style.display = 'none';
            });
        }

        if (editForm) {
            editForm.addEventListener('submit', e => {
                e.preventDefault();
                axios.post(editForm.action, new FormData(editForm), {
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                }).then(data => {
                    if (data.data.success) {
                        showAlert(data.data.success, 'success');
                        commentBody.innerHTML = `<p>${data.data.comment.content}</p>`;
                        commentBody.style.display = 'block';
                        editForm.style.display = 'none';
                    } else {
                        showAlert(data.data.error || 'Failed to update comment.', 'error');
                    }
                }).catch(() => showAlert('Failed to update comment.', 'error'));
            });
        }

        const deleteForm = comment.querySelector('.delete-comment-form');
        if (deleteForm) {
            deleteForm.addEventListener('submit', e => {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this comment?')) {
                    axios.post(deleteForm.action, new FormData(deleteForm), {
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    }).then(data => {
                        if (data.data.success) {
                            showAlert(data.data.success, 'success');
                            comment.remove();
                            const postId = comment.closest('.post-card').dataset.postId;
                            const toggle = document.querySelector(`.comment-toggle[data-post-id="${postId}"]`);
                            toggle.querySelector('.comment-count').textContent = +toggle.dataset.count - 1;
                            toggle.dataset.count = +toggle.dataset.count - 1;
                        } else {
                            showAlert(data.data.error || 'Failed to delete comment.', 'error');
                        }
                    }).catch(() => showAlert('Failed to delete comment.', 'error'));
                }
            });
        }
    };

    // Привязка обработчиков к существующим постам и комментариям
    main.querySelectorAll('.post-card').forEach(post => {
        attachPostEventListeners(post);
        post.querySelectorAll('.comment').forEach(attachCommentEventListeners);
        post.querySelectorAll('.comment-form').forEach(attachCommentFormListeners);
    });

    // Бесконечная прокрутка
    let page = 2, loading = false;
    window.addEventListener('scroll', () => {
        if (loading || !document.querySelector('.posts-feed').childElementCount) return;
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
            loading = true;
            axios.get(`/posts?page=${page}`, {
                headers: { 'X-CSRF-TOKEN': csrfToken }
            }).then(data => {
                if (data.data.posts?.length) {
                    const postsFeed = document.querySelector('.posts-feed');
                    data.data.posts.forEach(post => {
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
                                    <div class="time">${post.created_at_diff}</div>
                                </div>
                            </div>
                            <div class="post-body" id="post-body-${post.id}">
                                <p>${post.content}</p>
                                ${post.photo_path ? `<img src="/storage/${post.photo_path}" alt="Post image" class="post-img" loading="lazy" />` : ''}
                            </div>
                            <form id="edit-post-form-${post.id}" action="/posts/${post.id}" method="POST" enctype="multipart/form-data" style="display: none;">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="PUT">
                                <textarea name="content" rows="3" maxlength="1000">${post.content}</textarea>
                                <div class="preview-container" style="position: relative;">
                                    ${post.photo_path ? `<img id="edit-image-preview-${post.id}" src="/storage/${post.photo_path}" alt="Image preview" />` : `<img id="edit-image-preview-${post.id}" alt="Image preview" style="display: none;" />`}
                                    <button type="button" class="remove-photo" data-post-id="${post.id}">×</button>
                                </div>
                                <label class="file-label" title="Attach photo">
                                    <input type="file" name="photo" accept="image/*" class="edit-post-photo">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                        <path d="M160-160q-33 0-56.5-23.5T80-240v-400q0-33 23.5-56.5T160-720h240l80-80h320q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm73-280h207v-207L233-440Zm-73-40 160-160H160v160Zm0 120v120h640v-480H520v280q0 33-23.5 56.5T440-360H160Zm280-160Z"/>
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
                                    <span class="count-like">${post.like_count}</span>
                                </button>
                                <button class="action-btn dislike-btn ${post.user_disliked ? 'active' : ''}" data-post-id="${post.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="${post.user_disliked ? '#111827' : 'currentColor'}">
                                        <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                                    </svg>
                                    <span class="count-dislike">${post.dislike_count}</span>
                                </button>
                                <button class="action-btn comment-toggle" data-post-id="${post.id}" data-count="${post.comment_count}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                        <path d="M240-400h480v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z"/>
                                    </svg>
                                    <span class="comment-count">${post.comment_count}</span> Comments
                                </button>
                                <span class="view-count">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#6b7280">
                                        <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
                                    </svg>
                                    <span class="count-view">${post.views}</span> Views
                                </span>
                                ${post.can_update ? `<button type="button" class="action-btn edit-post-btn" data-post-id="${post.id}">Edit</button>` : ''}
                                ${post.can_delete ? `<form action="/posts/${post.id}" method="POST" class="inline-form delete-post-form"><input type="hidden" name="_token" value="${csrfToken}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="action-btn delete-btn">Delete</button></form>` : ''}
                            </div>
                            <div class="comments" id="comments-${post.id}" style="display:none">
                                ${post.comments.map(c => `
                                    <div class="comment" id="comment-${c.id}" data-comment-id="${c.id}" style="margin-left: ${c.parent_id ? '20px' : '0'};">
                                        <div class="comment-head">
                                            <strong>${c.user_name}</strong>
                                            <span class="time">${c.created_at_diff}</span>
                                        </div>
                                        <div class="comment-body">
                                            <p>${c.content}</p>
                                        </div>
                                        <form id="edit-comment-form-${c.id}" action="/comments/${c.id}" method="POST" style="display: none;">
                                            <input type="hidden" name="_token" value="${csrfToken}">
                                            <input type="hidden" name="_method" value="PUT">
                                            <textarea name="content" rows="2" maxlength="500">${c.content}</textarea>
                                            <button type="submit" class="btn">Save</button>
                                            <button type="button" class="btn cancel-edit-comment" data-comment-id="${c.id}">Cancel</button>
                                        </form>
                                        <div class="comment-actions">
                                            <button class="action-btn like-btn ${c.user_liked ? 'active' : ''}" data-comment-id="${c.id}">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="${c.user_liked ? '#ef4444' : 'currentColor'}">
                                                    <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                                </svg>
                                                <span class="count-like">${c.like_count}</span>
                                            </button>
                                            <button class="action-btn dislike-btn ${c.user_disliked ? 'active' : ''}" data-comment-id="${c.id}">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="${c.user_disliked ? '#111827' : 'currentColor'}">
                                                    <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                                                </svg>
                                                <span class="count-dislike">${c.dislike_count}</span>
                                            </button>
                                            ${c.can_update ? `<button type="button" class="action-btn edit-comment-btn" data-comment-id="${c.id}">Edit</button>` : ''}
                                            ${c.can_delete ? `<form action="/comments/${c.id}" method="POST" class="inline-form delete-comment-form"><input type="hidden" name="_token" value="${csrfToken}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="action-btn delete-btn">Delete</button></form>` : ''}
                                        </div>
                                        <form action="/posts/${post.id}/comment" method="POST" class="comment-form" data-post-id="${post.id}" data-parent-id="${c.id}">
                                            <input type="hidden" name="_token" value="${csrfToken}">
                                            <input type="hidden" name="parent_id" value="${c.id}">
                                            <textarea name="content" placeholder="Write a reply..." rows="1" maxlength="500"></textarea>
                                            <button type="submit" class="btn reply-btn">Reply</button>
                                        </form>
                                    </div>
                                `).join('')}
                                <form action="/posts/${post.id}/comment" method="POST" class="comment-form" data-post-id="${post.id}">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <textarea name="content" placeholder="Write a comment..." rows="1" maxlength="500"></textarea>
                                    <button type="submit" class="btn">Comment</button>
                                </form>
                            </div>
                        `;
                        postsFeed.appendChild(postElement);
                        attachPostEventListeners(postElement);
                        observer.observe(postElement);
                    });
                    page++;
                }
                loading = false;
            }).catch(() => {
                showAlert('Failed to load more posts.', 'error');
                loading = false;
            });
        }
    });
});