<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'paginator',
    'showInfo' => true,
    'infoText' => 'entries',
    'size' => 'sm' // sm, md, lg
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'paginator',
    'showInfo' => true,
    'infoText' => 'entries',
    'size' => 'sm' // sm, md, lg
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if($paginator->hasPages()): ?>
<div class="card-footer admin-pagination-footer">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <?php if($showInfo): ?>
        <div class="pagination-info">
            <span class="text-muted">
                Showing <?php echo e($paginator->firstItem() ?? 0); ?> to <?php echo e($paginator->lastItem() ?? 0); ?> of <?php echo e($paginator->total()); ?> <?php echo e($infoText); ?>

            </span>
        </div>
        <?php endif; ?>

        <nav aria-label="Pagination Navigation">
            <ul class="pagination pagination-<?php echo e($size); ?> mb-0 admin-pagination">
                
                <?php if($paginator->onFirstPage()): ?>
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="ti ti-chevron-left"></i>
                        </span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">
                            <i class="ti ti-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>

                
                <?php if($paginator->lastPage() > 1): ?>
                    <?php
                        $start = max(1, $paginator->currentPage() - 2);
                        $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
                        
                        // Ensure we always show 5 pages when possible
                        if ($end - $start < 4) {
                            if ($start == 1) {
                                $end = min($paginator->lastPage(), $start + 4);
                            } else {
                                $start = max(1, $end - 4);
                            }
                        }
                    ?>

                    
                    <?php if($start > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($paginator->url(1)); ?>">1</a>
                        </li>
                        <?php if($start > 2): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                    
                    <?php for($i = $start; $i <= $end; $i++): ?>
                        <?php if($i == $paginator->currentPage()): ?>
                            <li class="page-item active">
                                <span class="page-link"><?php echo e($i); ?></span>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo e($paginator->url($i)); ?>"><?php echo e($i); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    
                    <?php if($end < $paginator->lastPage()): ?>
                        <?php if($end < $paginator->lastPage() - 1): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($paginator->url($paginator->lastPage())); ?>"><?php echo e($paginator->lastPage()); ?></a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                
                <?php if($paginator->hasMorePages()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">
                            <i class="ti ti-chevron-right"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="ti ti-chevron-right"></i>
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
<?php endif; ?>

<?php if (! $__env->hasRenderedOnce('9e6c439c-c041-4088-b846-d876f58f4186')): $__env->markAsRenderedOnce('9e6c439c-c041-4088-b846-d876f58f4186'); ?>
<?php $__env->startPush('styles'); ?>
<style>
    /* Admin Pagination Styling */
    .admin-pagination {
        margin: 0;
        gap: 2px;
    }
    
    .admin-pagination .page-link {
        border: 1px solid #e9ecef;
        color: #495057;
        background-color: #fff;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
        transition: all 0.15s ease-in-out;
        text-decoration: none;
    }
    
    .admin-pagination .page-link:hover {
        background-color: #fff5f2;
        border-color: #ff6b35;
        color: #ff6b35;
        text-decoration: none;
    }
    
    .admin-pagination .page-item.active .page-link {
        background-color: #ff6b35;
        border-color: #ff6b35;
        color: #fff;
    }
    
    .admin-pagination .page-item.disabled .page-link {
        background-color: #f8f9fa;
        border-color: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
    }
    
    .admin-pagination .page-link:focus {
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        outline: 0;
    }
    
    /* Card Footer Styling */
    .admin-pagination-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        padding: 1rem;
    }
    
    .pagination-info {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    /* Size variants */
    .admin-pagination.pagination-sm .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.8125rem;
    }
    
    .admin-pagination.pagination-lg .page-link {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .admin-pagination-footer .d-flex {
            flex-direction: column;
            align-items: center !important;
            gap: 1rem !important;
        }
        
        .admin-pagination {
            justify-content: center;
        }
        
        .admin-pagination .page-link {
            padding: 0.375rem 0.5rem;
            font-size: 0.8125rem;
        }
    }
    
    @media (max-width: 576px) {
        .admin-pagination .page-link {
            padding: 0.25rem 0.375rem;
            font-size: 0.75rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /workspace/resources/views/components/admin/pagination.blade.php ENDPATH**/ ?>