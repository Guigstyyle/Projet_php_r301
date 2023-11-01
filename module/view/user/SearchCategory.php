<?php


class SearchCategory

{
    public function setContent($category): string
    {
        $id = $category->getIdCategory();
        $name = $category->getName();
        if (strlen($category->getDescription()) > 50) {
            $description = substr($category->getDescription(), 0, 50) . '...';
        } else {
            $description = $category->getDescription();
        }
        return <<<HTML
        <tr>
        <td>{$id}</td>
        <td>{$name}</td>
        <td>{$description}</td>
        <td><form action="index.php" method="post">
            <input type="hidden" name="categoryName" value="{$name}">
            <input type="hidden" name="description" value="{$description}">
            <input type="hidden" name="idcategory" value="{$id}">
            <button type="submit" name="action" value="showCategory">Voir</button> 
            <button type="submit" name="action" value="toModifyCategory">Modifier</button> 
            </form></td>
        <td><form action="index.php" method="post">
            <input type="hidden" name="idcategory" value="{$id}">
            <button type="submit" name="action" value="deleteCategory">Supprimer</button> 
            </form></td></tr>

HTML;

    }

    public function show($categories)
    {
        $content = '<table>' . PHP_EOL . '    <thead>
        <tr><th>Id</th><th>CategoryName</th><th>Description</th></tr>
    </thead>
    <tbody>' . PHP_EOL;
        foreach ($categories as $category) {
            $content .= $this->setContent($category);
        }
        $content .= '</tbody>' . PHP_EOL . '</table>';
        (new Layout('Résultat de la recherche :', $content))->show();

    }
}