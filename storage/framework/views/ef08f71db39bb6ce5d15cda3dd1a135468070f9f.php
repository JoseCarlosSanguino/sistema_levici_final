<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3><?php echo e($title); ?></h3></div>
                <br/>
                <div class="card-body">
                
                        
                    <a href="<?php echo e(url('/'. $controller . '/create')); ?>" class="btn btn-success btn-sm" title="Nuevo <?php echo e($modelName); ?>">
                        <i class="fa fa-plus" aria-hidden="true"></i> Nuevo 
                    </a>
                    <br/><br/>

                    <?php echo Form::open(['method' => 'GET', 'url' => $controller , 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search']); ?>

                    
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" name="search" placeholder="Buscar..." value="<?php echo e(request('search')); ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search" aria-hidden="true">&nbsp;</i>
                            </button>
                        </span>
                    </div>
                    <?php echo Form::close(); ?>

                
                    <br/>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th><th>Tipo de iva</th><th>Porcentaje</th><th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $ivatypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(isset($loop->iteration) ? $loop->iteration : $item->id); ?></td>
                                    <td><?php echo e($item->ivatype); ?></td>
                                    <td><?php echo e($item->percent); ?></td>
                                    <td>
                                        <a href="<?php echo e(url('/'.$controller.'/' . $item->id)); ?>" title="Ver <?php echo e($modelName); ?>"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Ver</button></a>
                                        <a href="<?php echo e(url('/'.$controller.'/' . $item->id . '/edit')); ?>" title="Editar <?php echo e($modelName); ?>"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                                        <form method="POST" action="<?php echo e(url('/'.$controller.'' . '/' . $item->id)); ?>" accept-charset="UTF-8" style="display:inline">
                                            <?php echo e(method_field('DELETE')); ?>

                                            <?php echo e(csrf_field()); ?>

                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar <?php echo e($modelName); ?>" onclick="return confirm(&quot;Confirmar Eliminación?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> <?php echo $ivatypes->appends(['search' => Request::get('search')])->render(); ?> </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>