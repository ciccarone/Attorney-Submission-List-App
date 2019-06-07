@extends('layouts.app')
  @section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <header class="page-title">
        <h1>Attorney List</h1>
        <!-- <h2>Don't see your attorney listed? Click the Attorney approval form to submit a request for your attorney.</h2> -->
      </header>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-8">

      @if(isset($states))
        {!! $states !!}
      @endif


      @if(isset($list))
        {!! $list !!}
      @endif
    </div>
    <div class="col-lg-4">
      <div class="sidebar">
        @if(isset($banned))
          {!! $banned !!}
        @endif
      </div>
    </div>
  </div>
</div>
@stop
