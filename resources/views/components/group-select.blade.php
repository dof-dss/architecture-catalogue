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
                <option value="" selected>{{ $blank_label ?? '' }}</option>
            @endif
            @foreach ($values as $key => $items)
                <optgroup label="{{ $key }}"</optgroup>
                @foreach ($items as $item)
                    @if (isset($value) && ($value == $item))
                        <option value="{{ $key }}-{{ $item }}" selected>{{ $item }}</option>
                    @else
                        <option value="{{ $key }}-{{ $item }}">{{ $item }}</option>
                    @endif
                @endforeach
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
                <option value="" selected>{{ $blank_label ?? '' }}</option>
            @endif
            @foreach ($values as $key => $items)
                <optgroup label="{{ $key }}"</optgroup>
                @foreach ($items as $item)
                    @if (isset($value) && ($value == $item) || old($name) == ($key . '-' . $item) )
                        <option value="{{ $key }}-{{ $item }}" selected>{{ $item }}</option>
                    @else
                        <option value="{{ $key }}-{{ $item }}">{{ $item }}</option>
                    @endif
                @endforeach
            @endforeach
        </select>
    </div>
@enderror
