@if ($thread->thread_image != '')
<span class="h6 d-inline-block text-truncate my-0 py-0" style="max-width:156px;">
    File:<a href="{{ asset('storage/threads/'. $thread->id .'/'. $thread->thread_image) }}" target="_blank" >
     {{ $thread->thread_image }}
    </a>
  </span>
<a href="{{ asset('storage/threads/' . $thread->id . '/thumbnail_' . $thread->thread_image) }}"
    target="_blank">
    <img class="float-left mr-3 mb-1"
        src="{{ asset('storage/threads/' . $thread->id . '/thumbnail_' . $thread->thread_image) }}"
        alt="Post Image" style="max-width:340px;max-height:230px;width:auto;height:auto;">
</a>
@endif
<div class="media-body">
    <h5 class="card-title mb-2 text-muted">
        <span class="font-weight-bold text-primary">{{ $thread->title }}</span> 
        {{ $thread->created_at->toDateTimeString() .' ('.$thread->created_at->shortEnglishDayOfWeek.') ' }} 
        <a class="badge badge-secondary" href="#">
            {{  str_pad($thread->id,7,'0',STR_PAD_LEFT)  }}
        </a>
        [<a href="{{ route('boards.threads.show',[$board,$thread]) }}">Reply</a>]
    </h5>
  </div>
<blockquote class="blockquote my-1">
    <span class="mx-8 mb-4">{!! nl2br(e($thread->thread_text)) !!}</span>
</blockquote>