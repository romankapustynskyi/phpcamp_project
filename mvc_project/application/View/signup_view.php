<form action="/mvc_project/users/signup" method="post">
    <label for="login">Login</label><br>
    <input type="text" name="login" id="login" value="<?= $data['inputData']['login'] ?>">
    <span class="error"><?= $data['errors']['login'] ?></span>

    <br><label for="password">Password</label><br>
    <input type="password" name="password" id="password" value="" >
    <span class="error"><?= $data['errors']['password'] ?></span>

    <br><label for="confirm_password">Confirm Password</label><br>
    <input type="password" name="confirm_password" id="confirm_password" value="" >
    <span class="error"><?= $data['errors']['confirm_password'] ?></span>

    <br><label for="email">Email</label><br>
    <input type="email" name="email" id="email" value="<?= $data['inputData']['email'] ?>">
    <span class="error"><?= $data['errors']['email'] ?></span>

    <br><label for="firstname">Firstname</label><br>
    <input type="text" name="firstname" id="firstname" value="<?= $data['inputData']['firstname'] ?>">
    <span class="error"><?= $data['errors']['firstname'] ?></span>

    <br><label for="lastname">Lastname</label><br>
    <input type="text" name="lastname" id="lastname" value="<?= $data['inputData']['lastname'] ?>">
    <span class="error"><?= $data['errors']['lastname'] ?></span>

    <br><label for="phone">Phone</label><br>
    <input type="text" name="phone" id="phone" value="<?= $data['inputData']['phone'] ?>" placeholder="+38099-22-22-323">
    <span class="error"><?= $data['errors']['phone'] ?></span>

    <br><label for="age">Age</label><br>
    <input type="number" name="age" id="age" min="0" max="120" value="<?= $data['inputData']['age'] ?>">
    <span class="error"><?= $data['errors']['age'] ?></span>

    <br><label for="">Gender</label><br>
    <input type="radio" name="sex" id="male" value="1" <?php if (isset($data['inputData']['sex']) && ($data['inputData']['sex'] == 1)) echo 'checked'; ?>>
    <label for="male">Male</label>
    <input type="radio" name="sex" id="female" value="2" <?php if (isset($data['inputData']['sex']) && ($data['inputData']['sex'] == 2)) echo 'checked'; ?>>
    <label for="female">Female</label>
    <span class="error"><?= $data['errors']['sex'] ?></span>

    <input type="submit" value="Send" name="send">

</form> 