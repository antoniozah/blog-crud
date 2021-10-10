<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=my_app_blog', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$errors = [];
$title = '';
$content = '';
$image = '';

// echo '<pre>';
//     var_dump($_FILES);
//     echo '</pre>';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
        $content = $_POST['content'];
        $date = date('Y-m-d H:i:s');

    if(!$title) {
        $errors[] = 'Title Required';
    }

    if(!$content) {
        $errors[] = 'Content Required';
    }

    if(!is_dir('images')) {
        mkdir('images');
    }

    // echo '<pre>';
    // var_dump($errors);
    // echo '</pre>';

    if(empty($errors)) {
        $imagePath = '';
        $image = $_FILES['image'] ?? null;
        if($image && $image['tmp_name']) {
            $imagePath = 'images/' .generateRandomString(10) .'/' .$image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
    
        $statement = $pdo->prepare("INSERT INTO posts (title, content, featured_img, created_date)
        VALUES (:title, :content, :image, :date);");
    
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':date', $date);
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


    <?php require_once "./templates/header.php" ?>
        
        <div class="my-5 px-3 page-content">
            <div class="container">
                <h2 class="my-4 fs-3 fw-bold">Add New Post</h2>
                <?php if(!empty($errors)) : ?>
                    <div class="errors">
                        <?php foreach( $errors as $error ) : ?>
                            <div class="alert alert-danger mb-1"><?php echo $error; ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="create.php" method="post" enctype="multipart/form-data"> 
                    <div class="mb-3">
                        <label class="form-label">Post Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Post Content</label>
                        <textarea type="text" class="form-control" rows="20" name="content"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Featured Image: </label>
                        <input type="file" name="image">
                    </div>
                    <button type="submit" class="btn btn-lg my-3 px-5 btn-primary ">Publish</button>
                </form>
            </div>
        </div> <!-- ./page-content -->
    
    <?php require_once "./templates/footer.php" ?>

