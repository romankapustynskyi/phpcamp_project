<span>Do you really want to delete category <?= $data['deleted']['category_name']?> with id = <?= $data['deleted']['id']?> ?</span>

<form action="/mvc_project/categories/delete/<?=$data['deleted']['id']?>" method="post">
    <input type="submit" name="yes" value="Yes" />
</form>
<form action="/mvc_project/categories/delete" method="post">
    <input type="submit" name="no" value="No"/>
</form>