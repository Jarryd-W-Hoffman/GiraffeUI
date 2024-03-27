<table class="min-w-full divide-y divide-gray-700 dark:divide-gray-400 text-gray-800 dark:text-gray-300">
    <thead class="bg-gray-100 dark:bg-gray-900">
        <tr>
            @foreach ($columns as $column)
                @if (!in_array($column, $hiddenColumns))
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                        {{ $column }}
                    </th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody class="bg-gray-100 dark:bg-gray-900 divide-y divide-gray-700 dark:divide-gray-400">
        @foreach ($rows as $row)
            <tr>
                @foreach ($columns as $column)
                    @if (!in_array($column, $hiddenColumns))
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $row[$column] }}
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
