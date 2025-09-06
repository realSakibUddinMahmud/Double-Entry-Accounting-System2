<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="submenu-open">
                <h6 class="submenu-hdr">Home</h6>
                <ul>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard-view')): ?>
                    <li>
                        <a href="<?php echo e(route('home')); ?>">
                            <i class="ti ti-layout-grid fs-16 me-2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('superadmin-access')): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);"><i class="ti ti-user-edit fs-16 me-2"></i><span>Super Admin</span><span class="menu-arrow"></span></a>
                        <ul>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('company-view')): ?>
                            <li><a href="<?php echo e(route('companies.index')); ?>">Companies</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['product-view', 'category-view', 'brand-view', 'unit-view'])): ?>
            <li class="submenu-open">
                <h6 class="submenu-hdr">Inventory</h6>
                <ul>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-view')): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);"><i data-feather="box"></i><span>Products</span><span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="<?php echo e(route('products.index')); ?>">Products</a></li>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-create')): ?>
                            <li><a href="<?php echo e(route('products.create')); ?>">Create Product</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-view')): ?>
                    <li><a href="<?php echo e(route('categories.index')); ?>"><i class="ti ti-list-details fs-16 me-2"></i><span>Category</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-view')): ?>
                    <li><a href="<?php echo e(route('brands.index')); ?>"><i class="ti ti-triangles fs-16 me-2"></i><span>Brands</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('unit-view')): ?>
                    <li><a href="<?php echo e(route('units.index')); ?>"><i class="ti ti-brand-unity fs-16 me-2"></i><span>Units</span></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock-adjustment-view')): ?>
            <li class="submenu-open">
                <h6 class="submenu-hdr">Stock</h6>
                <ul>
                    <li><a href="<?php echo e(route('stock-adjustments.index')); ?>"><i class="ti ti-stairs-up fs-16 me-2"></i><span>Stock Adjustment</span></a></li>
                </ul>
            </li>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sale-view')): ?>
            <li class="submenu-open">
                <h6 class="submenu-hdr">Sales</h6>
                <ul>
                    <li><a href="<?php echo e(route('sales.index')); ?>"><i class="ti ti-file-invoice fs-16 me-2"></i><span>Sales</span></a></li>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sale-create')): ?>
                    <li><a href="<?php echo e(route('sales.create')); ?>"><i class="ti ti-file-plus fs-16 me-2"></i><span>Create Sale</span></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-view')): ?>
            <li class="submenu-open">
                <h6 class="submenu-hdr">Purchases</h6>
                <ul>
                    <li><a href="<?php echo e(route('purchases.index')); ?>"><i class="ti ti-shopping-bag fs-16 me-2"></i><span>Purchases</span></a></li>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase-create')): ?>
                    <li><a href="<?php echo e(route('purchases.create')); ?>"><i class="ti ti-shopping-cart-plus fs-16 me-2"></i><span>Create Purchase</span></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['de-account-view', 'de-fund-transfer-view', 'de-payment-view', 'de-income-revenue-view', 'de-loan-investment-view', 'de-loan-invreturn-view', 'de-security-deposit-view', 'de-expense-view', 'de-journal-view', 'de-ledger-view', 'tax-view'])): ?>
            <li class="submenu-open">
                <h6 class="submenu-hdr">Finance & Accounts</h6>
                <ul>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-account-view')): ?>
                    <li><a href="<?php echo e(route('de-account.index')); ?>"><i class="ti ti-building-bank fs-16 me-2"></i><span>Accounts</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-fund-transfer-view')): ?>
                    <li><a href="<?php echo e(route('de-fund-transfer.index')); ?>"><i class="ti ti-arrows-exchange fs-16 me-2"></i><span>Fund Transfer</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-payment-view')): ?>
                    <li><a href="<?php echo e(route('de-payment.index')); ?>"><i class="ti ti-credit-card fs-16 me-2"></i><span>Payments</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-income-revenue-view')): ?>
                    <li><a href="<?php echo e(route('de-income-revenue.index')); ?>"><i class="ti ti-cash fs-16 me-2"></i><span>Income Revenue</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-loan-investment-view')): ?>
                    <li><a href="<?php echo e(route('de-loan-investment.index')); ?>"><i class="ti ti-pig-money fs-16 me-2"></i><span>Loan/Investment</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-loan-invreturn-view')): ?>
                    <li><a href="<?php echo e(route('de-loan-invreturn.index')); ?>"><i class="ti ti-rotate fs-16 me-2"></i><span>Loan/Investment Return</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-security-deposit-view')): ?>
                    <li><a href="<?php echo e(route('de-security-deposit.index')); ?>"><i class="ti ti-lock fs-16 me-2"></i><span>Security Deposit</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-expense-view')): ?>
                    <li><a href="<?php echo e(route('de-expense.index')); ?>"><i class="ti ti-file-stack fs-16 me-2"></i><span>Expenses</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-journal-view')): ?>
                    <li><a href="<?php echo e(route('de-journal.index')); ?>"><i class="ti ti-notebook fs-16 me-2"></i><span>Journal</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('de-ledger-view')): ?>
                    <li><a href="<?php echo e(route('de-ledger.index')); ?>"><i class="ti ti-book fs-16 me-2"></i><span>Ledger</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax-view')): ?>
                    <li><a href="<?php echo e(route('taxes.index')); ?>"><i class="ti ti-file-infinity fs-16 me-2"></i><span>Tax</span></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['customer-view', 'supplier-view', 'store-view'])): ?>
            <li class="submenu-open">
                <h6 class="submenu-hdr">Peoples</h6>
                <ul>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-view')): ?>
                    <li><a href="<?php echo e(route('customers.index')); ?>"><i class="ti ti-users-group fs-16 me-2"></i><span>Customers</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('supplier-view')): ?>
                    <li><a href="<?php echo e(route('suppliers.index')); ?>"><i class="ti ti-user-dollar fs-16 me-2"></i><span>Suppliers</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-view')): ?>
                    <li><a href="<?php echo e(route('stores.index')); ?>"><i class="ti ti-home-bolt fs-16 me-2"></i><span>Stores</span></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['report-sales-view', 'report-purchase-view', 'report-stock-view', 'report-balance-sheet-view', 'report-income-statement-view', 'report-trail-balance-view'])): ?>
            <li class="submenu-open">
                <h6 class="submenu-hdr">Reports</h6>
                <ul>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-sales-view')): ?>
                    <li><a href="<?php echo e(route('report.sales')); ?>"><i class="ti ti-chart-line fs-16 me-2"></i><span>Sales Report</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-purchase-view')): ?>
                    <li><a href="<?php echo e(route('report.purchase')); ?>"><i class="ti ti-chart-pie-2 fs-16 me-2"></i><span>Purchase Report</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-stock-view')): ?>
                    <li><a href="<?php echo e(route('report.stock')); ?>"><i class="ti ti-chart-donut-2 fs-16 me-2"></i><span>Inventory Report</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-income-statement-view')): ?>
                    <li><a href="<?php echo e(route('report.income-statement')); ?>"><i class="ti ti-report fs-16 me-2"></i><span>Income Statement Report</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-balance-sheet-view')): ?>
                    <li><a href="<?php echo e(route('report.balance-sheet')); ?>"><i class="ti ti-report fs-16 me-2"></i><span>Balance Sheet Report</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-balance-sheet-view')): ?>
                    <li><a href="<?php echo e(route('report.trial-balance')); ?>"><i class="ti ti-report fs-16 me-2"></i><span>Trial Balance Report</span></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-view', 'role-view', 'permission-view'])): ?>
            <li class="submenu-open">
                <h6 class="submenu-hdr">User Management</h6>
                <ul>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-view')): ?>
                    <li><a href="<?php echo e(route('admin.users.index')); ?>"><i class="ti ti-shield-up fs-16 me-2"></i><span>Users</span></a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo e(route('admin.activity-log.index')); ?>"><i class="ti ti-history fs-16 me-2"></i><span>Activity Log</span></a></li>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['role-view', 'permission-view'])): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);"><i class="ti ti-jump-rope fs-16 me-2"></i><span>Roles & Permissions</span><span class="menu-arrow"></span></a>
                        <ul>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-view')): ?>
                            <li><a href="<?php echo e(route('roles.index')); ?>">Roles</a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission-view')): ?>
                            <li><a href="<?php echo e(route('permissions.index')); ?>">Permissions</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['additional-field-view', 'company-profile-show'])): ?>
            <li class="submenu-open">
                <h6 class="submenu-hdr">Settings</h6>
                <ul>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('additional-field-view')): ?>
                    <li><a href="<?php echo e(route('additional-fields.index')); ?>"><i class="ti ti-shield-up fs-16 me-2"></i><span>Additional Field</span></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('company-profile-show')): ?>
                    <li><a href="<?php echo e(route('company.profile')); ?>"><i class="ti ti-building fs-16 me-2"></i><span>Company Profile</span></a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo e(route('admin.settings.index')); ?>"><i class="ti ti-settings fs-16 me-2"></i><span>Settings</span></a></li>
                </ul>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div><?php /**PATH /workspace/resources/views/layouts/side-menu.blade.php ENDPATH**/ ?>