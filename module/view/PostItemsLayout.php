<?php

class PostItemsLayout
{
    public function ticket($ticket, $limit = 0): string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $id = $ticket->getIdTicket();
        $title = $ticket->getTitle();
        $date = date('d/m/Y H\hi', strtotime($ticket->getDate()));
        $frontname = $ticket->getFrontnameByUsername();
        $username = $ticket->getUsername();
        $important = $ticket->getImportant();

        if ($limit > 0 and strlen($ticket->getMessage()) > $limit) {
            $message = substr($ticket->getMessage(), 0, $limit) . '...';
        } else {
            $message = $ticket->getMessage();
        }
        $requestCategories = $ticket->getCategories();
        $categories = '<ul class="added">';
        if (isset($requestCategories)) {
            foreach ($requestCategories as $category) {
                $categories .= '<li>' . $category->getName() . '</li>';
            }
        }
        $categories .= '</ul>';
        $requestMentions = $ticket->getMentions();
        $mentions = '<ul class="added">';
        if (isset($requestMentions)) {
            foreach ($requestMentions as $mention) {
                $mentions .= '<li>' . $mention . '</li>';
            }
        }
        $mentions .= '</ul>';

        if ($important) {
            $content = '<li class="important postItems">';
        } else {
            $content = '<li class="postItems">';
        }

        $content .=
            '<small>' . $frontname . ' - ' . $date . '</small>
<p class="ticketTitle">' . $title . '</p>
<p class="message">' . $message . '</p> 
<small class="listName">Mentions :</small>
            ' . $mentions . '
<small class="listName">Catégories :</small>
            ' . $categories . '
                <form method="post" action="index.php">
    <button type="submit" name="action" value="showTicket">Voir</button>
    <input type="hidden" name="idticket" value="' . $id . '">';
        if (isset($_SESSION['suid']) and $_SESSION['user']->getDeactivated() === 0) {
            if ($username === $_SESSION['user']->getUsername()) {
                $content .= '<button type="submit" name="action" value="toModifyTicket">Modifier</button>';
                $content .= '<button type="submit" name="action" value="deleteTicket">Supprimer</button>';
            } elseif ($_SESSION['user']->getAdministrator() === 1) {
                $content .= '<button type="submit" name="action" value="deleteTicket">Supprimer</button>';
            }

        }
        $content .= '</form>
</li>';
        return $content;
    }

    public function category($category, $limit = 0): string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $id = $category->getIdCategory();
        $name = $category->getName();
        if ($limit > 0 and strlen($category->getDescription()) > $limit) {
            $description = substr($category->getDescription(), 0, $limit) . '...';
        } else {
            $description = $category->getDescription();
        }

        $content = '
            <li class="postItems">
                <p class="ticketTitle">' . $name . '</p>
                <p class="message">' . $description . '</p>
                    <form method="post" action="index.php">
                        <input type="hidden" name="idcategory" value="' . $id . '">
                        <button type="submit" name="action" value="showCategory">Voir</button>';
        if (isset($_SESSION['suid']) and
            $_SESSION['user']->getAdministrator() === 1 and
            $_SESSION['user']->getDeactivated() === 0) {
            $content .= '<button type="submit" name="action" value="toModifyCategory">Modifier</button>';
        }
        $content .= '</form>
</li>';
        return $content;
    }

    public function comment($comment, $limit = 0): string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $important = $comment->getImportant();
        if ($important) {
            $content = '<li class="important postItems">';
        } else {
            $content = '<li class="postItems">';
        }
        if ($limit > 0 and strlen($comment->getText()) > $limit) {
            $text = substr($comment->getText(), 0, $limit) . '...';
        } else {
            $text = $comment->getText();
        }


        $content .= $comment->getFrontnameByUsername() . ' :' . PHP_EOL . '
 <small>' . date('d/m/Y H\hi', strtotime($comment->getDate())) . '</small>
