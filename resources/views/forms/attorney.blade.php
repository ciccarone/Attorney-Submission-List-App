<div class="row">
  <div class="col-sm-12">
    <header class="page-title">
      <h1>Attorney Approval Request</h1>
    </header>
  </div>
  <div class="col-sm-12">
    <form method="POST" action="/attorney/{{ $request['id'] }}" enctype="multipart/form-data" class="form">
        @csrf
        <div class="d-flex">
          <i class="fas fa-pen form__icon"></i>
          <fieldset>
            <legend>
              <header>
                <h2>Set Status</h2>
                <h3>Please note, status updates will initiate an email</h3>
              </header>
            </legend>
            <div class="fields d-flex bd-highlight flex-wrap">
              @if($status)
                {!! $status !!}
              @endif
            </div>
          </fieldset>
        </div>
        <div class="d-flex">
          <i class="fas fa-user-circle form__icon"></i>
          <fieldset>
            <legend>
              <header>
                <h2>Attorney Info</h2>
                <h3>Company, contact, status, and more</h3>
              </header>
            </legend>
            <div class="fields d-flex bd-highlight flex-wrap">
              @if($semper)
                {!! $semper !!}
              @endif
              @if($fields)
                {!! $fields !!}
              @endif
            </div>
          </fieldset>
        </div>
        <div class="d-flex">
          <i class="fas fa-cloud-upload-alt form__icon"></i>
          <fieldset>
            <legend>
              <header>
                <h2>Forms</h2>
                <h3>Uploaded Documentation</h3>
              </header>
            </legend>
            <div class="fields d-flex bd-highlight flex-wrap">
              @if($files)
                {!! $files !!}
                <a href="/attorney/download/{{ $request['id'] }}" style="font-weight: bold;">Download All Files</a>
              @endif
            </div>
          </fieldset>
        </div>

        <input type="submit" name="submit" value="Update Attorney" class="btn btn-primary">
    </form>
    <form class="form" action="/attorney/delete/{{ $request['id'] }}" method="POST">
      @csrf
      <input type="hidden" name="previous_url" value="{!! URL::previous() !!}">
      <input type="submit" name="Delete" class="btn btn-danger" value="Delete Attorney">
    </form>
  </div>
</div>
