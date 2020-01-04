@extends('layouts.base')

@section('content')
<div class="govuk-width-container ">
  <main class="govuk-main-wrapper " id="main-content" role="main">
    <h1 class="govuk-heading-l">Edit catalogue entry</h1>

    @include ('partials.errors')

    <form action="/entries/{{ $entry->id }}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="_method" value="PUT">

      @error('name')
      <div class="govuk-form-group govuk-form-group--error">
        <label class="govuk-label" for="name">
          Name
        </label>
        <span id="name-error" class="govuk-error-message">
          <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <input class="govuk-input  govuk-!-width-one-half govuk-!-width-one-half govuk-input--error" id="name" name="name" type="text" value="{{ $entry->name }}">
      </div>
      @else
      <div class="govuk-form-group">
        <label class="govuk-label" for="name">
          Name
        </label>
        <input class="govuk-input govuk-!-width-one-half" id="name" name="name" type="text" value="{{ $entry->name }}">
      </div>
      @enderror

      @error('version')
      <div class="govuk-form-group govuk-form-group--error">
        <label class="govuk-label" for="version">
          Version
        </label>
        <span id="version-error" class="govuk-error-message">
          <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <input class="govuk-input  govuk-!-width-one-half govuk-!-width-one-quarter govuk-input--error" id="version" name="version" type="text" value="{{ $entry->version }}">
      </div>
      @else
      <div class="govuk-form-group">
        <label class="govuk-label" for="version">
          Version
        </label>
        <input class="govuk-input govuk-!-width-one-quarter" id="version" name="version" type="text" value="{{ $entry->version }}">
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

      @error('status')
      <div class="govuk-form-group govuk-form-group-error">
          <label class="govuk-label" for="Status">
            Status
          </label>
          <span id="status-error" class="govuk-error-message">
            <span class="govuk-visually-hidden">Error:</span> {{ $message }}
          </span>
          <select class="govuk-select" id="status" name="status">
            @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ ($status == $entry->status) ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
          </select>
      </div>
      @else
      <div class="govuk-form-group">
          <label class="govuk-label" for="Status">
            Status
          </label>
          <select class="govuk-select" id="status" name="status">
            @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ ($status == $entry->status) ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
          </select>
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
