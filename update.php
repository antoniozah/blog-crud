<?php
/**
 *  Update Single Post Item
 */

require_once "connection.php";

$id = $_GET['postid'] ?? null;

if(!$id) {
    header("Location: index.php");
    exit;
}

$statement = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$statement->bindValue(':id', $id);
$statement->execute();

$post = $statement->fetch(PDO::FETCH_ASSOC);


$errors = [];
$title = $post['title'];
$content = $post['content'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content']; 

    if (!$title) {
        $errors[] = 'Title required!';
    }
    
    if (!$content) {
        $errors[] = 'Content required!';
    }

    if(!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        $imagePath = $post['featured_img'];

        

        if($image && $image['tmp_name']) {
            if($post['featured_img']) {
                unlink($post['featured_img']);
            }

            $imagePath = 'images/' .generateRandomString(10) .'/' .$image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
    
        $statement = $pdo->prepare("UPDATE posts SET title = :title, content = :content, featured_img = :image WHERE id = :id ");
    
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':id', $id);
        $statement->execute();

        header("Location: index.php");
    }
}

function generateRandomString($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $n; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



?>




<?php include('./templates/header.php') ?>
        
<div class="my-5 px-3 page-content">
    <div class="container">
        <h2 class="my-4 fs-3 fw-bold">Update <strong><?php echo $post['title']; ?></strong> article</h2>
        <?php if(!empty($errors)) : ?>
            <div class="errors">
                <?php foreach( $errors as $error ) : ?>
                    <div class="alert alert-danger mb-1"><?php echo $error; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data"> 
            <div class="mb-3">
                <label class="form-label">Post Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Post Content</label>
                <textarea type="text" class="form-control" rows="20" name="content"><?php echo htmlspecialchars( $content ); ?></textarea>
            </div>
            <?php if($post['featured_img']) : ?>
                <figure class="post-preview-img img-fluid">
                    <img src="<?php echo $post['featured_img'] ?>" alt="<?php echo $post['id'] ?>">
                </figure>
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label">Featured Image: </label>
                <input type="file" name="image">
            </div>
            <button type="submit" class="btn btn-lg my-3 px-5 btn-primary ">Update</button>
        </form>
    </div>
</div> <!-- ./page-content -->

<?php include('./templates/footer.php'); ?>