<div class="attorney">
  <ul class="attorney__details"><h5 class="attorney__title">{{ $attorney->company_name }} @if (Auth::user())
    <small>
      <a href="{{ env('BASE_URL') }}/attorney/{{ $attorney->id }}">
        <i class="fas fa-edit"></i>
      </a>
    </small> @endif</h5>


    @if( ($attorney->status_id !== '4') && ($attorney->status_id !== 4))
      <li><strong>Contact:</strong> {{ $attorney->company_contact_name }}</li>
      <li><strong>Location:</strong> {{ $attorney->city }}, {{ $attorney->state }} {{ $attorney->zip }}</li>
      <li><strong>Phone:</strong> {{ $attorney->phone }}</li>
      <li><strong>Email:</strong> <a href="mailto:{{ $attorney->email }}">{{ $attorney->email }}</a></li>
    @else
      <li><strong>Location:</strong> {{ $attorney->city }}, {{ $attorney->state }}</li>
    @endif

  </ul>
</div>
