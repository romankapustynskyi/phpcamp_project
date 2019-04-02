<body>
    <a href="/mvc_project/users/account">Back</a>
    <form action="/mvc_project/users/editAddress" method="post">
        <label for="login">Login</label><br>
        <input type="text" name="login" id="login" value="<?= $data['userData']['login'] ?>" disabled>

        <br><label for="country">Country</label><br>
        <input type="text" name="country" id="country" value="<?= $data['userAddressData']['country'] ?>">
        <span class="error"><?= $data['errors']['country'] ?></span>

        <br><label for="city">City</label><br>
        <input type="text" name="city" id="city" value="<?= $data['userAddressData']['city'] ?>">
        <span class="error"><?= $data['errors']['city'] ?></span>

        <br><label for="address">Address</label><br>
        <input type="text" name="address" id="address" value="<?= $data['userAddressData']['address'] ?>" placeholder="Street,building(1-3),flat(1-3)">
        <span class="error"><?= $data['errors']['address'] ?></span>

        <input type="submit" value="Send" name="send">

    </form>
</body> 