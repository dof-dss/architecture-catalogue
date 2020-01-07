@extends('layouts.base')

@section('content')
<div class="govuk-width-container">
    <main class="govuk-main-wrapper" id="main-content" role="main">

        <h1 class="govuk-heading-l">Create an account</h1>

        @include ('partials.errors')
        <form method="POST" action="{{ route('register') }}">
          {{ csrf_field() }}

          @component('components.text-input', [
              'name' => 'name',
              'label' => 'Create a username',
              'width' => 'govuk-!-width-one-half'
          ])
          @endcomponent

          @component('components.text-input', [
              'type' => 'email',
              'name' => 'email',
              'label' => 'E-mail address',
              'width' => 'govuk-!-width-one-half'
          ])
          @endcomponent

          @component('components.text-input', [
              'type' => 'password',
              'name' => 'password',
              'label' => 'Create a password',
              'width' => 'govuk-!-width-one-half'
          ])
          @endcomponent

          @component('components.text-input', [
              'type' => 'password',
              'name' => 'password_confirmation',
              'label' => 'Confirm password',
              'width' => 'govuk-!-width-one-half'
          ])
          @endcomponent

          <button class="govuk-button" data-module="govuk-button" type="submit">Create account</button>

          <h2 class="govuk-heading-m">Already have an account</h2>
          <p class="govuk-body">
              <a class="govuk-link" href="{{ route('login') }}">
                  Login using account details
              </a>
          </p>
        </form>
    </div>
</div>
@endsection
