@extends('layouts.base')

@section('content')
<div class="">
    <h1 class="govuk-heading-xl">Architecture Catalogue</h1>
    <p class="govuk-body">
      This architecture catalogue contains all of the solution building blocks (physical components) used by the NICS. This list is used to populate the NICS Architecture Portal which provides a publically accessible reference for architects designing solutions for the NICS.
    </p>
    <a class="govuk-button" data-module="govuk-button govuk-!-margin-right-1" href="{{ route('entry.find') }}">
        Find an entry
    </a>
    @if (auth()->user()->isContributor())
        <a class="govuk-button govuk-button--secondary" data-module="govuk-button" href="{{ route('entry.create') }}">
            Add a new entry
        </a>
    @endif
</div>
@endsection
