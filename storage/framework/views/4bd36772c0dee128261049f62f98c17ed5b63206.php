<?php if($item['submenu'] == []): ?>
    <li>
        <a href="<?php echo e(url($item['name'])); ?>"><?php echo e($item['name']); ?> </a>
    </li>
<?php else: ?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo e($item['name']); ?> <span class="caret"></span></a>
        <ul class="dropdown-menu sub-menu">
            <?php $__currentLoopData = $item['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($submenu['submenu'] == []): ?>
                    <li><a href="<?php echo e(url('',['id' => '', 'slug' => $submenu['slug']])); ?>"><?php echo e($submenu['name']); ?> </a></li>
                <?php else: ?>
                    <?php echo $__env->make('partials.menu-item', [ 'item' => $submenu ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </li>
<?php endif; ?>