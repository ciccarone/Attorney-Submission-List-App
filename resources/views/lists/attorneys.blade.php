@if(isset($attorneys_approved))
<h4 class="list-title">Approved Attorneys in {{ $state }}</h4>
    @forelse ($attorneys_approved as $attorney)
      @include('attorney.row', $attorney)
    @empty
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          No approved attorneys in {{ $state }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

    @endforelse
@endif
@auth
  @if(isset($attorneys_pending))
    <h4 class="list-title">Pending Attorney Approvals</h4>
      @forelse ($attorneys_pending as $attorney)
        @include('attorney.row', $attorney)
      @empty
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            No pending attorneys in {{ $state }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
      @endforelse
  @endif
@endauth
