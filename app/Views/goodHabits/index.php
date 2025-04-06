<div class="container py-4">
    <!-- User Welcome Card -->

    <!-- Tasks Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><?= ucfirst($title) ?></h1>
        <a href="/goodHabits/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Task
        </a>
    </div>

    <!-- Tasks List -->
    <?php if (empty($goodHabits)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No tasks found. Create your first task!
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($goodHabits as $goodHabit): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                    <form action="/goodHabits/<?= $goodHabit['id'] ?>/toggle" method="POST" class="me-3">
    <button type="submit" class="btn btn-sm btn-primary">   
            <i class="fas fa-check-circle"></i> Did
    </button>
</form>
                        <div>
                               <span>
                                <?= htmlspecialchars($goodHabit['title']) ?>
                             </span>
                            <span class=" badge bg-secondary ms-2">
                                <?= ucfirst($goodHabit['category']) ?>
                            </span>
                            <span class="badge bg-<?= getDifficultyBadgeColor($goodHabit['difficulty']) ?> ms-2">
                                <?= ucfirst($goodHabit['difficulty']) ?>
                            </span>
                        </div>
                    </div>
                    <div class="btn-group">
    <a href="/goodHabits/<?= $goodHabit['id'] ?>/edit" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-edit"></i> Edit
    </a>
    <form action="/goodHabits/<?= $goodHabit['id'] ?>/delete" method="post" class="d-inline">
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