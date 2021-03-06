<body>
    <a href="/mvc_project/products">Back</a>
    <form action="/mvc_project/products/add" method="post" enctype="multipart/form-data">
        <label for="product_name">Product Name</label><br>
        <input type="text" name="product_name" id="product_name" value="<?=$data['inputData']['product_name']?>">
        <span class="error"><?= $data['errors']['product_name'] ?></span><br>
        
        <label for="sku">SKU</label><br>
        <input type="number" name="sku" id="sku" value="<?=$data['inputData']['sku']?>">
        <span class="error"><?= $data['errors']['sku'] ?></span><br>
        
        <label for="qty">Quantity</label><br>
        <input type="number" name="qty" id="qty" value="<?=$data['inputData']['qty']?>" step="1">
        <span class="error"><?= $data['errors']['qty'] ?></span><br>
        
        <label for="price">Price</label><br>
        <input type="number" name="price" id="price" value="<?=$data['inputData']['price']?>" step="0.01">
        <span class="error"><?= $data['errors']['price'] ?></span><br>
        
        <label for="description">Description</label><br>
        <textarea name="description" id="description" cols="30" rows="6"><?=$data['inputData']['description']?></textarea>
        <span class="error"><?= $data['errors']['description'] ?></span><br>
        
        <label for="image">Image</label><br>
        <input type="file" name="image" id="image" value="" accept=".jpeg,.jpg,.png, images/jpeg, images/png">
        <span class="error"><?= $data['errors']['image'] ?></span><br>

        <label for="category_id">Category</label><br>
        <select name="category_id" id="category_id">
            <option value="0">0</option>
            <?php for ($i = 0; $i < count($data['categories']); $i++) : ?>
            <option value=" <?= $data['categories'][$i]['id'] ?>" <?=$data['categories'][$i]['id'] == $data['inputData']['category_id'] ? "selected" : ""?>><?=$data['categories'][$i]['category_name'] ."-" .$data['categories'][$i]['id']?></option>
            <?php endfor; ?>
        </select>
        <span class="error"><?= $data['errors']['category_id'] ?></span><br>

        <input type="submit" value="Send" name="send">
    </form>
</body> 