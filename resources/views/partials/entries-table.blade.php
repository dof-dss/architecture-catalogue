<table class="govuk-table filter-table">
  <!-- <caption class="govuk-table__caption govuk-!-margin-bottom-2">This catalogue contains {{ $catalogue_size }} entries.</caption> -->
  <thead class="govuk-table__head">
      <tr class="govuk-table__row">
          <th scope="col" class="govuk-table__header govuk-!-width-one-quarter">Name (version)</th>
          <th scope="col" class="govuk-table__header">Description</th>
          <th scope="col" class="govuk-table__header">Status</th>
          <th scope="col" class="govuk-table__header">Action</th>
      </tr>
  </thead>
  <tbody class="govuk-table__body">
      @foreach ($entries as $entry)
          <tr scope="row" class="govuk-table__row">
              <td class="govuk-table__cell">{{ $entry->name }} {{ $entry->version ? '(' . $entry->version . ')' : '' }}</td>
              <td class="govuk-table__cell">{{ $entry->description }}</td>
              <td class="govuk-table__cell">
                  <span class="{{ $labels[$entry->status] }}">{{ $entry->status }}</span>
              </td>
              <td class="govuk-table__cell">
                  <a
                      class="govuk-link"
                      href="/entries/{{ $entry->id }}?path={{ urlencode(url()->full()) }}">
                      View
                  </a>
              </td>
          </tr>
      @endforeach
  </tbody>
</table>
{{ $entries->links() }}
