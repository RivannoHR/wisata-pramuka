<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin-tables.css')); ?>">
<style>
    .filter-container {
        background: white;
        border-radius: 12px 12px 0 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .filter-form {
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        padding-top: 10px;
        padding-bottom: 10px;
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

    .filter-select,
    .search-input,
    .price-input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
        min-width: 150px;
    }

    .price-input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.5rem;
        min-width: 100px;
    }

    .search-input {
        min-width: 100px;
    }

    .filter-button {
        background: black;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
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
        overflow-x: auto;
        overflow-y: visible;
        /* Allows horizontal scrolling */
        flex-grow: 1;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 100%;
        position: relative;
        border-radius: 0 0 12px 12px;
    }

    table {
        min-width: 1400px;
        /* Force table to be wider to trigger horizontal scroll */
        width: max-content;
        border-collapse: collapse;
        table-layout: auto;
        /* Allow columns to size naturally */
    }

    .id-cell {
        width: 60px;
        min-width: 60px;
    }

    .user-cell {
        width: 120px;
        min-width: 120px;
    }

    .accommodation-cell {
        width: 180px;
        min-width: 180px;
    }

    .room-count-cell {
        width: 100px;
        min-width: 100px;
        text-align: center;
    }

    .date-cell {
        width: 120px;
        min-width: 120px;
    }

    .duration-cell {
        width: 100px;
        min-width: 100px;
        text-align: center;
    }

    .price-cell {
        width: 140px;
        min-width: 140px;
        text-align: right;
    }

    .status-cell {
        width: 120px;
        min-width: 120px;
    }

    .notes-cell {
        width: 200px;
        min-width: 200px;
        white-space: normal;
        /* Allow text wrapping in notes */
    }

    .special-request-cell {
        width: 200px;
        min-width: 200px;
        white-space: normal;
        /* Allow text wrapping in special requests */
    }


    th,
    td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
        vertical-align: top;
        white-space: nowrap;
        /* Prevent text wrapping to maintain column widths */
    }

    th {
        background-color: #f8f8f8;
        font-weight: 600;
        color: #555;
        position: sticky;
        top: 0;
        z-index: 10;
        /* Make headers sticky when scrolling vertically */
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    td {
        word-wrap: normal;
        /* Allows long words to break and wrap to the next line */
    }

    .description-cell {
        min-height: 50px;

    }

    .operation-cell {
        display: flex;
        gap: 10px;
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

    .status-select {
        padding: 5px 5px;
        border-radius: 8px;
        border: 1px solid #ccc;
        cursor: pointer;
        font-weight: 600;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-completed {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-cancelled {
        background: #fecaca;
        color: #b91c1c;
    }
</style>
<script>
    // Function to automatically submit the form when a new status is selected
    function updateStatus(selectElement) {
        const form = selectElement.closest('form');
        form.submit();
    }

    // Function to set the initial class based on the current value
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.status-select').forEach(select => {
            const status = select.value;
            select.className = `status-select status-${status}`;
        });
    });
</script>
<div class="filter-container">
    <form method="GET" action="<?php echo e(route('admin.bookings')); ?>" class="filter-form" id="filterForm">
        <input type="hidden" name="filter_yes" value="1">
        <div class="filter-group">
            <input type="text" name="search" placeholder="Search by user or accommodation..." value="<?php echo e(request('search')); ?>" class="search-input">
        </div>

        <div class="filter-group">
            <select name="status" class="filter-select">
                <option value="">All Statuses</option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
            </select>
        </div>
        <div class="filter-group">
            <select name="sort_by" class="filter-select">
                <option value="">Sort by</option>
                <option value="latest" <?php echo e(request('sort_by') == 'latest' ? 'selected' : ''); ?>>Latest Bookings</option>
                <option value="oldest" <?php echo e(request('sort_by') == 'oldest' ? 'selected' : ''); ?>>Oldest Bookings</option>
            </select>
        </div>

        <button type="submit" class="filter-button">Filter</button>
    </form>
</div>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th class="id-cell">Id</th>
                <th class="user-cell">User</th>
                <th class="accommodation-cell">Accommodation</th>
                <th class="room-count-cell">Room Count</th>
                <th class="date-cell">Check in date</th>
                <th class="date-cell">Check out date</th>
                <th class="duration-cell">Duration (days)</th>
                <th class="price-cell">Total Price</th>
                <th class="status-cell">Status</th>
                <th class="notes-cell">Notes</th>
                <th class="special-request-cell">Special Request</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="id-cell"><?php echo e($booking->id); ?></td>
                <td class="user-cell"><?php echo e($booking->user->name); ?></td>
                <td class="accommodation-cell"><?php echo e($booking->accommodation->name); ?></td>
                <td class="room-count-cell"><?php echo e($booking->rooms_count); ?></td>
                <td class="date-cell"><?php echo e($booking->check_in_date); ?></td>
                <td class="date-cell"><?php echo e($booking->check_out_date); ?></td>
                <td class="duration-cell"><?php echo e($booking->duration_days); ?></td>
                <td class="price-cell">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td>
                <td class="status-cell">
                    <form action="<?php echo e(route('admin.bookings.togglestatus', $booking->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <select name="status" onchange="updateStatus(this)" class="status-select">
                            <option value="pending" <?php echo e($booking->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="active" <?php echo e($booking->status == 'active' ? 'selected' : ''); ?>>Active</option>
                            <option value="completed" <?php echo e($booking->status == 'completed' ? 'selected' : ''); ?>>Completed</option>
                            <option value="cancelled" <?php echo e($booking->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                    </form>
                </td>
                <td class="notes-cell">
                    <div style="max-height: 100px; overflow-y: auto;">
                        <?php echo e($booking->notes); ?>

                    </div>
                </td>
                <td class="special-request-cell">
                    <div style="max-height: 100px; overflow-y: auto;">
                        <?php echo e($booking->special_requests); ?>

                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="11" style="text-align: center;">No bookings found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/admin/bookings/index.blade.php ENDPATH**/ ?>