@extends('layouts.base')

@section('content')
  <div class="govuk-width-container ">
    <main class="govuk-main-wrapper " id="main-content" role="main">
      <h1 class="govuk-heading-xl">Applications catalogue</h1>

      @if ($entries->count() > 0)
        <table class="govuk-table">
          <caption class="govuk-table__caption govuk-!-margin-bottom-2">This catalogue contains {{ $entries->total() }} entries.</caption>
          <thead class="govuk-table__head">
            <tr class="govuk-table__row">
              <th scope="col" class="govuk-table__header">Physical component</th>
              <th scope="col" class="govuk-table__header govuk-!-width-one-half">Description</th>
              <th scope="col" class="govuk-table__header">Status</th>
              <th scope="col" class="govuk-table__header">Action</th>
            </tr>
          </thead>
          <tbody class="govuk-table__body">
            @foreach ($entries as $entry)
              <tr scope="row" class="govuk-table__row">
                @if ($entry->href)
                  <td class="govuk-table__cell">
                    <a class="govuk-link" href="{{ $entry->href }}">
                      {{ $entry->name }} {{ $entry->version ? '(' . $entry->version . ')' : '' }}
                    </a>
                  </td>
                @else
                  <td class="govuk-table__cell">{{ $entry->name }} {{ $entry->version ? '(' . $entry->version . ')' : '' }}</td>
                @endif
                <td class="govuk-table__cell">{{ $entry->description }}</td>
                <td class="govuk-table__cell">
                    <span class="{{ $labels[$entry->status] }}">{{ $entry->status }}</span>
                </td>
                <td class="govuk-table__cell">
                  <a class="govuk-link" href="/entries/{{ $entry->id }}/edit">Edit</a>
                </td>
              </tr>

            @endforeach
          </tbody>
        </table>
        {{ $entries->links() }}
      @else
        <div class="govuk-warning-text">
          <span class="govuk-warning-text__icon" aria-hidden="true">!</span>
          <strong class="govuk-warning-text__text">
            <span class="govuk-warning-text__assistive">Warning</span>
            There are no entries in the catalogue.
          </strong>
        </div>
      @endif

      <a class="govuk-button govuk-!-margin-right-2" data-module="govuk-button" href="/entries/create">
        Add a new catalogue entry
      </a>

    </main>
  </div>
@endsection
