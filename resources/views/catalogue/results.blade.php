@extends('layouts.base')

@section('content')
  <div class="govuk-width-container">
    <main class="govuk-main-wrapper" id="main-content" role="main">
      <h1 class="govuk-heading-xl govuk-!-margin-bottom-1">Search results</h1>
      <span class="govuk-caption-l govuk-!-margin-bottom-2">Your search returned {{ $entries->total() }} catalogue entries.</span>
      @if ($entries->count() > 0)
        @include('partials.entries-table')
      @else
        <div class="govuk-warning-text">
            <span class="govuk-warning-text__icon" aria-hidden="true">!</span>
            <strong class="govuk-warning-text__text">
                <span class="govuk-warning-text__assistive">Warning</span>
                There are no entries in the catalogue matching your search criteria.
            </strong>
        </div>
      @endif
      <a class="govuk-button govuk-button--secondary" data-module="govuk-button" href="/entries/search">
          Start a new search
      </a>
    </main>
  </div>
@endsection
