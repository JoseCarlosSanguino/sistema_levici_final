

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default col-md-8">
                    <div class="panel-header"><h3>Nuevo <?php echo e($modelName); ?></h3></div>
                    <br/>
                    <div class="panel-body">
                        <a href="<?php echo e(url('/'.$controller)); ?>" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
                        <br />
                        <br />

                        <?php if($errors->any()): ?>
                            <ul class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo e(url('/'.$controller)); ?>" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                            <?php echo e(csrf_field()); ?>


                            <?php echo $__env->make('customers.form', ['formMode' => 'create'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>