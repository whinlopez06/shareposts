<?php require APPROOT . '/views/inc/header.php'; ?>

    <?php if(Session::exists('post_message')) :?>    
        <?php echo '<div class="alert alert-success">' . Session::flash('post_message') . '</div>'; ?>
    <?php endif; ?>
    
    <!--margin bottom-->
    <div class="row mb-3">

        <div class="col-md-6">
            <h1>Posts</h1> 
        </div>

        <div class="col-md-6">
            <!--column of 6 and link but with button class-->
            <a href="<?= URLROOT; ?>/posts/add" class="btn btn-primary pull-right">
                <!--font awesome class pensil like icon-->
                <i class="fa fa-pencil"></i> Add Post
            </a>
        </div>
    </div>

    <?php foreach($data['posts'] as $post) : ?>
        <div class="card card-body mb-3">
            <h4 class="card-title"><?php echo $post->title; ?></h4>
            <div class="bg-light p-2 mb-3">
                Written by: <?= $post->name; ?> on <?= $post->created_at; ?>
            </div>
            <p class="card-text"><?= $post->body; ?></p>
            <a href="<?= URLROOT; ?>/posts/show/<?= $post->postId; ?>" class="btn btn-dark">More</a>
        </div>
    <?php endforeach; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>