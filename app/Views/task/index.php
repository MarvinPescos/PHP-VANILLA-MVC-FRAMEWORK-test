<div class="container py-4">
    <!-- User Welcome Card -->

    <?php include __DIR__ . '/../UserStats/statsBar.php'; ?>

    <!-- Tasks Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><?= ucfirst($title) ?></h1>
        <a href="/task/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Task
        </a>
    </div>

    <!-- Tasks List -->
    <?php if (empty($tasks)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No tasks found. Create your first task!
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($tasks as $task): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <form action="/task/<?= $task['id'] ?>/toggle" method="POST" class="me-3">
                            <input type="checkbox" class="form-check-input" 
                                   onchange="this.form.submit()" 
                                   <?= $task['status'] === 'completed' ? 'checked' : '' ?>>
                        </form>
                        <div>
                            <span class="<?= $task['status'] === 'completed' ? 'text-decoration-line-through' : '' ?>">
                                <?= htmlspecialchars($task['title']) ?>
                            </span>
                            <span class=" badge bg-secondary ms-2">
                                <?= ucfirst($task['category']) ?>
                            </span>
                            <span class="badge bg-<?= getDifficultyBadgeColor($task['difficulty']) ?> ms-2">
                                <?= ucfirst($task['difficulty']) ?>
                            </span>
                        </div>
                    </div>
                    <div class="btn-group">
    <a href="/task/<?= $task['id'] ?>/edit" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-edit"></i> Edit
    </a>
    <form action="/task/<?= $task['id'] ?>/delete" method="post" class="d-inline">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
    </form>
</div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>



<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Recent Activities</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($activities)): ?>
            <div class="list-group">
                <?php foreach ($activities as $activity): ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1"><?= htmlspecialchars($activity['action']) ?></h6>
                            <small class="text-muted">
                                <?= date('M d, Y H:i', strtotime($activity['created_at'])) ?>
                            </small>
                        </div>
                        <p class="mb-1"> <?= htmlspecialchars($activity['description']) ?></p>
                        <p class="mb-1"> <?= htmlspecialchars($activity['category']) ?></p>

                        <?php if (isset($activity['coins']) && $activity['coins'] > 0): ?>
                        <div class="mt-1">
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-coins me-1"></i> Earned: <?= htmlspecialchars($activity['coins']) ?> coins
                            </span>
                        </div>
                        <?php endif; ?>

                  
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">No recent activities</p>
        <?php endif; ?>
    </div>
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