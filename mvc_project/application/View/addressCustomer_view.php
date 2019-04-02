<body>
    <a href="/mvc_project/customers">Back</a>
    <form action="/mvc_project/customers/address/<?= $data['customer']['id'] ?>" method="post">
        <label for="login">Login</label><br>
        <input type="text" name="login" id="login" value="<?= $data['customer']['login'] ?>" disabled>

        <br><label for="country">Country</label><br>
        <input type="text" name="country" id="country" value="<?= $data['address']['country'] ?>">
        <span class="error"><?= $data['errors']['country'] ?></span>

        <br><label for="city">City</label><br>
        <input type="text" name="city" id="city" value="<?= $data['address']['city'] ?>">
        <span class="error"><?= $data['errors']['city'] ?></span>

        <br><label for="address">Address</label><br>
        <input type="text" name="address" id="address" value="<?= $data['address']['address'] ?>">
        <span class="error"><?= $data['errors']['address'] ?></span>

        <input type="submit" value="Send" name="send">

    </form>
</body> 