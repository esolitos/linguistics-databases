@include("common.header")
<div class="content-wrapper row">
  <div class="container">
    <div class="small-12 small-centered columns title-region">
      <h1 id="page_title">{{ empty($page_title) ? 'Double Object Database' : $page_title }}</h1>
      @if( !empty($page_description) )
          <p>{{ $page_description }}</p>
      @endif
    </div>
    <div class="small-10 small-centered columns messages-region">
      @if ( $messages->has('general') )
        @foreach ($messages->get('general') as $error)
          <div data-alert class="alert-box">
            {{ $error }}
            <a href="#" class="close">&times;</a>
          </div>
        @endforeach
      @endif
    </div>
    <div class="small-12 main-content">
      @yield("content")
    </div>
  </div>
</div>
@include("common.footer")
