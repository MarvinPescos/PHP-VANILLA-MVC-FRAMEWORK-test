<div class="container py-4">
    <!-- User Welcome Card -->

    <!-- Tasks Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><?= ucfirst($title) ?></h1>
        <a href="/dailyTask/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Daily Task
        </a>
    </div>

    <!-- Tasks List -->
    <?php if (empty($dailyTasks)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No tasks found. Create your first task!
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($dailyTasks as $dailyTask): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
    <form action="/dailyTask/<?= $dailyTask['id'] ?>/toggle" method="POST" class="me-3" style="<?= $dailyTask['status'] === 'completed' ? 'display: none;' : '' ?>">
        <input type="checkbox" class="form-check-input" 
               onchange="this.form.submit()" 
               <?= $dailyTask['status'] === 'completed' ? 'checked' : '' ?>>
    </form>
    
    <div style="<?= $dailyTask['status'] === 'completed' ? 'display: none;' : '' ?>">
        <span>
            <?= htmlspecialchars($dailyTask['title']) ?>
        </span>
        <!-- category -->
        <span class="badge bg-secondary ms-2">
            <?= ucfirst($dailyTask['category']) ?>
        </span>
        <!-- difficulty -->
        <span class="badge bg-<?= getDifficultyBadgeColor($dailyTask['difficulty']) ?> ms-2">
            <?= ucfirst($dailyTask['difficulty']) ?>
        </span>
    </div>
    
    <?php if ($dailyTask['status'] === 'completed'): ?>
        <div>
            <span class="text-muted">
                (<?=$dailyTask['title'] ?>) 
            </span>
        </div>
    <?php endif; ?>
</div>
                    <div class="btn-group">
    <a href="/dailyTask/<?= $dailyTask['id'] ?>/edit" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-edit"></i> Edit
    </a>
    <form action="/dailyTask/<?= $dailyTask['id'] ?>/delete" method="post" class="d-inline">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
    </form>
</div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>



<?php
// Helper function for difficulty badge colors
function getDifficultyBadgeColor($difficulty) {
    return [
        'easy' => 'success',
        'medium' => 'warning',
        'hard' => 'danger'
    ][$difficulty] ?? 'secondary';
}
?>