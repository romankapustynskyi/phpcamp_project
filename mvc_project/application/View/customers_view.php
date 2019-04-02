<body>
    <a href="/mvc_project/customers/add">Add Customer</a>
    <table>
    <tr>
    <th>ID</th>
    <th>Login</th>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>email</th>
    <th></th>
    </tr>

    <?php for ($i=0; $i < count($data['customers']); $i++) : ?>
    <tr>
    <td><?= $data['customers'][$i]['id']?></td>
    <td><?=$data['customers'][$i]['login']?></td>
    <td><?=$data['customers'][$i]['firstname']?></td>
    <td><?=$data['customers'][$i]['lastname']?></td>
    <td><?=$data['customers'][$i]['email']?></td>
    <td><a href="/mvc_project/customers/edit/<?=$data['customers'][$i]['id']?>">Edit</a></td>
    <td><a href="/mvc_project/customers/address/<?=$data['customers'][$i]['id']?>">Address</a></td>
    <td><a href="/mvc_project/customers/delete/<?=$data['customers'][$i]['id']?>">Delete</a></td>
    </tr>
    <?php endfor; ?>
    
    </table>
</body> 