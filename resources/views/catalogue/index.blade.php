@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-xl">Browse catalogue</h1>
@if ($entries->count() > 0)
    @include('partials.entries-table')
@else
    <div class="govuk-warning-text">
        <span class="govuk-warning-text__icon" aria-hidden="true">!</span>
        <strong class="govuk-warning-text__text">
            <span class="govuk-warning-text__assistive">Warning</span>
            There are no entries in the catalogue.
        </strong>
    </div>
@endif
<a class="govuk-button" data-module="govuk-button" href="/entries/create">
    Add a new catalogue entry
</a>
@endsection
