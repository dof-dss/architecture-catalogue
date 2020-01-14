@extends('layouts.base')

@section('content')
<div class="govuk-grid-row">
    <div class="govuk-grid-column-two-thirds">
        <h1 class="govuk-heading-xl">Your session has expired</h1>
        <p class="govuk-body">
            Your session has expired due to a period of inactivity.
        </p>
        <p class="govuk-body">
            <a class="govuk-link" href="/login">Please sign in again</a>
        </p>
    </div>
</div>
@endsection
