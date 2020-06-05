@extends('layouts.base')

@section('back')
<a href="/users" class="govuk-back-link">See all catalogue users</a>
@endsection

@section('content')
<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        @include ('partials.errors')
        <h2 class="govuk-heading-l"><span class="govuk-caption-l">User</span> {{ $user->email }}</h2>
        <table class="govuk-table">
            <tbody class="govuk-table__body">
                <tr class="govuk-table__row">
                    <th scope="row" class="govuk-table__header">Email</th>
                    <td class="govuk-table__cell">{{ $user->email }}</td>
                </tr>
            </tbody>
        </table>
        <h2 class="govuk-heading-l">Set user roles</h2>
        <form action="/users/{{ $user->id }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="{{ $user->id }}">
            <table id="roles" class="govuk-table permissions">
                <thead class="govuk-table__head">
                    <tr class="govuk-table__row">
                        <th class="govuk-table__header govuk-!-width-one-quarter" scope="col">Administrator</th>
                        <th class="govuk-table__header" scope="col">Contributor</th>
                    </td>
                </thead>
                <tbody class="govuk-table__body">
                    <tr class="govuk-table__row">
                        <td class="govuk-table__cell">
                            <div class="govuk-form-group">
                                <div class="govuk-checkboxes">
                                    <div class="govuk-checkboxes__item">
                                        <input type="checkbox" class="govuk-checkboxes__input"
                                            id="admin" name="admin" value="true" {{ $user->admin ? 'checked' : ''}} />
                                        <label class="govuk-label govuk-checkboxes__label" for="admin"><span>Administrator</span></label>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="govuk-table__cell">
                            <div class="govuk-form-group">
                                <div class="govuk-checkboxes">
                                    <div class="govuk-checkboxes__item">
                                        <input type="checkbox" class="govuk-checkboxes__input"
                                            id="role" name="role" value="contributor"
                                            {{ $user->role == 'contributor' ? 'checked' : ''}}/>
                                        <label class="govuk-label govuk-checkboxes__label" for="role"><span>Contributor</span></label>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="govuk-button" type="submit">Save role changes</button>
            <p class="govuk-body">
                <a class="govuk-link" href="/users/{{ $user->id }}/delete">Remove user</a>
            </p>
        </form>
    </div>
</div>
@endsection
