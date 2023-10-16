<?php
class Layout {
private $title;
private $content;
public function __construct(string $title, string $content)
{
    $this->content = $content;
    $this->title = $title;
}
public function show(): void {
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?= $this->title; ?></title>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
<h1>Page de <?= $this->title; ?></h1>
<a href="index.php"><button>Acueil</button></a>
<?= $this->content; ?>
</body>
</html>
<?php
}
}