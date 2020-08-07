@extends('layouts.base')

@section('content')
<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        <h1 class="govuk-heading-l filter-heading">New personal access token</h1>

        <p class="govuk-body">
            Copy your access token somewhere safe.
        </p>

        <p class="govuk-body">
            You will not be able to see it again once you leave this page.
        </p>

        <h2 class="api-key__name">{{ $token->accessToken->name }}</h2>

        <div class="api-key" style="min-height: 60px;">
            <span id="api-key" class="api-key__key"></span>
            <input id="copy-button" type="button" class="govuk-button govuk-button--secondary api-key__button--copy" data-module="govuk-button" value="">
            </input>
        </div>

        <p class="govuk-body">
            <a class="govuk-link" href="/tokens">Back to personal access tokens</a>
        </p>
    </div>
</div>
@endsection

@section('javascript')
<script>
    var state = "visible"

    function setVisibleState() {
      document.querySelector('#api-key').innerText = "{{ $token->plainTextToken }}"
      document.querySelector('#copy-button').value = "Copy token to clipboard"
    }

    function setCopiedState() {
      document.querySelector('#api-key').innerText = "Copied to clipboard"
      document.querySelector('#copy-button').value = "Show personal access token"
    }

    function toggleState() {
      if (state == "visible") {
        setCopiedState()
        state = "copied"
      } else if (state == "copied") {
        setVisibleState()
        state = "visible"
      }
    }

    function copyToClipboard() {
      if (state == "visible") {
        /* copy the text inside the api-key span */
        selection = document.getSelection()
        range = document.createRange()
        selection.removeAllRanges();
        apiKeyNode = document.getElementById('api-key')
        range.selectNodeContents(apiKeyNode)
        selection.addRange(range)
        document.execCommand("copy")
        selection.removeAllRanges();
      }
      toggleState()
    }

    window.onload = setVisibleState
    document.querySelector('#copy-button').addEventListener("click", copyToClipboard)
</script>
@endsection
