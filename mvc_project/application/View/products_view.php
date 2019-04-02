<body>
    <a href="/mvc_project/products/add">Add Product</a>
    <table>
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>SKU</th>
    <th>Price</th>
    <th>Quantity</th>
    </tr>

    <?php for ($i=0; $i < count($data['products']); $i++) : ?>
    <tr>
    <td><?= $data['products'][$i]['id']?></td>
    <td><?=$data['products'][$i]['product_name']?></td>
    <td><?=$data['products'][$i]['sku']?></td>
    <td><?=$data['products'][$i]['price']?></td>
    <td><?=$data['products'][$i]['qty']?></td>
    <td><a href="/mvc_project/products/edit/<?=$data['products'][$i]['id']?>">Edit</a></td>
    <td><a href="/mvc_project/products/delete/<?=$data['products'][$i]['id']?>">Delete</a></td>
    </tr>
    <?php endfor; ?>
    
    </table>
</body> 