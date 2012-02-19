<?php

require "Config.php";
$dbConfig = Config::getDbConfig();
$defaultDbConfig = $dbConfig[Config::getDefaultDbConfig()];
if (file_exists("{$defaultDbConfig['database']}.php")) {
    require "{$defaultDbConfig['database']}.php";
}
require "Post.php";
$db = new $defaultDbConfig['database']($defaultDbConfig['host'], $defaultDbConfig['user'], $defaultDbConfig['password'], $defaultDbConfig['dbName']);
$p = new Post($db);
//$p->id = 7;
$p->title = "This is test title 5.";
$p->content = "This is test content 7.";
$allPosts = $p->viewBy('object', array('id','title', 'content'),'content','This is test content 7.');
if(count($allPosts)){
?>
    <table border="1" width="100%" cellspacing="3" cellpadding="3">
    <thead>
        <tr>
            <th>ID</th>
            <th>TITLE</th>
            <th>CONTENT</th>
        </tr>
    </thead>
    <?php
    foreach($allPosts as $post){
    ?>
        <tbody>
            <tr>
                <td><?php echo $post->id;?></td>
                <td><?php echo $post->title;?></td>
                <td><?php echo $post->content;?></td>
            </tr>
        </tbody>
    <?php
    }
    ?>
    </table>
<?php
}
//$p->deleteById(6);
//$p->updateBy('title', 'This is test title 5.');
?>
