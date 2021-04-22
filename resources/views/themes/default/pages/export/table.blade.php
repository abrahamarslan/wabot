<table>
    <?php $i = 1; ?>
    <thead>
    <tr>
        <th>Campaign</th>
        <th>Sequence</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Response</th>
    </tr>
    </thead>
    <tbody>
    @foreach($messages as $message)
        <tr>
            <td>{{ $message->campaign()->first()->title }}</td>
            <td>{{ $message->sequence()->first()->title }}</td>
            <td>{{ $message->contact()->first()->name }}</td>
            <td>{{ '+' . $message->contact()->first()->country_code . $message->contact()->first()->contact }}</td>
            <td>{{ $message->body }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
