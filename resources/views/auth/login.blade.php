@extends('layouts.base')

@section('content')
<h1 class="govuk-heading-l">Sign in</h1>




@include ('partials.errors')

<a class="govuk-button" href="/login/github">Sign in with GitHub <i class="fa fa-github" aria-hidden="true"></i></a>

<hr class="govuk-section-break govuk-section-break--m govuk-section-break--visible">

<h2 class="govuk-heading-m">Sign in using your account</h2>

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

    <button class="govuk-button govuk-button--secondary" data-module="govuk-button" type="submit">Sign in</button>
</form>

@if (Route::has('password.request'))
    <p class="govuk-body">
        <a class="govuk-link" href="{{ route('password.request') }}">
            Forgotten your password?
        </a>
    </p>

    <h3 class="govuk-heading-m">Don't have an account?</h3>

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
