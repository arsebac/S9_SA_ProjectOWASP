<?php
/**
 * OWASP - Open Web Application Security Project
 * ____________________________________
 * Copyright 2018
 *
 * ____________________________________
 *
 * @categories	Security Project
 * @package		Mini-CMS
 * @author		Nikita ROUSSEAU
 * @author		Joël CANCELA
 * @author		Francois MELKONIAN
 * @copyright	2018
 */

//Prevent direct access
if (!defined('LICENSE'))
{
    exit('Access Denied');
}

// Display management panel

// Get articles
$sth = $dbh->prepare("
    SELECT *
    FROM ".DBNAME.".".DBPREFIX."article
    ;"
);

$sth->execute();

$articles = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="table-responsive">
    <table class="table table-condensed table-bordered table-hover">
        <thead>
        <tr>
            <th width="48">#</th>
            <th>Titre</th>
            <th width="160">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php

        if (!empty($articles))
        {
            foreach ($articles as $article)
            {
                ?>
                <tr>
                    <td><?php echo $article['id']; ?></td>
                    <td><?php echo $article['title']; ?></td>
                    <td>
                        <a href="dashboard.php?view=article&amp;task=edit&amp;id=<?php echo $article['id']; ?>" type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span>&nbsp;Editer</a>&nbsp;
                        <a href="#" onclick="deleteArticle('<?php echo $article['id']; ?>', '<?php echo htmlspecialchars($article['title'], ENT_QUOTES); ?>')" type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span>&nbsp;Supprimer</a>
                    </td>
                </tr>
                <?php
            }
        }

        unset($articles);

        ?>
        </tbody>
    </table>
</div>

<script>
    function deleteArticle( id, name )
    {
        if (confirm("Supprimer "+name+" ?"))
        {
            window.location.href='process.php?task=article%20del&id='+id;
        }
    }
</script>
