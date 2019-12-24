@extends('layouts.base')

@section('content')
<div class="govuk-width-container ">
  <main class="govuk-main-wrapper " id="main-content" role="main">
    <h1 class="govuk-heading-xl">Import catalogue</h1>

    <form action="/catalogue/import" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="govuk-form-group">
        <label class="govuk-label" for="file-upload-1">
          Upload catalogue (JSON file)
        </label>
        <input class="govuk-file-upload" id="file_upload_1" name="file_upload_1" type="file">
      </div>
      <button class="govuk-button" data-module="govuk-button" type="submit">
        Upload file and import catalogue
      </button>
    </form>
  </main>
</div>
@endsection
