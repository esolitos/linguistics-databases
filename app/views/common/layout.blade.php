@include("common.header")
<div class="content-wrapper row">
  <div class="container">
    @if( !empty($page_title) )
    <div class="small-12 small-centered columns title-region">
      <h1 id="page_title">{{ $page_title }}</h1>
      @if( !empty($page_description) )
          <p>{{ $page_description }}</p>
      @endif
    </div>
    @endif
    @if ( $messages->has('general') )
      <div class="small-10 small-centered columns messages">
        @foreach ($messages->get('general') as $error)
          <div data-alert class="alert-box">
            {{ $error }}
            <a href="#" class="close">&times;</a>
          </div>
        @endforeach
      </div>
    @endif
    <div class="small-12 main-content">
      @yield("content")
    </div>
  </div>
</div>
@include("common.footer")