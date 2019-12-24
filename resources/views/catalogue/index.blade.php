@extends('layouts.base')

@section('content')
  <div class="govuk-width-container ">
    <main class="govuk-main-wrapper " id="main-content" role="main">
      <h1 class="govuk-heading-xl">Applications catalogue</h1>

      <!-- only show features in local development -->
      @if (env('APP_ENV') == 'local')
      <a class="govuk-button govuk-button--secondary govuk-!-margin-right-1" data-module="govuk-button" href="/catalogue/upload">
        Import catalogue
      </a>
      <a class="govuk-button govuk-button--warning" data-module="govuk-button" href="/catalogue/delete">
        Delete catalogue
      </a>
      @endif

      @if ($entries->count() > 0)
        <table class="govuk-table">
          <caption class="govuk-table__caption govuk-!-margin-bottom-2">This catalogue contains {{ $entries->total() }} entries.</caption>
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
        <!-- this needs to be styled -->
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
