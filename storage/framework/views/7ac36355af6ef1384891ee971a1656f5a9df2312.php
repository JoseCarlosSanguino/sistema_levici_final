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
                                    <th>#</th><th>Número</th><th>Fecha</th><th>Cliente</th><th>Importe</th><th>Estado</th><th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(isset($loop->iteration) ? $loop->iteration : $sale->id); ?></td>
                                    <td><?php echo e(isset($sale->operation->FullNumber) ? $sale->operation->FullNumber : ''); ?></td>
                                    <td><?php echo e($sale->operation->date_of); ?></td>
                                    <td><?php echo e(isset($sale->customer->name) ? $sale->customer->name : ''); ?></td>
                                    <td><?php echo e($sale->operation->amount); ?></td>
                                    <td><?php echo e(isset($sale->operation->status->status) ? $sale->operation->status->status : ''); ?></td>
                                    <td>
                                        <a href="<?php echo e(url('/remitopdf/' . $sale->id)); ?>" target="_blank" title="Ver <?php echo e($modelName); ?>"><button class="btn btn-info btn-sm"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> <?php echo $operations->appends(['search' => Request::get('search')])->render(); ?> </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>