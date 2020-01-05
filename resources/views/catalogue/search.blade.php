@extends('layouts.base')

@section('content')
<div class="govuk-width-container ">
    <main class="govuk-main-wrapper " id="main-content" role="main">
        <h1 class="govuk-heading-xl">Search catalogue</h1>
        <form action="/catalogue/search" method="get">
            {{ csrf_field() }}

            @component('components.text-input', [
                'name' => 'name',
                'label' => 'Enter the name of an entry (e.g. GOV.UK Notify)',
                'width' => 'govuk-!-width-two-thirds'
            ])
            @endcomponent

            @component('components.text-input', [
                'name' => 'description',
                'label' => 'Enter the description of an entry (e.g. Notifications)',
                'width' => 'govuk-!-width-two-thirds'
            ])
            @endcomponent

            <!-- custom version of the component to include the blank entry -->
            @component('components.select', [
                'name' => 'status',
                'label' => 'Status',
                'values' => $statuses,
                'blank' => true
            ])
            @endcomponent

            <button class="govuk-button govuk-!-margin-right-2" href="/entries" type="submtt">Search</button>
        </form>
  </main>
</div>
@endsection
