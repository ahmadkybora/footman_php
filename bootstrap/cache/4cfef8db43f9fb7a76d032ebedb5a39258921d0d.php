<?php $__env->startSection('title','categories'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="jumbotron">
            <form action="" method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <input type="email" class="form-control" id="name" name="name" placeholder="Enter Name">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layers.panel.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\footman_php\resources\views/panel/categories/create.blade.php ENDPATH**/ ?>