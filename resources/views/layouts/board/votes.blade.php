<div class="row ">
    <div class="container">
            <div>
                @if (!$thread->likedBy(auth()->user()))
                    <form id="{{ 'like-form-' . $thread->id }}"
                        action="{{ route('threads.likes', $thread) }}" method="post">
                        @csrf
                        <a href="javascript:{}"
                            onclick="document.getElementById('{{ 'like-form-' . $thread->id }}').submit(); return false;"><i class="fa fa-heart" aria-hidden="true"></i></a>
                    </form>
                @endif
                {{-- TODO: route('thread.vote', [$thread->id, 1]) --}}
            </div>
            <div style="font-size: 24px; font-weight: bold">{{ $thread->likes->count() }} <br>
                {{ Str::plural('like', $thread->likes->count()) }}</div>
            <div>
                @if ($thread->likedBy(auth()->user()))
                    <form id="{{ 'unlike-form-' . $thread->id }}"
                        action="{{ route('threads.likes', $thread) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <a href="javascript:{}"
                            onclick="document.getElementById('{{ 'unlike-form-' . $thread->id }}').submit(); return false;"><i class="fa fa-heartbeat" aria-hidden="true"></i></a>
                    </form>
                @endif
            </div>
    </div>
</div>