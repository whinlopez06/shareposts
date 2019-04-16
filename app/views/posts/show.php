<?php require APPROOT . '/views/inc/header.php'; ?>

<a href="<?= URLROOT; ?>/posts" class="btn btn-light">
    <i class="fa fa-backward"></i> Back
</a><br/>

<h1><?= $data['post']->title; ?></h1>
<!--secondary or gray background, padding-2, maragin-bottom: 3-->
<div class="bg-secondary text-white p-2 mb-3">
    Written by: <?= $data['user']->name; ?> on <?= $data['post']->created_at; ?>    
</div>
<p><?= $data['post']->body; ?></p>

<!--user who create post can only edit and delete post-->
<?php if($data['post']->user_id == Session::get(SESSION_USER_ID)) : ?>
    <hr>
    <a href="<?= URLROOT; ?>/posts/edit/<?= $data['post']->id; ?>" class="btn btn-dark">Edit</a>
    <form class="pull-right" method="POST" action="<?= URLROOT; ?>/posts/delete/<?= $data['post']->id; ?>">
        <input type="submit" value="delete" class="btn btn-danger">
    </form>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>