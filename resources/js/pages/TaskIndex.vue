<script setup>
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

        <p v-if="tasks.length === 0">No tasks yet. Add your first one.</p>

        <ul v-else>
            <li v-for="task in tasks" :key="task.id">
                {{ task.title }} ({{ task.estimated_minutes }} min)
            </li>
        </ul>
    </div>
</template>

<style scoped>
.page {
    max-width: 640px;
    margin: 40px auto;
    font-family: system-ui, -apple-system, 'Segoe UI', sans-serif;
}
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.add {
    color: #3b5bdb;
    text-decoration: none;
    font-weight: 600;
}
</style>