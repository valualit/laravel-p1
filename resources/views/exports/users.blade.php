<table>
    <thead>
    <tr>
        <th style="width:25;color:#ff0000">Name</th>
        <th style="width:50px;color:#ffff00">Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
        </tr>
    @endforeach
    </tbody>
</table>