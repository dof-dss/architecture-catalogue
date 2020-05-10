@extends('layouts.base')

@section('back')
<a href="/entries/{{ $entry->id }}" class="govuk-back-link">See entry view</a>
@endsection

@section('content')
@if ($errors->any())
    <div class="govuk-error-summary" aria-labelledby="error-summary-title" role="alert" tabindex="-1" data-module="govuk-error-summary">
      <h2 class="govuk-error-summary__title" id="error-summary-title">
        There is a problem
      </h2>
      <div class="govuk-error-summary__body">
        <ul class="govuk-list govuk-error-summary__list">
            @foreach ($errors->keys() as $key)
                <li>
                    {{ $errors->first($key) }}
                </li>
            @endforeach
        </ul>
      </div>
    </div>
    <p class="govuk-heading-m">
      {{ $entry->name }} {{ $entry->version ? '(' . $entry->version . ')' : '' }} is currently used by:
    </p>
    @foreach ($entry->parents as $item)
        <p class="govuk-body">
            <a class="govuk-link" href="/entries/{{ $item->child->id}}">
                {{ $item->child->name }} {{ $item->child->version }}
            </a>
        </p>
    @endforeach
@else
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
@endif
@endsection
