<?php

require_once __DIR__ . '/../Layout.php';

class Login
{
    public function setContent(): string
    {
        return <<<HTML
<form method="post" action="index.php">
    <label>
        Login :<br>
        <input type="text" name="usernameOrMail" placeholder="Login"> <br>
    </label>
    <label>
        Password :<br>
        <input type="password" name="password" placeholder="password"><br>
    </label>
    <button type="reset" name="cancel">Cancel</button>
    <button type="submit" name="action" value="login">Login</button>
</form>
HTML;
    }

    public function show(): void
    {
        (new \Layout('Login', $this->setContent()))->show();
    }


}