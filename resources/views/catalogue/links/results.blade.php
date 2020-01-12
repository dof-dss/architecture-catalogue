@extends('layouts.base')

@section('back')
<a href="/entries/{{ $entry_id }}/links/create" class="govuk-back-link">Back to dependency search</a>
@endsection

@section('content')

@include ('partials.errors')

@if ($entries->count() > 0)
    <form action="/entries/{{ $entry_id }}/links" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="entry_id" value="{{ $entry_id }}">
        <div class="govuk-form-group">
            <fieldset class="govuk-fieldset" aria-describedby="dependency-hint">
              <legend class="govuk-fieldset__legend govuk-fieldset__legend--xl">
                  <h2 class="govuk-fieldset__heading">
                      Which entries are dependencies?
                  </h2>
              </legend>
              <span id="dependency-hint" class="govuk-hint">
                  Select all entries that are dependencies.
              </span>
              <div class="govuk-checkboxes">
                  @foreach ($entries as $entry)
                  <div class="govuk-checkboxes__item">
                      <input class="govuk-checkboxes__input" id="link-{{ $loop->iteration }}" name="link[]" type="checkbox" value="{{ $entry->id }}">
                      <label class="govuk-label govuk-checkboxes__label" for="link-{{ $loop->iteration }}">
                          {{ $entry->name }} {{ $entry->version ? '(' . $entry->version . ')' : '' }}
                      </label>
                  </div>
                  @endforeach
              </div>
            </fieldset>
        </div>
        <button class="govuk-button" type="submit">Link selected entries</button>
    </form>
@else
    <div class="govuk-warning-text">
        <span class="govuk-warning-text__icon" aria-hidden="true">!</span>
        <strong class="govuk-warning-text__text">
            <span class="govuk-warning-text__assistive">Warning</span>
            There are no entries in the catalogue matching your search criteria.
        </strong>
    </div>
@endif
@endsection
