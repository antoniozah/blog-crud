<?php 
/**
 *  Display Header of the Page
 */

?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.css" integrity="sha512-IOs1XMJ8vPmQX+aSgwGt8nA1wMAvqt5CKH9sqxUnhGdnrAdPZGPwoQexsOexknQHFurLbq2bFLh1WTk2vbGmOQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="app.css">

        <title>Basic Blog App</title>
    </head>
    <body>
    <?php   
        $currentpage = $_SERVER['REQUEST_URI'];
        // echo '<pre>';
        // var_dump($currentpage);
        // echo '</pre>';

        if(substr($currentpage, -1) === '/' || strpos($currentpage, '/index.php' ) !== false) : ?>
            <header class="header mb-5 p-3 bg-light">
                <div class="container">
                    <div class="header-wrapper d-flex justify-content-between">
                        <h1 class="fw-bold">MyBlog</h1>
                        <a href="create.php" class="btn btn-success">Add New</a>
                    </div>
                </div>
            </header>
        <?php else : ?>
            <header class="header mb-5 p-3 bg-light">
                <div class="container">
                    <div class="header-wrapper d-flex justify-content-between">
                        <h1 class="fw-bold">MyBlog</h1>
                        <a href="index.php" class="btn btn-outline-primary">Go home</a>
                    </div>
                </div>
            </header>
        <?php endif; ?>                       

