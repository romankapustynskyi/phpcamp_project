<body>
    <form action="/mvc_project/users/login" method="post">
        <span><?= $data['errors']['general'] ?></span>

        <input type="text" name="login" id="login" value="" placeholder="Login">
        <span><?= $data['errors']["login"] ?></span>

        <input type="password" name="password" id="password" value="" placeholder="Password">
        <span><?= $data['errors']["password"] ?></span>

        <input type="submit" value="Send" name="send">
    </form>
</body> 