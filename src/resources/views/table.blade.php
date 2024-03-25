<table>
    <thead>
        <tr>
            @foreach ($headers as $header)
                <th>
                    {{ $header }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>
                    {{ $item }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
