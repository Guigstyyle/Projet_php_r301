<?php
    @$motsclefs=$_GET["motsclefs"];
    @$valider=$_GET["valider"];
    if(isset($valider) && !empty(trim($motsclefs))){
        include("connexion.php");
        $res=$pdo->prepare("select descg from glossaire where descg like '%$motsclefs%'"); // changer $pdo et le chemin de description
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $res->execute();
        $tab=$res->fetchAll();
        $afficher="affiche";
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title> </title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="_Assets/Styles/style.css">
    </head>
    <body>
        <form name="recherche" method="get" action="">
            <input type="text" name="motsclefs"/>
            <input type="submit" name="valider" value="Rechercher" />
        </form>
        <?php if (@$afficher=="affiche") { ?>
        <div id="resultats">
            <div id="nbr"> <?= count($tab)." ".(count($tab)>1?"résultats trouvés":"résultat trouvé") ?> </div>
            <ol>
                <?php for($i=0;$i<count($tab);$i++){ ?>
                <li> <?php echo $tab[$i]["descg"] ?> </li> //changer descg
                <?php } ?>
            </ol>
        </div>
        <?php } ?>
    </body>
</html>
