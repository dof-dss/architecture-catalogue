@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">View cataloge entry</h1>

<dl class="govuk-summary-list">
    @component('components.summary-list-row')
      @slot('attribute')
        Name
      @endslot
      @slot('value')
        {{ $entry->name }}
      @endslot
    @endcomponent
    @component('components.summary-list-row')
      @slot('attribute')
        Version
      @endslot
      @slot('value')
        {{ $entry->version }}
      @endslot
    @endcomponent
    @component('components.summary-list-row')
      @slot('attribute')
        Description
      @endslot
      @slot('value')
        {{ $entry->description }}
      @endslot
    @endcomponent
    @component('components.summary-list-row')
      @slot('attribute')
        Vendor URL
      @endslot
      @slot('value')
        @if ($entry->href)
            <td class="govuk-table__cell">
                <a class="govuk-link" href="{{ $entry->href }}">
                  {{ $entry->href }}
                </a>
            </td>
        @else
            {{ $entry->href }}
        @endif
      @endslot
    @endcomponent
    @component('components.summary-list-row')
      @slot('attribute')
        Category
      @endslot
      @slot('value')
        {{ $entry->category }}
      @endslot
    @endcomponent
    @component('components.summary-list-row')
      @slot('attribute')
        Sub-category
      @endslot
      @slot('value')
        {{ $entry->sub_category }}
      @endslot
    @endcomponent
    @component('components.summary-list-row')
      @slot('attribute')
        Status
      @endslot
      @slot('value')
        <span class="{{ $labels[$entry->status] }}">{{ $entry->status }}</span>
      @endslot
    @endcomponent
    @component('components.summary-list-row')
      @slot('attribute')
        Functionality
      @endslot
      @slot('value')
        {{ $entry->functionality }}
      @endslot
    @endcomponent
    @component('components.summary-list-row')
      @slot('attribute')
        Service levels
      @endslot
      @slot('value')
        {{ $entry->service_levels }}
      @endslot
    @endcomponent
    @component('components.summary-list-row')
      @slot('attribute')
        Interfaces
      @endslot
      @slot('value')
        {{ $entry->interfaces }}
      @endslot
    @endcomponent
    @component('components.summary-list-row')
      @slot('attribute')
        Depends on
      @endslot
      @slot('value')
        @foreach ($entry->children as $item)
            <p class="govuk-body">
                <a class="govuk-link" href="/entries/{{ $item->parent->id}}">
                    {{ $item->parent->name }} {{ $item->parent->version }}
                </a>
            </p>
        @endforeach
      @endslot
      @slot('action')
        <a class="govuk-link" href="/entries/{{ $entry->id }}/links">
          Change<span class="govuk-visually-hidden"> change related entries</span>
        </a>
      @endslot
    @endcomponent
</dl>

<hr class="govuk-section-break govuk-section-break--m">

<form method="POST" action="/entries/{{ $entry->id }}">
    <a class="govuk-button govuk-!-margin-right-1" href="/entries/{{ $entry->id }}/edit">Edit</a>
    <a class="govuk-button govuk-button--secondary govuk-!-margin-right-1" href="/entries/{{ $entry->id }}/copy">Make a copy</a>
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
    <button class="govuk-button govuk-button--warning govuk-!-margin-right-1" data-module="govuk-button"type="submit">Delete this entry</button>
</form>
@endsection
