@extends('layouts.base')

@section('back')
<a href="/admin" class="govuk-back-link">Back to admin menu</a>
@endsection

@section('content')
<div class="govuk-grid-row">
    <div class="govuk-grid-column-three-quarters">
        <h1 class="govuk-heading-l filter-heading">Catalogue users</h1>

        <div class="govuk-grid-row">
            <div class="govuk-grid-column-full">
                <table class="govuk-table filter-table">
                    <thead class="govuk-table__head">
                        <tr class="govuk-table__row">
                            <th scope="col" class="govuk-table__header">E-mail</th>
                            <th scope="col" class="govuk-table__header">Admin</th>
                            <th scope="col" class="govuk-table__header">Role</th>
                            <th scope="col" class="govuk-table__header">Action</th>
                        </tr>
                    </thead>
                    <tbody class="govuk-table__body">
                        @foreach ($users as $user)
                            <tr scope="row" class="govuk-table__row">
                                <td class="govuk-table__cell">{{ $user->email }}</td>
                                <td class="govuk-table__cell">@if ($user->admin)<i class="fa fa-check"></i>@endif</td>
                                <td class="govuk-table__cell">{{ $user->role}}</td>
                                <td class="govuk-table__cell">
                                    <a class="govuk-link" href="/users/{{ $user->id }}/edit">Change</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
