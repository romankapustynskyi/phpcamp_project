<p>This is account view</p><br>

<table>
    <tr>
        <td>Login</td>
        <td><?=$data['loggedUser']['login']?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?=$data['loggedUser']['email']?></td>
    </tr>
    <tr>
        <td>First name</td>
        <td><?=$data['loggedUser']['firstname']?></td>
    </tr>
    <tr>
        <td>Last name</td>
        <td><?=$data['loggedUser']['lastname']?></td>
    </tr>
    <tr>
        <td>Phone</td>
        <td><?=$data['loggedUser']['phone']?></td>
    </tr>
    <tr>
        <td>Age</td>
        <td><?=$data['loggedUser']['age']?></td>
    </tr>
    <tr>
        <td>Sex</td>
        <td><?php echo ($data['loggedUser']['sex'] == 1) ? "Male" : "Female" ?></td>
    </tr>
    <tr>
        <td>Country</td>
        <td><?=$data['userAddressData']['country']?></td>
    </tr>
    <tr>
        <td>City</td>
        <td><?=$data['userAddressData']['city']?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><?=$data['userAddressData']['address']?></td>
    </tr>
</table>


<a href="/mvc_project/users/logout">Logout</a>
<a href="/mvc_project/users/editUser">Edit Account</a>
<a href="/mvc_project/users/editAddress">Edit Address</a> 