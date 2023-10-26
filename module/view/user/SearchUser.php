<?php


class SearchUser
{
    public function setContent($user): string
    {
        $username = $user->getUsername();
        $mail = $user->getMail();
        $password = $user->getPassword();
        $frontname = $user->getFrontname();
        $firstconnection = $user->getFirstconnection();
        $lastconnection = $user->getLastconnection();
        $administrator = $user->getAdministrator();
        $deactivated = $user->getDeactivated();

        if ($administrator) {
            $adminOrNot = 'Retrograder';
        } else {
            $adminOrNot = 'Promouvoir';
        }
        if (!$deactivated) {
            $deacOrNot = 'Desactiver';
        } else {
            $deacOrNot = 'Activer';
        }
        return <<<HTML
        <tr>
        <td>{$username}</td>
        <td>{$mail}</td>
        <td>{$password}</td>
        <td>{$frontname}</td>
        <td>{$firstconnection}</td>
        <td>{$lastconnection}</td>
        <td>{$administrator}</td>
        <td>{$deactivated}</td>
        <td><form action="index.php" method="post">
            <input type="hidden" name="username" value="{$username}">
            <button type="submit" name="action" value="changeAdminState">$adminOrNot</button> 
            </form></td>
        <td><form action="index.php" method="post">
            <input type="hidden" name="username" value="{$username}">
            <button type="submit" name="action" value="changeAccountState">$deacOrNot</button> 
            </form></td>
        <td><form action="index.php" method="post">
            <input type="hidden" name="username" value="{$username}">
            <button type="submit" name="action" value="deleteUser">Supprimer</button> 
            </form></td></tr>

HTML;

    }

    public function show($users)
    {
        $content = '<table>' . PHP_EOL . '    <thead>
        <tr><th>username</th><th>mail</th><th>password</th><th>frontname</th><th>firstconnection</th><th>lastconnection</th><th>administrator</th><th>deactivated</th></tr>
    </thead>
    <tbody>' . PHP_EOL;
        foreach ($users as $user) {
            $content .= $this->setContent($user);
        }
        $content .= '</tbody>' . PHP_EOL . '</table>';
        (new Layout('Résultat de la recherche :', $content))->show();

    }
}