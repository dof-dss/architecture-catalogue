@extends('layouts.base')

@section('breadcrumbs')
<div class="govuk-breadcrumbs">
    <ol class="govuk-breadcrumbs__list">
        <li class="govuk-breadcrumbs__list-item">
          <a class="govuk-breadcrumbs__link" href="/home">Home</a>
        </li>
        <li class="govuk-breadcrumbs__list-item">
          <a class="govuk-breadcrumbs__link" href="/entries/search">Search</a>
        </li>
        <li class="govuk-breadcrumbs__list-item" aria-current="page">Results</li>
    </ol>
</div>
@endsection

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
    @if (auth()->user()->isContributor())
        <a class="govuk-button govuk-button  govuk-!-margin-right-1" data-module="govuk-button" href="{{ route('entry.create') }}">
            Add a new entry
        </a>
        <a class="govuk-button govuk-button--secondary" data-module="govuk-button" href="/entries/search">
            Start a new search
        </a>
    @else
        <a class="govuk-button govuk-button" data-module="govuk-button" href="/entries/search">
            Start a new search
        </a>
    @endif
@endif
@endsection
