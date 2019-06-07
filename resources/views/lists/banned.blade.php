@if(isset($attorneys_banned))
  <h2>DO-NOT-USE 'Banned' Attorneys</h2>
  @foreach ($attorneys_banned as $attorney)
    @include('attorney.row', $attorney)
  @endforeach
@endif
