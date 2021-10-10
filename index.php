<?php

require_once "./connection.php";

$statement = $pdo->prepare('SELECT * FROM posts ORDER BY created_date DESC');

$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);


function summary($str, $limit=100, $strip = false) {
    $str = ($strip == true)?strip_tags($str):$str;
    if (strlen ($str) > $limit) {
        $str = substr ($str, 0, $limit - 3);
        return (substr ($str, 0, strrpos ($str, ' ')).'...');
    }
    return trim($str);
}

?>

    <?php include('./templates/header.php') ?>

        <div class="page-content my-5">
            <div class="container">
            <div class="row">
            <?php foreach( $posts as $i => $post ) : ?>
                <div class="col-12 col-md-6">
                    <?php 
                        $small = summary($post['content'], $limit=160);
                    ?>

                <div class="card mb-3 article" style="width: 100%;">
                    <figure class="article-img">
                        <img src="<?php echo $post['featured_img'] ?>" class="card-img-top img-fluid" alt="<?php echo $post['id'];?>">
                    </figure>
                    <div class="card-body">
                        <h3 class="card-title mb-3"><?php echo $post['title']; ?></h3>
                        <p class="card-text"><?php echo $small;  ?></p>
                        <div class="post-footer w-100 d-flex align-items-center justify-content-between">
                            <a href="single.php?postid=<?php echo $post['id']; ?>" class="btn btn-primary">Read more</a>
                            <form action="delete.php" method="post" style="display: inline-block;">
                                <input type="hidden" name="id" value="<?php echo $post['id']?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                        
                    </div>
                </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        </div>

        <div class="login-modal d-none align-items-center justify-content-between">
            <form action="index.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-primary" name="btn_login">Submit</button>
            </form>
        </div>
    <?php include('./templates/footer.php'); ?>