@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">Password confirmation required</h1>

<p class="govuk-body">Please confirm your password before continuing with the requested action.</p>

@include ('partials.errors')
<form method="POST" action="{{ route('password.confirm') }}">
    {{ csrf_field() }}

    @component('components.text-input', [
        'type' => 'password',
        'name' => 'password',
        'label' => 'Enter your current password',
        'width' => 'govuk-!-width-one-half'
    ])
    @endcomponent

    <button class="govuk-button" data-module="govuk-button" type="submit">Continue</button>

    @if (Route::has('password.request'))
        <p class="govuk-body">
            <a class="govuk-link" href="{{ route('password.request') }}">
                Forgotten your password?
            </a>
        </p>
    @endif
</form>
@endsection
