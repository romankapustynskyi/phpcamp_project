<body>
    <a href="/mvc_project/categories">Back</a>
    <form action="/mvc_project/categories/edit/<?=$data['edited']['id']?>" method="post">
        <label for="category_name">Category Name</label>
        <input type="text" name="category_name" id="category_name" value="<?=$data['edited']['category_name']?>">
        <span class="error"><?= $data['errors']['category_name'] ?></span><br>

        <label for="parent">Parent Category</label>
        <select name="parent" id="parent">
            <option value="0">0</option>
            <?php for ($i = 0; $i < count($data['categories']); $i++) : ?>
            <?php if ($data['categories'][$i]['id'] != $data['edited']['id']) :?>
            <option value="<?=$data['categories'][$i]['id']?>" <?php if($data['categories'][$i]['id'] == $data['edited']['parent']) echo "selected"?>><?= $data['categories'][$i]['category_name'] ."-" .$data['categories'][$i]['id']?></option>
            <?php endif; ?>
            <?php endfor; ?>
        </select>
        <span class="error"><?= $data['errors']['parent'] ?></span><br>

        <input type="submit" value="Send" name="send">
    </form>
</body> 