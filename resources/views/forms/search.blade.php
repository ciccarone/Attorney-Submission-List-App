<div class="">
  <form action="/search" method="post">
    @csrf
    <div class="form-group">
      <label for="keyword">Keyword Search</label>
      <input type="text" class="form-control" id="keyword" name="keyword" aria-describedby="keywordHelp" placeholder="Enter keyword(s)">
      <small id="keywordHelp" class="form-text text-muted">Search for attorneys by company name or email address</small>
    </div>
  </form>
</div>
