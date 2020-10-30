<?php $__env->startSection('title','dashboard'); ?>

<?php $__env->startSection('content'); ?>
    
        
            
            
            
            
        
    
    <br>
    <br>

    <div class="container">
        <div class="jumbotron">
            <form action="/admin/dashboard" method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <input type="email" class="form-control" id="username" name="username" placeholder="Enter email">
                    </small>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layers.panel.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\footman_php\resources\views/panel/dashboard/home.blade.php ENDPATH**/ ?>