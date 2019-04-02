<span>Do you really want to delete user <?= $data['deleted']['login']?> with id = <?= $data['deleted']['id']?> ?</span>

<form action="/mvc_project/customers/delete/<?=$data['deleted']['id']?>" method="post">
    <input type="submit" name="yes" value="Yes" />
</form>
<form action="/mvc_project/products/delete" method="post">
    <input type="submit" name="no" value="No"/>
</form>