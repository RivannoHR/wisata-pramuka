<style>
    .create-product-form {
        max-width: 100%;
        height: 100%;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px 8px 0 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: scroll;
        gap: 10px;
    }


    .create-product-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .create-product-form input,
    .create-product-form textarea,
    .create-product-form select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;

    }

    .create-product-form textarea {
        resize: vertical;
    }

    .create-product-form input:focus,
    .create-product-form textarea:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .error-message {
        color: #e3342f;
        font-size: 0.875em;
        margin-top: 0.25rem;
        display: block;
    }

    .button {
        padding: 0.5rem 1rem;
        font-weight: 600;
        color: #ffffff;
        border-radius: 0.375rem;
        transition-property: background-color;
        transition-duration: 200ms;
        border: none;
    }

    .add-button {
        background-color: #007bff;
    }

    .add-button:hover {
        background-color: #0056b3;
    }

    .delete-button {
        background-color: #ef4444;
    }

    .delete-button:hover {
        background-color: #dc2626;
    }

    .facilities-input-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .submit-button {
        display: block;
        width: 100%;
        padding: 0.75rem;
        font-size: 1rem;
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .submit-button:hover {
        background-color: #0056b3;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 1rem;
        font-weight: bold;
        display: inline-block;
        text-align: center;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
    }

    .facilities-display-container {
        border: 1px solid #d1d5db;
        padding: 1rem;
        border-radius: 0.375rem;
        background-color: #f9fafb;
        min-height: 3rem;
        margin-bottom: 0.5rem
    }

    .tag-badge {
        display: inline-flex;
        align-items: center;
        background-color: #e5e7eb;
        color: #374151;
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .delete-tag-icon {
        margin-left: 0.25rem;
        cursor: pointer;
        color: #6b7280;
    }

    .delete-tag-icon:hover {
        color: #111827;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addHoursButton = document.getElementById('add-hours');
        const newDaySelect = document.getElementById('new-day');
        const newTimeInput = document.getElementById('new-time');
        const hoursDisplay = document.getElementById('operating-hours-display');
        const deleteAllButton = document.getElementById('delete-all-hours');
        const hoursHiddenInput = document.getElementById('operating-hours-input');

        let operatingHours = {};

        // 1. Initialize data from the hidden input
        const initialHoursString = hoursHiddenInput.value;
        if (initialHoursString) {
            try {
                operatingHours = JSON.parse(initialHoursString);
            } catch (e) {
                console.error('Failed to parse operating hours JSON:', e);
            }
        }

        // 2. Render the hours to the display
        function renderHours() {
            hoursDisplay.innerHTML = '';
            for (const day in operatingHours) {
                if (operatingHours.hasOwnProperty(day) && operatingHours[day]) {
                    const hoursBadge = document.createElement('span');
                    hoursBadge.className = 'tag-badge';
                    hoursBadge.textContent = `${day.charAt(0).toUpperCase() + day.slice(1)}: ${operatingHours[day]}`;

                    const deleteIcon = document.createElement('span');
                    deleteIcon.className = 'delete-tag-icon';
                    deleteIcon.innerHTML = '&times;';
                    deleteIcon.onclick = () => {
                        delete operatingHours[day];
                        renderHours();
                        updateHiddenInput();
                    };
                    hoursBadge.appendChild(deleteIcon);
                    hoursDisplay.appendChild(hoursBadge);
                }
            }
        }

        // 3. Update the hidden input with JSON string
        function updateHiddenInput() {
            hoursHiddenInput.value = JSON.stringify(operatingHours);
        }

        // 4. Event listener for adding new hours
        addHoursButton.addEventListener('click', () => {
            const newDay = newDaySelect.value;
            const newTime = newTimeInput.value.trim();

            if (newDay && newTime) {
                operatingHours[newDay] = newTime;
                newDaySelect.value = '';
                newTimeInput.value = '';
                renderHours();
                updateHiddenInput();
            }
        });

        // 5. Event listener for deleting all hours
        deleteAllButton.addEventListener('click', () => {
            operatingHours = {};
            renderHours();
            updateHiddenInput();
        });

        // 6. Initial render on page load
        renderHours();
    });
</script>

<?php $__env->startSection('content'); ?>

<?php if(isset($touristAttraction)): ?>
<form method="POST" action="<?php echo e(route('admin.tourist-attractions.apply', $touristAttraction)); ?>" class="create-product-form" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <div class="form-group">
        <label for="name">Enter Tourist Attraction Name:</label>
        <input type="text" name="name" id="name" value="<?php echo e($touristAttraction->name); ?>">
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error-message"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="description">Enter Tourist Attraction Description:</label>
        <textarea name="description" id="description" rows="4"><?php echo e($touristAttraction->description); ?></textarea>
        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error-message"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="type">Tourist Attraction Type:</label>
        <select id="type" name="type">
            <?php

            $types = [
            'tourist_spot' => 'Tourist Spot',
            'restaurant' => 'Restaurant',
            'shop' => 'Shop',
            ];
            ?>
            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($value); ?>" <?php echo e(old('type', $touristAttraction->type) == $value ? 'selected' : ''); ?>>
                <?php echo e($label); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error-message"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>


    <div class="form-group">
        <label for="location">Enter Tourist Attraction Location:</label>
        <textarea name="location" id="location" rows="4"><?php echo e($touristAttraction->location); ?></textarea>
        <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error-message"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="form-group">
        <label for="operating-hours-display" class="label">Current Schedule:</label>
        <div id="operating-hours-display" class="facilities-display-container">
            <!-- Operating hours will be rendered here by the script -->
        </div>
        <button type="button" id="delete-all-hours" class="button delete-button mt-2">Delete All</button>
    </div>

    <!-- Input for new operating hours -->
    <div class="form-group d-flex">
        <select id="new-day" class="form-control mr-2">
            <option value="">Select Day</option>
            <option value="monday">Monday</option>
            <option value="tuesday">Tuesday</option>
            <option value="wednesday">Wednesday</option>
            <option value="thursday">Thursday</option>
            <option value="friday">Friday</option>
            <option value="saturday">Saturday</option>
            <option value="sunday">Sunday</option>
        </select>
        <input type="text" id="new-time" class="form-control mr-2" placeholder="e.g., 09:00 - 17:00">
        <button type="button" id="add-hours" class="button add-button">Add</button>
    </div>

    <input type="hidden" name="operating_hours" id="operating-hours-input" value="<?php echo e(json_encode($touristAttraction->operating_hours ?? [])); ?>">
    
    <div class="form-actions">
        <a href="<?php echo e(route('admin.tourist-attractions')); ?>" class="btn btn-secondary">
            Cancel
        </a>
        <button type="submit" class="btn btn-primary">Apply Change</button>
    </div>
</form>
<div style="padding:20px; max-width:100%; display:flex; flex-direction:column; gap:20px">

    <form action="<?php echo e(route('admin.tourist-attractions.images', $touristAttraction->id)); ?>" method="GET" style="margin: 0;">
        <button type="submit" class="submit-button">
            Edit Images
        </button>
    </form>
</div>
<?php else: ?>
<form method="POST" action="<?php echo e(route('admin.tourist-attractions.store')); ?>" class="create-product-form" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <div class="form-group">
        <label for="name">Enter Tourist Attraction Name:</label>
        <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>">
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error-message"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="description">Enter Tourist Attraction Description:</label>
        <textarea name="description" id="description" rows="4"><?php echo e(old('description')); ?></textarea>
        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error-message"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="type">Tourist Attraction Type:</label>
        <select id="type" name="type">
            <?php

            $types = [
            'tourist_spot' => 'Tourist Spot',
            'restaurant' => 'Restaurant',
            'shop' => 'Shop',
            ];
            ?>
            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($value); ?>" <?php echo e(old('type') == $value ? 'selected' : ''); ?>>
                <?php echo e($label); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error-message"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>


    <div class="form-group">
        <label for="location">Enter Tourist Attraction Location:</label>
        <textarea name="location" id="location" rows="4"><?php echo e(old('location')); ?></textarea>
        <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error-message"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="form-group">
        <label for="operating-hours-display" class="label">Current Schedule:</label>
        <div id="operating-hours-display" class="facilities-display-container">
            <!-- Operating hours will be rendered here by the script -->
        </div>
        <button type="button" id="delete-all-hours" class="button delete-button mt-2">Delete All</button>
    </div>

    <!-- Input for new operating hours -->
    <div class="form-group d-flex">
        <select id="new-day" class="form-control mr-2">
            <option value="">Select Day</option>
            <option value="monday">Monday</option>
            <option value="tuesday">Tuesday</option>
            <option value="wednesday">Wednesday</option>
            <option value="thursday">Thursday</option>
            <option value="friday">Friday</option>
            <option value="saturday">Saturday</option>
            <option value="sunday">Sunday</option>
        </select>
        <input type="text" id="new-time" class="form-control mr-2" placeholder="e.g., 09:00 - 17:00">
        <button type="button" id="add-hours" class="button add-button">Add</button>
    </div>
    <input type="hidden" name="operating_hours" id="operating-hours-input" value="<?php echo e(old('operating_hours', isset($touristAttraction) ? json_encode($touristAttraction->operating_hours) : '{}')); ?>">


    <div class="form-group">
        <label for="product_image">Initial Tourist Attraction Image:</label>
        <input type="file" name="product_image" id="product_image">
        <input type="text" name="alt_text" placeholder="Image Alt Text" value="<?php echo e(old('alt_text')); ?>">
        <?php if($errors->has('product_image') || $errors->has('alt_text')): ?>
        <span class="error-message">Tourist Attraction must have an initial image.</span>
        <?php endif; ?>
    </div>

    <div class="form-actions">
        <a href="<?php echo e(route('admin.tourist-attractions')); ?>" class="btn btn-secondary">
            Cancel
        </a>
        <button type="submit" class="btn btn-primary">Create Tourist Attraction</button>
    </div>
</form>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/admin/tourist-attractions/create.blade.php ENDPATH**/ ?>