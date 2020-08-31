<div class="toast ml-auto" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
  <div class="toast-body {{session('message')['bg']}}">
    {{ session('message')['text'] }}
  </div>
</div>
{{session()->forget('message')}}
