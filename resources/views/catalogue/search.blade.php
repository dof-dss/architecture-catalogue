@extends('layouts.base')

@section('content')
<div class="govuk-width-container ">
    <main class="govuk-main-wrapper " id="main-content" role="main">
        <h1 class="govuk-heading-l">Search catalogue</h1>
        <form action="/catalogue/search" method="get">
            {{ csrf_field() }}

            <div class="govuk-form-group">
                <label class="govuk-label" for="name">
                  Enter the name of an entry (e.g. GOV.UK Notify)
                </label>
                <input class="govuk-input govuk-!-width-two-thirds" id="name" name="name" type="text">
            </div>
            <div class="govuk-form-group">
                <label class="govuk-label" for="description">
                  Enter the description of an entry (e.g. Notifications)
                </label>
                <input class="govuk-input govuk-!-width-two-thirds" id="description" name="description" type="text">
            </div>
            <div class="govuk-form-group">
                <label class="govuk-label" for="status">
                  Status
                </label>
                <select class="govuk-select" id="status" name="status">
                <option value="" selected></option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
                </select>
            </div>

            <button class="govuk-button govuk-!-margin-right-2" href="/entries" type="submtt">Search</button>
        </form>
  </main>
</div>
@endsection
