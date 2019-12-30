@extends('layouts.base')

@section('content')
  <div class="govuk-width-container ">
    <main class="govuk-main-wrapper " id="main-content" role="main">
      <h1 class="govuk-heading-xl govuk-!-margin-bottom-1">Search results</h1>
      <span class="govuk-caption-l govuk-!-margin-bottom-2">Your search returned {{ $entries->total() }} catalogue entries.</span>

      @if ($entries->count() > 0)
        <table class="govuk-table">
          <thead class="govuk-table__head">
            <tr class="govuk-table__row">
              <th scope="col" class="govuk-table__header">Physical component</th>
              <th scope="col" class="govuk-table__header">Description</th>
              <th scope="col" class="govuk-table__header">Action</th>
            </tr>
          </thead>
          <tbody class="govuk-table__body">
            @foreach ($entries as $entry)
              <tr scope="row" class="govuk-table__row">
                @if ($entry->href)
                  <td class="govuk-table__cell">
                    <a class="govuk-link" href="{{ $entry->href }}">
                      {{ $entry->name }}
                    </a>
                  </td>
                @else
                  <td class="govuk-table__cell">{{ $entry->name }}</td>
                @endif
                <td class="govuk-table__cell">{{ $entry->description }}</td>
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
            There are no entries in the catalogue matching your search criteria.
          </strong>
        </div>
      @endif
      <a class="govuk-button govuk-button--secondary" data-module="govuk-button" href="/">
        Start a new search
      </a>

    </main>
  </div>
@endsection
