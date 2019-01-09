

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"><h3> <?php echo e($provider->name); ?></h3></div>
                    <br/>
                    <div class="card-body">

                        <a href="<?php echo e(url('/'.$controller)); ?>" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
                        <a href="<?php echo e(url('/'.$controller.'/' . $provider->id . '/edit')); ?>" title="Editar"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                        <form method="POST" action="<?php echo e(url('/'.$controller . '/' . $provider->id)); ?>" accept-charset="UTF-8" style="display:inline">
                            <?php echo e(method_field('DELETE')); ?>

                            <?php echo e(csrf_field()); ?>

                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm(&quot;Cofirmar eliminación?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td><?php echo e($provider->id); ?></td>
                                    </tr>
                                    <tr>
                                        <th> Razón social </th>
                                        <td> <?php echo e($provider->name); ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Cuit </th>
                                        <td> <?php echo e($provider->cuit); ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Telefono </th>
                                        <td> <?php echo e($provider->telephone); ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Dirección </th>
                                        <td> <?php echo e($provider->address); ?> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>