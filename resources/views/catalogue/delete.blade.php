@extends('layouts.base')

@section('back')
<a href="/entries/{{ $entry->id }}" class="govuk-back-link">See entry view</a>
@endsection

@section('content')
<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        <h2 class="govuk-heading-l">Are you sure you'd like to remove the following entry?</h2>
        <p class="govuk-heading-m">{{ $entry->name }} {{ $entry->version ? '(' . $entry->version . ')' : '' }}</p>
        <form action="/entries/{{ $entry->id }}" method="POST" class="govuk-!-mt-r6 paas-remove-user">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="govuk-button govuk-button--warning" data-module="govuk-button" type="submit">Yes, remove this entry</button>
            <a class="govuk-link" href="/entries/{{ $entry->id }}">No, go back to entry view</a>
        </form>
    </div>
</div>
@endsection
