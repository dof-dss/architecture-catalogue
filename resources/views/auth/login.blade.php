@extends('layouts.base')

@section('content')
<div class="govuk-width-container">
    <main class="govuk-main-wrapper" id="main-content" role="main">

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

        <p class="govuk-body">
            <a class="govuk-link" href="{{ route('register') }}">
                Create sign in details
            </a>
        </p>

        @if (Route::has('password.request'))
            <h2 class="govuk-heading-m">Problems signing in</h2>
            <p class="govuk-body">
                <a class="govuk-link" href="{{ route('password.request') }}">
                    I have forgotten my password
                </a>
            </p>
        @endif
    </main>
</div>
@endsection
