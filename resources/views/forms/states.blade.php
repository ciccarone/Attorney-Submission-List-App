<div class="">
  <form class="state-selector">
    <select onchange="javascript:location.href = ('/list/' + this.value);" class="form-control">
      <option value="">Select State</option>
      @foreach ($states as $state_abbr => $state)
      <?php if (!in_array($state_abbr, $disallowed_states)): ?>
        <option value="{{ $state_abbr }}" <?php if ($current_state == $state_abbr): ?>
          selected="selected" <?php endif; ?>>{{ $state }}</option>
      <?php endif; ?>
      @endforeach
    </select>
  </form>
</div>
