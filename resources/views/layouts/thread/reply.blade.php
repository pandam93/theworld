<div class="card mb-1"
style="width: max-content; max-width:100%; background-color: rgba(0,0,255,0.1);">
<div class="card-body py-2 pl-3">
  @if ($reply->reply_image)
        <span class="h6 d-inline-block text-truncate my-0 py-0" style="max-width:156px;">
        File:<a href="{{ asset('storage/threads/'. $thread->id .'/'. $reply->reply_image) }}" target="_blank" >
         {{ $reply->reply_image }}
        </a>
      </span>
      @endif
      <div class="media">
        @if ($reply->reply_image)
        <a href="{{ asset('storage/threads/'. $thread->id .'/thumbnail_'. $reply->reply_image) }}" target="_blank">
        <img class="mr-3"
        src="{{ asset('storage/threads/'. $reply->thread->id .'/thumbnail_' . $reply->reply_image) }}"
        alt="Generic placeholder image" style="max-width:340px;max-height:230px;width:auto;height:auto;"></a>
        @endif
        <div class="media-body">
          <h6 class="card-subtitle mb-2 mt-1 text-muted"><span class="font-weight-bold">{{ $reply->user->username }}</span> {{ $thread->created_at->toDateTimeString() .' ('.$thread->created_at->shortEnglishDayOfWeek.') ' }}                                                 
            <a id="mylink" class="badge badge-secondary" href="#">
            {{  str_pad($reply->id,7,'0',STR_PAD_LEFT)  }}
        </a></h6>
        {!! nl2br(e($reply->reply_text)) !!}
        </div>
    </div>
</div>
</div>