<p class="message">' . $text . '</p>
<small class="listName">Mentions :</small>
<ul class="added addedUsers">';
        foreach ($comment->getMentions() as $mention) {
            $content .= '<li>' . $mention . '</li>';
        }
        $content .= '</ul>
        <form method="post" action="index.php">
        <input type="hidden" name="idcomment" value="' . $comment->getIdComment() . '">
        <div class="buttonContainer">
          <button type="submit" name="action" value="showComment">Voir</button>';


        if (isset($_SESSION['suid']) and
            $_SESSION['user']->getDeactivated() === 0 and
            ($_SESSION['user']->getUsername() === $comment->getUsername() or
                $_SESSION['user']->getAdministrator() === 1)) {
            $content .= '<button type="submit" name="action" value="deleteComment">Supprimer</button>';
        }
        $content .= '</div></form></li>';
        return $content;
    }

    public function user($user)
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
            $isAdmin = 'Oui';
        } else {
            $adminOrNot = 'Promouvoir';
            $isAdmin = 'Non';
        }
        if (!$deactivated) {
            $deacOrNot = 'Desactiver';
            $isDeactivated = 'Non';
        } else {
            $deacOrNot = 'Activer';
            $isDeactivated = 'Oui';
        }
        $content = '<li class="user">
<ul>
        <form method="post" action="index.php">
        <input type="hidden" name="username" value="' . $username . '">
        <li>Username :' . $username . '</li>
        <li>Mail :' . $mail . '</li>
        <li>Frontname :' . $frontname . '</li>
        <li>Première connexion :' . $firstconnection . '</li>
        <li>Dernière connexion :' . $lastconnection . '</li>
        <li>Administrateur :' . $isAdmin . '<button type="submit" name="action" value="changeAdminState">' . $adminOrNot . '</button></li>
        <li>Désactivé :' . $isDeactivated . '<button type="submit" name="action" value="changeAccountState">' . $deacOrNot . '</button><li>
        <button type="submit" name="action" value="deleteUser">Supprimer</button>
        </form>
</ul>';
        return $content;

    }

    public function commentUnderTicket($comment, $isSearched = 0)
    {
        if ($isSearched) {
            if ($comment->getImportant()) {
                $content = '<li id="searchedComment" class="important comment">';
            } else {
                $content = '<li id="searchedComment" class="comment"> ';
            }
        } elseif ($comment->getImportant()) {
            $content = '<li class="important comment">';
        } else {
            $content = '<li class="comment">';
        }
        if (isset($_SESSION['suid']) and
            $_SESSION['user']->getDeactivated() === 0 and
            ($_SESSION['user']->getUsername() === $comment->getUsername() or
                $_SESSION['user']->getAdministrator() === 1)) {
            $content .= '<form method="post" action="index.php">';
        }


        $content .= $comment->getFrontnameByUsername() . ' :' . PHP_EOL . '
 <small>' . date('d/m/Y H\hi', strtotime($comment->getDate())) . '</small>
<p class="message">' . $comment->getText() . '</p>

<ul class="suggestions userSuggestions">

</ul>
<small class="listName">Mentions :</small>
<ul class="added addedUsers">';
        foreach ($comment->getMentions() as $mention) {
            $content .= '<li>' . $mention . '<input type="hidden" name="selectedUsers[]" value="' . $mention . '"></li>';
        }
        $content .= '</ul>';
        if (isset($_SESSION['suid']) and
            $_SESSION['user']->getDeactivated() === 0 and
            ($_SESSION['user']->getUsername() === $comment->getUsername() or
                $_SESSION['user']->getAdministrator() === 1)) {
            $content .= $this->displayCommentButtons($comment);
        }
        $content .= '</li>';


        return $content;
    }

    function displayCommentButtons($comment): string
    {
        $content = '';
        $isImportant = ($comment->getImportant()) ? 'Pas important' : 'Important';
        if ($_SESSION['user']->getUsername() === $comment->getUsername()) {
            $content = '
<div class="buttonContainer">
    <button type="submit" name="action" value="deleteComment">Supprimer</button>';
            if ($_SESSION['user']->getAdministrator() === 1) {
                $content .= '<button type="submit" name="action" value="makeImportant">'.$isImportant.'</button>';
            }
            $content .= '
    <button class="modifyComment">Modifier</button>
</div>
    <input type="hidden" name="idcomment" value="' . $comment->getIdComment() . '">
    <input type="hidden" name="idticket" value="' . $comment->getIdTicket() . '">
</form>';

        } elseif ($_SESSION['user']->getAdministrator() === 1) {

            $content = '
<div class="buttonContainer">
    <button type="submit" name="action" value="makeImportant">'.$isImportant.'</button>
    <button type="submit" name="action" value="deleteComment">Supprimer</button>
</div>
    <input type="hidden" name="idcomment" value="' . $comment->getIdComment() . '">
    <input type="hidden" name="idticket" value="' . $comment->getIdTicket() . '">
</form>';
        }
        return $content;
    }
}