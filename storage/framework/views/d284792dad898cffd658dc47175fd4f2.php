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
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addFacilityButton = document.getElementById('add-facility');
        const newFacilityInput = document.getElementById('new-facility');
        const facilitiesDisplay = document.getElementById('facilities-display');
        const deleteAllButton = document.getElementById('delete-all-facilities');
        const facilitiesHiddenInput = document.getElementById('facilities-input');

        let facilities = [];
        const initialFacilitiesString = facilitiesHiddenInput.value;
        if (initialFacilitiesString) {
            facilities = initialFacilitiesString.split(',').map(item => item.trim()).filter(item => item !== "");
            renderFacilities();
        }

        function renderFacilities() {
            facilitiesDisplay.innerHTML = '';
            facilities.forEach(facility => {
                if (facility) {
                    const facilityBadge = document.createElement('span');
                    facilityBadge.className = 'tag-badge';
                    facilityBadge.textContent = facility;

                    const deleteIcon = document.createElement('span');
                    deleteIcon.className = 'delete-tag-icon';
                    deleteIcon.innerHTML = '&times;';
                    deleteIcon.onclick = () => {
                        facilities = facilities.filter(item => item !== facility);
                        renderFacilities();
                        updateHiddenInput();
                    };
                    facilityBadge.appendChild(deleteIcon);
                    facilitiesDisplay.appendChild(facilityBadge);
                }
            });
        }

        function updateHiddenInput() {
            facilitiesHiddenInput.value = facilities.join(',');
        }

        addFacilityButton.addEventListener('click', () => {
            const newFacility = newFacilityInput.value.trim();
            if (newFacility) {
                const newFacilities = newFacility.split(',').map(item => item.trim()).filter(item => item !== "");
                newFacilities.forEach(f => {
                    if (f && !facilities.includes(f)) {
                        facilities.push(f);
                    }
                });
                newFacilityInput.value = '';
                renderFacilities();
                updateHiddenInput();
            }
        });

        deleteAllButton.addEventListener('click', () => {
            facilities = [];
            renderFacilities();
            updateHiddenInput();
        });

        newFacilityInput.addEventListener('keypress', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                addFacilityButton.click();
            }
        });

        renderFacilities();
    });
</script>
<?php $__env->startSection('content'); ?>

<?php if(isset($accommodation)): ?>
<form method="POST" action="<?php echo e(route('admin.accommodations.apply', $accommodation)); ?>" class="create-product-form" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <div class="form-group">
        <label for="name">Enter Accommodation Name:</label>
        <input type="text" name="name" id="name" value="<?php echo e($accommodation->name); ?>">
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
        <label for="description">Enter Accommodation Description:</label>
        <textarea name="description" id="description" rows="4"><?php echo e($accommodation->description); ?></textarea>
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
        <label for="type">Accommodation Type:</label>
        <select id="type" name="type">
            <?php $__currentLoopData = $typesfilter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($type); ?>" <?php echo e(old('type', $accommodation->type) == $type ? 'selected' : ''); ?>>
                <?php echo e(ucfirst($type)); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="form-group">
        <label for="location">Enter Accommodation Location:</label>
        <textarea name="location" id="location" rows="4"><?php echo e($accommodation->location); ?></textarea>
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
        <label for="capacity">Enter Accommodation Capacity:</label>
        <input type="number" name="capacity" id="capacity" value="<?php echo e($accommodation->capacity); ?>">
        <?php $__errorArgs = ['capacity'];
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
        <label for="price">Enter Price per Night:</label>
        <input type="number" name="price" id="price" value="<?php echo e($accommodation->price); ?>" step="0.01" min="0">
        <?php $__errorArgs = ['price'];
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
        <label for="new-facility" class="label">Add Facilities:</label>
        <div class="facilities-input-group">
            <input type="text" id="new-facility" class="input-field" placeholder="e.g., Swimming Pool, WiFi">
            <button type="button" id="add-facility" class="button add-button">Add</button>
        </div>
    </div>

    <div class="form-group">
        <label for="facilities-display" class="label">Facilities:</label>
        <div id="facilities-display" class="facilities-display-container">
        </div>
        <button type="button" id="delete-all-facilities" class="button delete-button mt-2">Delete All</button>
    </div>

    <input type="hidden" name="facilities" id="facilities-input" value="<?php echo e(implode(', ', $accommodation->facilities ?? [])); ?>">
    
    <div class="form-actions">
        <a href="<?php echo e(route('admin.accommodations')); ?>" class="btn btn-secondary">
            Cancel
        </a>
        <button type="submit" class="btn btn-primary">Apply Change</button>
    </div>
</form>
<div style="padding:20px; max-width:100%; display:flex; flex-direction:column; gap:20px">

    <form action="<?php echo e(route('admin.accommodations.images', $accommodation->id)); ?>" method="GET" style="margin: 0;">
        <button type="submit" class="submit-button">
            Edit Images
        </button>
    </form>
    </form>
</div>
<?php else: ?>
<form method="POST" action="<?php echo e(route('admin.accommodations.store')); ?>" class="create-product-form" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <div class="form-group">
        <label for="name">Enter Accommodation Name:</label>
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
        <label for="description">Enter Accommodation Description:</label>
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
        <label for="type">Accommodation Type:</label>
        <select id="type" name="type">
            <?php $__currentLoopData = $typesfilter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($type); ?>" <?php echo e(old('type') == $type ? 'selected' : ''); ?>>
                <?php echo e(ucfirst($type)); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="form-group">
        <label for="location">Enter Accommodation Location:</label>
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
        <label for="capacity">Enter Accommodation Capacity:</label>
        <input type="number" name="capacity" id="capacity" value="<?php echo e(old('capacity')); ?>">
        <?php $__errorArgs = ['capacity'];
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
        <label for="new-facility" class="label">Add Facilities:</label>
        <div class="facilities-input-group">
            <input type="text" id="new-facility" class="input-field" placeholder="e.g., Swimming Pool, WiFi">
            <button type="button" id="add-facility" class="button add-button">Add</button>
        </div>
    </div>

    <div class="form-group">
        <label for="facilities-display" class="label">Facilities:</label>
        <div id="facilities-display" class="facilities-display-container">
        </div>
        <button type="button" id="delete-all-facilities" class="button delete-button mt-2">Delete All</button>
    </div>

    <div class="form-group">
        <label for="product_image">Initial Accommodation Image:</label>
        <input type="file" name="product_image" id="product_image">
        <input type="text" name="alt_text" placeholder="Image Alt Text" value="<?php echo e(old('alt_text')); ?>">
        <?php if($errors->has('product_image') || $errors->has('alt_text')): ?>
        <span class="error-message">Accommodation must have an initial image.</span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="price">Price per Night:</label>
        <input type="number" name="price" placeholder="Price per Night" value="<?php echo e(old('price')); ?>" step="0.01" required>
        <?php if($errors->has('price')): ?>
        <span class="error-message">Price is required.</span>
        <?php endif; ?>
    </div>

    <input type="hidden" name="facilities" id="facilities-input">
    
    <div class="form-actions">
        <a href="<?php echo e(route('admin.accommodations')); ?>" class="btn btn-secondary">
            Cancel
        </a>
        <button type="submit" class="btn btn-primary">Create Accommodation</button>
    </div>
</form>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/admin/accommodations/create.blade.php ENDPATH**/ ?>