@extends('layouts.base')

@section('content')
  <div class="govuk-width-container ">
    <main class="govuk-main-wrapper " id="main-content" role="main">
      <h1 class="govuk-heading-xl">Architecture Catalogue</h1>
      <p class="govuk-body">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </p>
      <table class="govuk-table">
        <thead class="govuk-table__head">
          <tr class="govuk-table__row">
            <th scope="col" class="govuk-table__header">Physical component</th>
            <th scope="col" class="govuk-table__header govuk-!-width-two-thirds">Description</th>
          </tr>
        </thead>
        <tbody class="govuk-table__body">
          <tr scope="row" class="govuk-table__row">
            <td class="govuk-table__cell">junk</td>
            <td class="govuk-table__cell">description of junk</td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>
@endsection
