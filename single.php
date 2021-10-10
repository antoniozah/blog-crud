<?php 

    require_once "./connection.php";

    $id = $_GET['postid'] ?? null; 
    if(!$id) {
        header('Location: index.php');
        exit;
    }

    $statement = $pdo->prepare("SELECT * FROM posts WHERE id = :id ");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $post = $statement->fetch(PDO::FETCH_ASSOC);

?>


<?php include('./templates/header.php') ?>
    <div class="page-content single-page my-5">
        <div class="container">
            <div class="single-page-head">
                <figure class="featured-image-bg">
                    <img class="img-fluid" src="<?php echo $post['featured_img']; ?>" alt="<?php echo $post['id']; ?>">
                </figure>
                <div class="page-head-content">
                    <div class="page-head-textarea">
                        <h2 class="post-title py-4 px-3"><?php echo $post['title']; ?></h2>
                    </div>       
                </div>
            </div><!-- ./single-page-head -->
            <div class="single-page-body"><?php echo $post['content']; ?></div>
        </div> <!-- ./container-->
    </div><!-- ./single-page -->
    
<?php include('./templates/footer.php'); ?>