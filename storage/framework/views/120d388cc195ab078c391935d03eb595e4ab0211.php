<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"><h3> <?php echo e($cylinder->cylinder); ?></h3></div>
                    <br/>
                    <div class="card-body">

                        <a href="<?php echo e(url('/'.$controller)); ?>" title="Atrás"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button></a>
                        <a href="<?php echo e(url('/'.$controller.'/' . $cylinder->id . '/edit')); ?>" title="Editar"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                        <form method="POST" action="<?php echo e(url('/'.$controller . '/' . $cylinder->id)); ?>" accept-charset="UTF-8" style="display:inline">
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
                                        <th>ID</th><td><?php echo e($cylinder->id); ?></td>
                                    </tr>
                                    <tr>
                                        <th> Código </th>
                                        <td> <?php echo e($cylinder->code); ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Código externo </th>
                                        <td> <?php echo e($cylinder->external_code); ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Observaciones </th>
                                        <td> <?php echo e($cylinder->observation); ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Tipo </th>
                                        <td> <?php echo e(isset($cylinder->cylindertype->cylindertype) ? $cylinder->cylindertype->cylindertype : ''); ?> </td>
                                    </tr>
                                    <tr>
                                        <th> Capacidad </th>
                                        <td> <?php echo e(isset($cylinder->cylindertype->capacity) ? $cylinder->cylindertype->capacity : ''); ?> </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            <h4>Movimientos</h4>
                            <div class="table-responsive">     
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Movimiento</th>
                                            <th>Cliente / Proveedor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $cylinder->moves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $move): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($move->date_of); ?></td>
                                                <td><?php echo e($move->movetype->movetype); ?></td>
                                                <td><?php echo e(isset($move->customer->name) ? $move->customer->name : $move->provider->name); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>     
                              
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>