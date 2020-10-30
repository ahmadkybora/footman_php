<?php $__env->startSection('title','categories'); ?>
<?php $__env->startSection('data-page-id','categories'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="jumbotron">
            <h1>categories</h1>
            
                
            
            
            <form action="/admin/product/categories/store" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>">
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <br>
            <br>
            <table class="table table-striped table-bordered table-hover">
                <thead class="text-center">
                <tr>
                    <td>number</td>
                    <td>name</td>
                    <td>slug</td>
                    <td>created_at</td>
                    <td>options</td>
                </tr>
                </thead>
                <tbody class="text-center">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($count ++); ?></td>
                    <td><?php echo e($category['name']); ?></td>
                    <td><?php echo e($category['slug']); ?></td>
                    <td><?php echo e($category['created_at']); ?></td>
                    <td>
                        <a href="" class="btn btn-primary">Show</a>
                        <a href="<?php echo e($category['id']); ?>" class="btn btn-success">Edit</a>
                        <form>
                            <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo e($category['id']); ?>" placeholder="Enter Name">
                            </div>
                            <button type="submit" class="btn btn-primary" id="<?php echo e($category['id']); ?>">update</button>
                        </form>
                        <a href="" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php echo $links; ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layers.panel.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\footman_php\resources\views/panel/categories/index.blade.php ENDPATH**/ ?>