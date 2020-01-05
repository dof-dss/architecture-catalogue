<!--
  *
  * Simple select component (key and value are the same) using GOV.UK styling and pattern
  *
-->
@error($name)
    <div class="govuk-form-group govuk-form-group--error">
        <label class="govuk-label" for="{{ $name }}">
            {{ $label }}
        </label>
        <span id="{{ $name }}-error" class="govuk-error-message">
            <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <select class="govuk-select govuk-input--error" id="{{ $name }}" name="{{ $name }}">
            @if (isset($blank))
                <option value="" selected></option>
            @endif
            @foreach ($values as $v)
                @if (isset($value) && ($value == $v))
                    <option value="{{ $v }}" selected>{{ $v }}</option>
                @else
                    <option value="{{ $v }}">{{ $v }}</option>
                @endif
            @endforeach
        </select>
    </div>
@else
    <div class="govuk-form-group">
        <label class="govuk-label" for="{{ $name }}">
            {{ $label }}
        </label>
        <select class="govuk-select" id="{{ $name }}" name="{{ $name }}">
            @if (isset($blank))
                <option value="" selected></option>
            @endif
            @foreach ($values as $v)
                @if (isset($value) && ($value == $v))
                    <option value="{{ $v }}" selected>{{ $v }}</option>
                @else
                    <option value="{{ $v }}">{{ $v }}</option>
                @endif
            @endforeach
        </select>
    </div>
@enderror
