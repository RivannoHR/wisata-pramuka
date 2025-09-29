<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin-tables.css')); ?>">
<style>
    .filters-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .filters-row {
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-weight: 500;
        color: #333;
        font-size: 0.9rem;
    }

    .filter-input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
        min-width: 150px;
    }

    .filter-input:focus {
        outline: none;
        border-color: black;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .search-input {
        min-width: 250px;
    }

    .filter-button {
        background: black;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        margin-top: 20px;
        transition: background-color 0.3s;
    }

    .filter-button:hover {
        background: #555;
    }

    .scroll-x {
        overflow-x: scroll;
    }

    .table-container {
        /* This is the key for overflow scrolling */
        overflow: auto;
        /* Allows both X and Y overflow */
        flex-grow: 1;

        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        /* Ensure the table fills its container */
        border-collapse: collapse;
        table-layout: fixed;
        /* This is crucial for handling overflow */
    }

    .id-cell {
        width: 10px;
    }

    .price-cell {
        width: 100px;
    }

    .stock-cell {
        width: 50px;
        text-align: center;
    }

    .single-button-cell {
        width: 60px;
    }


    th,
    td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
        vertical-align: top;
        border-left: 1px solid #e0e0e0;
        border-right: 1px solid #e0e0e0;
        /* Ensures content aligns to the top of the cell */
    }

    th {
        background-color: #f8f8f8;
        font-weight: 600;
        color: #555;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    td {
        word-wrap: normal;
        /* Allows long words to break and wrap to the next line */
    }

    .stock-cell-header {
        font-size: small;
    }

    .description-cell {
        min-height: 50px;

    }

    .operation-cell {
        display: flex;
        gap: 10px;
        flex-direction: column;
        align-items: center;
    }

    .operation-cell button {
        width: 70px;
    }

    .status-btn {
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        color: white;
        cursor: pointer;
        font-weight: 500;
        position: relative;
        overflow: hidden;
        transition: background-color 0.3s ease;
        min-width: 60px;
    }

    .status-btn:hover {
        opacity: 60%;
    }

    .active-btn {
        background-color: #4CAF50;
    }

    .inactive-btn {
        background-color: #f44336;

    }

    .operation-container {
        background-color: white;
        width: 100%;
        font-weight: 600;
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        padding-top: 10px;
        padding-bottom: 10px;
        border-top: 1px solid #e0e0e0;
        border-radius: 0px 0px 12px 12px;
    }

    .delete-button {
        background: red;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .delete-button:hover {
        opacity: 60%;
    }

    .operation-container form {
        margin: 0;
    }

    .create-product-button {
        text-decoration: none;
        background: #4CAF50;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .create-product-button:hover {
        opacity: 60%;
    }

    .edit-product-button {
        text-decoration: none;
        background: #200fdb;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .edit-product-button:hover {
        opacity: 60%;
    }

    .edit-link {
        text-decoration: none;
        background: #200fdb;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 0.75rem;
        font-family: Arial, sans-serif;
        display: inline-block;
        margin-top: 5px;
    }

    .edit-link:hover {
        opacity: 60%;
        color: white;
        text-decoration: none;
    }
</style>

<div class="filter-section">
    <form method="GET" action="<?php echo e(route('admin.accommodations')); ?>">
        <input type="hidden" name="filter_yes" value="1">
        <div class="filters-row">
            <div class="filter-group">
                <label for="search">Search</label>
                <input type="text" id="search" name="search" class="filter-input search-input"
                    placeholder="Search hotels, locations..." value="<?php echo e(request('search')); ?>">
            </div>

            <div class="filter-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="filter-input">
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>" <?php echo e(request('type') == $value ? 'selected' : ''); ?>>
                        <?php echo e($label); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="sort">Sort By</label>
                <select id="sort" name="sort" class="filter-input">
                    <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Name</option>
                    <option value="price" <?php echo e(request('sort') == 'price' ? 'selected' : ''); ?>>Price</option>
                    <option value="rating" <?php echo e(request('sort') == 'rating' ? 'selected' : ''); ?>>Rating</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="order">Order</label>
                <select id="order" name="order" class="filter-input">
                    <option value="asc" <?php echo e(request('order') == 'asc' ? 'selected' : ''); ?>>Ascending</option>
                    <option value="desc" <?php echo e(request('order') == 'desc' ? 'selected' : ''); ?>>Descending</option>
                </select>
            </div>

            <div class="filter-group">
                <button type="submit" class="filter-button">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>
    </form>
</div>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th class="id-cell">ID</th>
                <th class="name-cell">Name</th>
                <th class="description-cell">Description</th>
                <th class="category-cell">Type</th>
                <th class="location-cell">Location</th>
                <th class="count-cell">Rating</th>
                <th class="count-cell">Capacity</th>
                <th class="description-cell">Facilities</th>
                <th class="count-cell">Images</th>
                <th class="price-cell">Price</th>
                <th class="status-cell">Status</th>
                <th class="actions-cell">Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $accommodations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accommodation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="id-cell"><?php echo e($accommodation->id); ?></td>
                <td class="name-cell"><?php echo e($accommodation->name); ?></td>
                <td class="description-cell">
                    <div style="max-height: 100px; overflow-y: auto;">
                        <?php echo e($accommodation->description); ?>

                    </div>
                </td>
                <td class="category-cell"><?php echo e($accommodation->type); ?></td>
                <td class="location-cell">
                    <div style="max-height: 100px; overflow-y: auto;">
                        <?php echo e($accommodation->location); ?>

                    </div>
                </td>
                <td class="count-cell">
                    <?php if($accommodation->average_rating): ?>
                        <?php echo e($accommodation->rating_display); ?> (<?php echo e($accommodation->rating_count); ?>)
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td class="count-cell"><?php echo e($accommodation->capacity); ?></td>
                <td class="description-cell">
                    <div style="max-height: 100px; overflow-y: auto;">
                        <?php echo e(implode(', ', $accommodation->facilities)); ?>

                    </div>
                </td>
                <td class="count-cell">
                    <div><?php echo e($accommodation->img_count); ?></div>
                    <a href="<?php echo e(route('admin.accommodations.images', $accommodation->id)); ?>" class="edit-link">
                        Edit Images
                    </a>
                </td>
                <td class="price-cell">
                    Rp <?php echo e(number_format($accommodation->price, 0, ',', '.')); ?>/night
                </td>
                <td class="status-cell">
                    <form action="<?php echo e(route('admin.accommodations.toggle.isactive',$accommodation->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <button class="status-btn <?php echo e($accommodation->is_active ? 'active-btn' : 'inactive-btn'); ?>"
                            type="submit" title="Click to change">
                            <?php echo e($accommodation->is_active ? 'Active' : 'Inactive'); ?>

                        </button>
                    </form>
                </td>
                <td class="actions-cell">
                    <a href="<?php echo e(route('admin.accommodations.edit', $accommodation->id)); ?>" class="edit-link">Edit</a>
                    <a href="<?php echo e(route('admin.accommodations.reviews', $accommodation->id)); ?>" class="edit-link" style="margin-left: 8px;">Edit Reviews</a>
                    <form action="<?php echo e(route('admin.accommodations.delete', $accommodation->id)); ?>" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete <?php echo e($accommodation->name); ?>? This action cannot be undone.');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="delete-button" style="font-size: 0.8rem; padding: 4px 8px;">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="12" style="text-align: center;">No Accommodations Found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<div class="operation-container">
    <form action="<?php echo e(route('admin.accommodations.delete.all')); ?>" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete all accommodations? This action cannot be undone.');">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="delete-button">
            Delete All Accommodations
        </button>
    </form>
    <a href="<?php echo e(route('admin.accommodations.create')); ?>" class="create-button">
        Add Accommodations
    </a>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/admin/accommodations/index.blade.php ENDPATH**/ ?>