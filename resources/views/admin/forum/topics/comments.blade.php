<div class="di__comment_reply">
    <ol class="comments">
        @foreach ($topic->comment as $comment)
            <li class="{{ count($comment->replies) ? 'has-replies' : '' }}">
                <article class="comment">
                    <aside class="avatar">
                        <img src="{{ $comment->user->profile_image_url ?? asset('images/comment.png') }}" alt=""
                            height="58" width="58">
                        <div class="d-flex justify-content-between pt-0 pt-md-3 align-items-center flex-wrap">
                            <p class="mb-0 name tertiary-color fw-smedium">
                                {{ $comment->user->name }}<span
                                    class="primary-color text-xs fw-normal ms-1">(@username)</span></p>
                            <p class="mb-0 di__comment_time">
                                {{ \Carbon\Carbon::parse($comment->created_at)->format('H:i | d M, Y') }}
                            </p>
                        </div>
                    </aside>
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex gap-3 gap-md-4 align-items-center">
                            <div class="comment-content" id="comment-text-{{ $comment->id }}">
                                <p class="tertiary-color text-xs mb-0">
                                    {!! $comment->comment_text !!}
                                </p>
                                <div class="attachments">
                                    @foreach ($comment->attachments as $attachment)
                                        @switch($attachment->mimeType)
                                            @case('image/jpeg')
                                            @case('image/jpg')
                                            @case('image/png')
                                                <img src="{{ $attachment->attachment_url }}"
                                                    class="attachment-image-{{ $attachment->id }}" width="50%">
                                            @break

                                            @case('video/mp4')
                                            @case('video/mpeg')
                                            @case('video/webm')
                                                <video src="{{ $attachment->attachment_url }}"
                                                    class="attachment-image-{{ $attachment->id }}" width="50%" controls>
                                                @break

                                            @default
                                                <a href="{{ $attachment->attachment_url }}"
                                                    style="position: absolute;
                                                width: max-content;
                                                background-color: aliceblue;"
                                                    class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                                    target="_blank"><span><img src="{{ asset('images/icon/delete.svg') }}"
                                                            alt="" class="in-svg"></span>Download</a>
                                                <img src="{{ asset('images/icon/file.svg') }}"
                                                    class="attachment-image-{{ $attachment->id }}" width="25%">
                                                @break
                                        @endswitch
                                    @endforeach
                                </div>
                            </div>

                            <div class="comment-content d-none" id="comment-edit-box-{{ $comment->id }}">
                                <div class="di__editor">
                                    <div id="comment-edit-{{ $comment->id }}">
                                        {!! $comment->comment_text !!}
                                    </div>
                                </div>
                                <div class="attachments">
                                    @foreach ($comment->attachments as $attachment)
                                        {{-- @dd($attachment->mimeType) --}}
                                        <div class="attachment-image-{{ $attachment->id }}">
                                            <button onclick="deleteAttachment('{{ $attachment->id }}')"
                                                style="position: absolute;
                                                width: max-content;
                                                background-color: aliceblue;"
                                                class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"><span><img
                                                        src="{{ asset('images/icon/delete.svg') }}" alt=""
                                                        class="in-svg"></span>Delete</button>
                                            @switch($attachment->mimeType)
                                                @case('image/jpeg')
                                                @case('image/jpg')

                                                @case('image/png')
                                                    <img src="{{ $attachment->attachment_url }}"
                                                        class="attachment-image-{{ $attachment->id }}" width="50%">
                                                @break

                                                @case('video/mp4')
                                                @case('video/mpeg')

                                                @case('video/webm')
                                                    <video src="{{ $attachment->attachment_url }}"
                                                        class="attachment-image-{{ $attachment->id }}" width="50%">
                                                    @break

                                                    @default
                                                        <img src="{{ asset('images/icon/file.svg') }}"
                                                            class="attachment-image-{{ $attachment->id }}" width="25%">
                                                    @break
                                                @endswitch
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 d-flex gap-3 flex-wrap">
                                    <span
                                        class="primary-color btn btn-bordered d-inline-flex text-md align-items-center fw-smedium position-relative">
                                        <input type="file" id="attachment-edit-{{ $comment->id }}"
                                            class="w-100 opacity-0 z-1 h-100 position-absolute"><span
                                            class="di__clip me-2"><img src="{{ asset('images/icon/clip.svg') }}"
                                                alt="" class="in-svg"></span>Attach File
                                    </span>
                                    <button type="button"
                                        onclick="onSave('comment_edit_{{ $comment->id }}','{{ $comment->id }}','{{ $comment->commented_by }}','attachment-edit-{{ $comment->id }}')"
                                        data-comment_id="{{ $comment->id }}"
                                        class="btn text-md fw-smedium">Save</button>
                                    <button type="button"
                                        onclick="hideEditBox('comment-text-{{ $comment->id }}','comment-edit-box-{{ $comment->id }}')"
                                        class="primary-color btn btn-bordered d-inline-flex text-md align-items-center fw-smedium position-relative">Cancle</button>
                                </div>
                            </div>
                            @if ($comment->commented_by == auth()->user()->id || auth()->user()->user_type == '1')
                                <div class="btn-group di__option_block">
                                    <a href="javascript:void(0)" class="dropdown-toggle" type="button"
                                        id="defaultDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true"
                                        aria-expanded="false">
                                        <img src="{{ asset('images/icon/options.svg') }}" alt=""
                                            class="in-svg">
                                    </a>
                                    <ul class="dropdown-menu border-0 mt-3" aria-labelledby="defaultDropdown">
                                        <li class="p-0"
                                            onclick="showEditBox('comment-text-{{ $comment->id }}','comment-edit-box-{{ $comment->id }}')">
                                            <button
                                                class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"><span><img
                                                        src="{{ asset('images/icon/edit-comment.svg') }}"
                                                        alt="" class="in-svg"></span>Edit</button>
                                        </li>
                                        <li class="p-0"><button onclick="deleteComment('{{ $comment->id }}')"
                                                class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"><span><img
                                                        src="{{ asset('images/icon/delete.svg') }}" alt=""
                                                        class="in-svg"></span>Delete</button>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-3 mt-1 flex-wrap">
                            <a href="javascript:void(0)" id="reply-btn" onclick="showEditor('{{ $comment->id }}')"
                                data-comment_id="{{ $comment->id }}" class="d-flex">
                                <img src="{{ asset('images/icon/reply.svg') }}" alt="">
                                <p class="ms-1 mb-0 text-xs me-0 di__count">Replies <span
                                        class="ms-1">({{ count($comment->replies) }})</span></p>
                            </a>
                            <a href="javascript:void(0)" onclick="likeComment('{{ $comment->id }}')"
                                class="d-flex">
                                <img src="{{ asset('images/icon/like.svg') }}" alt="">
                                <p class="ms-1 mb-0 text-xs me-0 di__count">Helpful <span
                                        class="ms-1">({{ $comment->likes_count }})</span></p>
                            </a>
                        </div>

                    </div>
                </article>
                <ol class="replies">
                    @foreach ($comment->replies as $reply)
                        <li>
                            <article class="comment">
                                <aside class="avatar">
                                    <img src="{{ $reply->user->profile_image_url ?? asset('images/comment.png') }}"
                                        alt="" height="58" width="58">
                                    <div
                                        class="d-flex justify-content-between pt-0 pt-md-3 align-items-center flex-wrap">
                                        <p class="mb-0 name tertiary-color fw-smedium">
                                            {{ $reply->user->name }}<span
                                                class="primary-color text-xs fw-normal ms-1">(@username)</span>
                                        </p>
                                        <p class="mb-0 di__comment_time">
                                            {{ \Carbon\Carbon::parse($reply->created_at)->format('H:i | d M, Y') }}
                                        </p>
                                    </div>
                                </aside>
                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex gap-3 gap-md-4 align-items-center">
                                        <div class="comment-content" id="reply-text-{{ $reply->id }}">
                                            <p class="tertiary-color text-xs mb-0">
                                                {!! $reply->comment_text !!}
                                            </p>
                                            <div class="attachments">
                                                @foreach ($reply->attachments as $attachment)
                                                    @switch($attachment->mimeType)
                                                        @case('image/jpeg')
                                                        @case('image/jpg')
                                                        @case('image/png')
                                                            <img src="{{ $attachment->attachment_url }}"
                                                                class="attachment-image-{{ $attachment->id }}" width="50%">
                                                        @break
            
                                                        @case('video/mp4')
                                                        @case('video/mpeg')
                                                        @case('video/webm')
                                                            <video src="{{ $attachment->attachment_url }}"
                                                                class="attachment-image-{{ $attachment->id }}" width="50%" controls>
                                                            @break
            
                                                        @default
                                                            <a href="{{ $attachment->attachment_url }}"
                                                                style="position: absolute;
                                                            width: max-content;
                                                            background-color: aliceblue;"
                                                                class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                                                target="_blank"><span><img src="{{ asset('images/icon/delete.svg') }}"
                                                                        alt="" class="in-svg"></span>Download</a>
                                                            <img src="{{ asset('images/icon/file.svg') }}"
                                                                class="attachment-image-{{ $attachment->id }}" width="25%">
                                                            @break
                                                    @endswitch
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="comment-content d-none" id="reply-edit-box-{{ $reply->id }}">
                                            <div class="di__editor">
                                                <div id="reply-edit-{{ $reply->id }}">
                                                    {!! $reply->comment_text !!}
                                                </div>
                                            </div>
                                            <div class="attachments">
                                                @foreach ($reply->attachments as $attachment)
                                                    <div class="attachment-image-{{ $attachment->id }}">
                                                        <button onclick="deleteAttachment('{{ $attachment->id }}')"
                                                            style="position: absolute;
                                                            width: max-content;
                                                            background-color: aliceblue;"
                                                            class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"><span><img
                                                                    src="{{ asset('images/icon/delete.svg') }}"
                                                                    alt=""
                                                                    class="in-svg"></span>Delete</button>
                                                        @switch($attachment->mimeType)
                                                            @case('image/jpeg')
                                                            @case('image/jpg')
                                                            @case('image/png')
                                                                <img src="{{ $attachment->attachment_url }}"
                                                                    class="attachment-image-{{ $attachment->id }}" width="50%">
                                                            @break
                
                                                            @case('video/mp4')
                                                            @case('video/mpeg')
                                                            @case('video/webm')
                                                                <video src="{{ $attachment->attachment_url }}"
                                                                    class="attachment-image-{{ $attachment->id }}" width="50%" controls>
                                                                @break
                
                                                            @default
                                                                <img src="{{ asset('images/icon/file.svg') }}"
                                                                    class="attachment-image-{{ $attachment->id }}" width="25%">
                                                                @break
                                                        @endswitch
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mt-4 d-flex gap-3 flex-wrap">
                                                <span
                                                    class="primary-color btn btn-bordered d-inline-flex text-md align-items-center fw-smedium position-relative">
                                                    <input type="file"
                                                        id="reply-attachment-edit-{{ $reply->id }}"
                                                        accept="image/jpg,image/png,image/jpeg"
                                                        class="w-100 opacity-0 z-1 h-100 position-absolute"><span
                                                        class="di__clip me-2"><img
                                                            src="{{ asset('images/icon/clip.svg') }}" alt=""
                                                            class="in-svg"></span>Attach
                                                    File
                                                </span>
                                                <button type="button"
                                                    onclick="onSave('reply_edit_{{ $reply->id }}','{{ $reply->id }}','','reply-attachment-edit-{{ $reply->id }}')"
                                                    data-comment_id="{{ $reply->id }}"
                                                    class="btn text-md fw-smedium">Save</button>
                                                <button type="button"
                                                    onclick="hideEditBox('reply-text-{{ $reply->id }}','reply-edit-box-{{ $reply->id }}')"
                                                    class="primary-color btn btn-bordered d-inline-flex text-md align-items-center fw-smedium position-relative">Cancle</button>
                                            </div>
                                        </div>
                                        @if ($comment->commented_by == auth()->user()->id || auth()->user()->user_type == '1')
                                            <div class="btn-group di__option_block">
                                                <a href="javascript:void(0)" class="dropdown-toggle" type="button"
                                                    id="defaultDropdown" data-bs-toggle="dropdown"
                                                    data-bs-auto-close="true" aria-expanded="false">
                                                    <img src="{{ asset('images/icon/options.svg') }}" alt=""
                                                        class="in-svg">
                                                </a>
                                                <ul class="dropdown-menu border-0 mt-3"
                                                    aria-labelledby="defaultDropdown">
                                                    <li class="p-0"
                                                        onclick="showEditBox('reply-text-{{ $reply->id }}','reply-edit-box-{{ $reply->id }}')">
                                                        <button
                                                            class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"><span><img
                                                                    src="{{ asset('images/icon/edit-comment.svg') }}"
                                                                    alt="" class="in-svg"></span>Edit</button>
                                                    </li>
                                                    <li class="p-0"><button
                                                            onclick="deleteComment('{{ $reply->id }}')"
                                                            class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"><span><img
                                                                    src="{{ asset('images/icon/delete.svg') }}"
                                                                    alt=""
                                                                    class="in-svg"></span>Delete</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-3 mt-1 flex-wrap">
                                        <a href="javascript:void(0)" onclick="likeComment('{{ $reply->id }}')"
                                            class="d-flex">
                                            <img src="{{ asset('images/icon/like.svg') }}" alt="">
                                            <p class="ms-1 mb-0 text-xs me-0 di__count">Helpful <span
                                                    class="ms-1">({{ $reply->likes_count }})</span>
                                            </p>
                                        </a>
                                    </div>
                                </div>

                            </article>

                        </li>
                    @endforeach
                </ol>
                <div id="comment-editor-{{ $comment->id }}" class="d-none">
                    <div class="di__editor">
                        <div id="editor-{{ $comment->id }}"></div>
                    </div>
                    <div class="mt-4 d-flex gap-3 flex-wrap">
                        <span
                            class="primary-color btn btn-bordered d-inline-flex text-md align-items-center fw-smedium position-relative">
                            <input type="file" id="attachment-{{ $comment->id }}"
                                class="w-100 opacity-0 z-1 h-100 position-absolute"><span class="di__clip me-2"><img
                                    src="{{ asset('images/icon/clip.svg') }}" alt=""
                                    class="in-svg"></span>Attach File
                        </span>
                        <button type="button"
                            onclick="reply('{{ $comment->id }}','attachment-{{ $comment->id }}')"
                            data-comment_id="{{ $comment->id }}" class="btn text-md fw-smedium">Send
                            Reply</button>
                        <button type="button" onclick="hideEditor('{{ $comment->id }}')"
                            class="primary-color btn btn-bordered d-inline-flex text-md align-items-center fw-smedium position-relative">Cancle</button>
                    </div>
                </div>
            </li>
        @endforeach
    </ol>
</div>
