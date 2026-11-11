<script setup>
import TaskCard from '../components/TaskCard.vue';

defineProps({
    tasks: { type: Array, default: () => [] },
    createUrl: String,
});
</script>

<template>
    <div class="page">
        <header>
            <h1>My tasks</h1>
            <a :href="createUrl" class="add">+ Add task</a>
        </header>

        <p v-if="tasks.length === 0" class="empty">No tasks yet. Add your first one.</p>

        <TaskCard v-for="task in tasks" :key="task.id" :task="task" />
    </div>
</template>

<style scoped>
.page {
    max-width: 640px;
    margin: 40px auto;
    padding: 0 16px;
}
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
h1 {
    font-size: 22px;
    margin: 0;
}
.add {
    background: var(--primary);
    color: #fff;
    text-decoration: none;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 14px;
}
.add:hover {
    background: var(--primary-hover);
}
.empty {
    color: var(--text-secondary);
}
</style>