@extends('layouts.base')

@section('content')
<div class="govuk-width-container ">
  <main class="govuk-main-wrapper " id="main-content" role="main">
    <h1 class="govuk-heading-xl">Applications catalogue</h1>

    <h2 class="govuk-heading-l">Edit catalogue entry</h2>

    @if ($errors->any())
      <div class="govuk-error-summary" aria-labelledby="error-summary-title" role="alert" tabindex="-1" data-module="govuk-error-summary">
        <h2 class="govuk-error-summary__title" id="error-summary-title">
          There is a problem
        </h2>
        <div class="govuk-error-summary__body">
          <ul class="govuk-list govuk-error-summary__list">
            @foreach ($errors->keys() as $key)
              <li>
                <a href="#{{ $key }}">{{ $errors->first($key) }}</a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    <form action="/entries/{{ $entry->id }}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="_method" value="PUT">

      @error('name')
      <div class="govuk-form-group govuk-form-group--error">
        <label class="govuk-label" for="name">
          Physical component
        </label>
        <span id="name-error" class="govuk-error-message">
          <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <input class="govuk-input  govuk-!-width-one-half govuk-!-width-one-halfgovuk-input--error" id="name" name="name" type="text" value="{{ $entry->name }}">
      </div>
      @else
      <div class="govuk-form-group">
        <label class="govuk-label" for="name">
          Physical component
        </label>
        <input class="govuk-input govuk-!-width-one-half" id="name" name="name" type="text" value="{{ $entry->name }}">
      </div>
      @enderror

      @error('description')
      <div class="govuk-form-group govuk-form-group--error">
        <label class="govuk-label" for="description">
          Description
        </label>
        <span id="description-error" class="govuk-error-message">
          <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <input class="govuk-input govuk-input--error" id="description" name="description" type="text" value="{{ $entry->description }}">
      </div>
      @else
      <div class="govuk-form-group">
        <label class="govuk-label" for="description">
          Description
        </label>
        <input class="govuk-input" id="description" name="description" type="text" value="{{ $entry->description }}">
      </div>
      @enderror

      @error('href')
      <div class="govuk-form-group govuk-form-group--error">
        <label class="govuk-label" for="href">
          Associated URL
        </label>
        <span id="href-error" class="govuk-error-message">
          <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <input class="govuk-input govuk-input--error" id="href" name="href" type="text" value="{{ $entry->href }}">
      </div>
      @else
      <div class="govuk-form-group">
        <label class="govuk-label" for="href">
          Associated URL
        </label>
        <input class="govuk-input" id="href" name="href" type="text" value="{{ $entry->href }}">
      </div>
      @enderror

      @error('category')
      <div class="govuk-form-group govuk-form-group--error">
        <label class="govuk-label" for="category">
          Category
        </label>
        <span id="category-error" class="govuk-error-message">
          <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <input class="govuk-input govuk-!-width-one-half govuk-input--error" id="category" name="category" type="text" value="{{ $entry->category}}">
      </div>
      @else
      <div class="govuk-form-group">
        <label class="govuk-label" for="category">
          Category
        </label>
        <input class="govuk-input govuk-!-width-one-half" id="category" name="category" type="text" value="{{ $entry->category}}">
      </div>
      @enderror

      @error('sub_category')
      <div class="govuk-form-group govuk-form-group--error">
        <label class="govuk-label" for="sub-category">
          Sub-category
        </label>
        <span id="sub_category-error" class="govuk-error-message">
          <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <input class="govuk-input govuk-!-width-one-half govuk-input--error" id="sub_category" name="sub_category" type="text" value="{{ $entry->sub_category }}">
      </div>
      @else
      <div class="govuk-form-group">
        <label class="govuk-label" for="sub-category">
          Sub-category
        </label>
        <input class="govuk-input govuk-!-width-one-half" id="sub_category" name="sub_category" type="text" value="{{ $entry->sub_category }}">
      </div>
      @enderror

      <button class="govuk-button govuk-!-margin-right-1" data-module="govuk-button" type="submit">
        Save changes
      </button>
      <a class="govuk-button govuk-button--secondary" data-module="govuk-button" href="{{ url()->previous() }}">
        Cancel and return to previous page
      </a>
    </form>
  </main>
</div>
@endsection
