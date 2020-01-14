@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">Sign in using username and password</h1>

@include ('partials.errors')

<form id="login" action="{{ route('login') }}" method="post">
    {{ csrf_field() }}

    @component('components.text-input', [
        'type' => 'email',
        'name' => 'email',
        'label' => 'E-mail address',
        'width' => 'govuk-!-width-one-half',
        'autocomplete' => 'username'
    ])
    @endcomponent

    @component('components.text-input', [
        'type' => 'password',
        'name' => 'password',
        'label' => 'Password',
        'width' => 'govuk-!-width-one-half',
        'autocomplete' => 'off'
    ])
    @endcomponent

    <button class="govuk-button" data-module="govuk-button" type="submit">Continue</button>
</form>

@if (Route::has('password.request'))
    <p class="govuk-body">
        <a class="govuk-link" href="{{ route('password.request') }}">
            Forgotten your password?
        </a>
    </p>
    <p class="govuk-body">
        <a class="govuk-link" href="/register">
            Create an account
        </a>
    </p>
    <p class="govuk-body">
        <a class="govuk-link" href="/user/request">
            Request an account
        </a>
    </p>
@endif
@endsection
