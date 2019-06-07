<div class="row">
  <div class="col-sm-12">
    <header class="page-title">
      <h1>Attorney Approval Request</h1>
      <h2>A simple form for fast approvals</h2>
    </header>
  </div>
  <div class="col-lg-9">
    <form method="POST" action="/submit" enctype="multipart/form-data" class="form">
        @csrf
        <div class="d-flex">
          <i class="fas fa-folder-open form__icon"></i>
          <fieldset>
            <legend>
              <header>
                <h2>Before you begin...</h2>
                <h3>Download this document and then fill out completely, scan and upload with this form along with other required uploads</h3>
              </header>
            </legend>
            <div class="fields d-flex bd-highlight flex-wrap">
              <a href="../documents/mbfg.pdf" download="MBFG-Instructions.pdf" class="document-link">MBFG Instructions</a>
            </div>
          </fieldset>
        </div>
        <div class="d-flex">
          <i class="fas fa-user-circle form__icon"></i>
          <fieldset>
            <legend>
              <header>
                <h2>Who Referred You</h2>
                <h3>Info about the Semper Loan Officer or Branch Manager</h3>
              </header>
            </legend>
            <div class="fields d-flex bd-highlight flex-wrap">
              @if($semper)
                {!! $semper !!}
              @endif
            </div>
          </fieldset>
        </div>
        <div class="d-flex">
          <i class="fas fa-user-circle form__icon"></i>
          <fieldset>
            <legend>
              <header>
                <h2>Company Info</h2>
                <h3>Basic info about the attorney</h3>
              </header>
            </legend>
            <div class="fields d-flex bd-highlight flex-wrap">
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
                <h2>Required Documents Upload</h2>
                <h3>Please use only PDF documents</h3>
              </header>
            </legend>
            <div class="fields d-flex bd-highlight flex-wrap">
              @if($files)
                {!! $files !!}
              @endif
            </div>
          </fieldset>
        </div>
        <input type="submit" name="submit" value="Enter Attorney" class="btn btn-primary">
    </form>

  </div>
  <div class="col-lg-3">
    <div class="sidebar">
      <h2>Required Documents</h2>
      <h3>PDF's only please!</h3>
      @if($forms)
        @foreach ($forms as $form)
          <div class="form">
            <h4>{{ $form['file_name'] }}</h4>
            <p>{{ $form['description'] }}</p>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</div>
