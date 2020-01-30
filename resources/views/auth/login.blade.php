@extends('layouts.base')

@section('content')

@include ('partials.errors')

<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        <h2 class="govuk-heading-l">Sign in</h2>

    <form id="login" action="{{ route('login') }}" method="post">
        {{ csrf_field() }}

        @component('components.text-input', [
            'type' => 'email',
            'name' => 'email',
            'label' => 'Email address',
            'autocomplete' => 'username'
        ])
        @endcomponent

        @component('components.text-input', [
            'type' => 'password',
            'name' => 'password',
            'label' => 'Password',
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
          <!-- <p class="govuk-body">
              <a class="govuk-link" href="/user/request">
                  Request an account
              </a>
          </p> -->
      @endif



        <h2 class="govuk-heading-l">Use single sign-on</h2>
        <h3 class="govuk-heading-m">GitHub</h3>
        <p class="govuk-body">
            This option is open to anyone who has a GitHub account.
        </p>
        <a class="govuk-button govuk-button--secondary" href="/login/github">Continue</a>

        <!-- <h3 class="govuk-heading-m">Microsoft</h3>
        <p class="govuk-body">
            This option is open to anyone has has an account on the NIGOV domain.
        </p>
        <a class="govuk-button govuk-button--secondary" href="/login/microsoft">Continue</a> -->
    </div>
</div>

@endsection
