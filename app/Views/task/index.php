<div class="container py-4">
    <!-- User Welcome Card -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">Welcome, <?= htmlspecialchars($currentUser['name'] ?? 'User') ?></h2>
            
            <?php if ($userStats): ?>
                <div class="progress mb-2" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" 
                         style="width: <?= ($userStats['xp'] / ($userStats['level'] * 100)) * 100 ?>%">
                        <?= $userStats['xp'] ?>/<?= $userStats['level'] * 100 ?> XP
                    </div>
                </div>
                <p class="mb-0">Level: <?= $userStats['level'] ?></p>
                <p class="mb-0">Hearts: <?= $userStats['hearts'] ?></p>
            <?php else: ?>
                <p class="text-muted mb-0">No stats available.</p>
            <?php endif; ?>
        </div>
    </div>

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