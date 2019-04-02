<body>
    <a href="/mvc_project/categories/add">Add Category</a>
    <table>
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Parent ID</th>
    </tr>

    <?php for ($i=0; $i < count($data['categories']); $i++) : ?>
    <tr>
    <td><?= $data['categories'][$i]['id']?></td>
    <td><?=$data['categories'][$i]['category_name']?></td>
    <td><?=$data['categories'][$i]['parent']?></td>
    <td><a href="/mvc_project/categories/edit/<?=$data['categories'][$i]['id']?>">Edit</a></td>
    <td><a href="/mvc_project/categories/delete/<?=$data['categories'][$i]['id']?>">Delete</a></td>
    </tr>
    <?php endfor; ?>
    
    </table>
</body> 