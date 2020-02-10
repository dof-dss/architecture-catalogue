@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l govuk-!-margin-bottom-1">Search results</h1>
<span class="govuk-caption-m govuk-!-margin-bottom-2">Your search returned {{ $entries->count() . ' catalogue '. Str::plural('entry', $entries->count()) }}.</span>
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
@endsection
