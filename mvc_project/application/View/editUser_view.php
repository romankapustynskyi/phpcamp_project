<body>
<a href="/mvc_project/users/account"></a>
<form action="/mvc_project/users/editUser" method="post">
    <label for="login">Login</label><br>
    <input type="text" name="login" id="login" value="<?= $data['userData']['login'] ?>" disabled>

    <br><label for="email">Email</label><br>
    <input type="email" name="email" id="email" value="<?= $data['userData']['email'] ?>">
    <span class="error"><?= $data['errors']['email'] ?></span>

    <br><label for="firstname">Firstname</label><br>
    <input type="text" name="firstname" id="firstname" value="<?= $data['userData']['firstname'] ?>">
    <span class="error"><?= $data['errors']['firstname'] ?></span>

    <br><label for="lastname">Lastname</label><br>
    <input type="text" name="lastname" id="lastname" value="<?= $data['userData']['lastname'] ?>">
    <span class="error"><?= $data['errors']['lastname'] ?></span>

    <br><label for="phone">Phone</label><br>
    <input type="text" name="phone" id="phone" value="<?= $data['userData']['phone'] ?>">
    <span class="error"><?= $data['errors']['phone'] ?></span>

    <br><label for="age">Age</label><br>
    <input type="number" name="age" id="age" min="0" max="120" value="<?= $data['userData']['age'] ?>">
    <span class="error"><?= $data['errors']['age'] ?></span>

    <br><label for="">Gender</label><br>
    <input type="radio" name="sex" id="male" value="1" <?= ($data['userData']['sex'] == 1) ? 'checked' : ''; ?>>
    <label for="male">Male</label>
    <input type="radio" name="sex" id="female" value="2" <?= ($data['userData']['sex'] == 2) ? 'checked' : ''; ?>>
    <label for="female">Female</label>
    <span class="error"><?= $data['errors']['sex'] ?></span>

    <input type="submit" value="Send" name="send">

</form>   
</body>