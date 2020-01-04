@extends('layouts.base')

@section('content')
<div class="govuk-width-container ">
  <main class="govuk-main-wrapper " id="main-content" role="main">
    <h1 class="govuk-heading-xl">Import catalogue</h1>

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

    <form action="/catalogue/import" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      @error('file_upload_1')
          <div class="govuk-form-group govuk-form-group--error">
            <label class="govuk-label" for="file-upload-1">
              Upload catalogue (JSON file)
            </label>
            <span id="name-error" class="govuk-error-message">
              <span class="govuk-visually-hidden">Error:</span> {{ $message }}
            </span>
            <input class="govuk-file-upload govuk-input--error" id="file_upload_1" name="file_upload_1" type="file" value="{{ old('name') }}">
          </div>
      @else
          <div class="govuk-form-group">
            <label class="govuk-label" for="file-upload-1">
              Upload catalogue (JSON file)
            </label>
            <input class="govuk-file-upload" id="file_upload_1" name="file_upload_1" type="file">
          </div>
      @enderror

      <button class="govuk-button" data-module="govuk-button" type="submit">
        Upload file and import catalogue
      </button>
    </form>
  </main>
</div>
@endsection
