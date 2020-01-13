<!--
  *
  * Simple select component (key and value are the same) using GOV.UK styling and pattern
  *
-->
@error($name)
    <div class="govuk-form-group govuk-form-group--error">
        @if (isset($label))
            <label class="govuk-label" for="{{ $name }}">
                {{ $label }}
            </label>
        @endif
        <span id="{{ $name }}-error" class="govuk-error-message">
            <span class="govuk-visually-hidden">Error:</span> {{ $message }}
        </span>
        <select class="govuk-select {{ $width ?? '' }} govuk-input--error" id="{{ $name }}" name="{{ $name }}">
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
        @if (isset($label))
            <label class="govuk-label" for="{{ $name }}">
                {{ $label }}
            </label>
        @endif
        <select class="govuk-select {{ $width ?? '' }}" id="{{ $name }}" name="{{ $name }}">
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
