<script setup>
import { computed } from 'vue';

const props = defineProps({
    task: { type: Object, required: true },
});

const levels = {
    high: { label: 'High', color: 'var(--level-high)' },
    medium: { label: 'Medium', color: 'var(--level-medium)' },
    low: { label: 'Low', color: 'var(--level-low)' },
};

const level = computed(() => levels[props.task.importance] ?? levels.medium);

const deadlineText = computed(() => {
    if (!props.task.deadline) return 'No deadline';
    return new Date(props.task.deadline).toLocaleDateString(undefined, {
        day: 'numeric',
        month: 'short',
    });
});
</script>

<template>
    <div class="card" :style="{ borderLeftColor: level.color }">
        <div class="title">{{ task.title }}</div>
        <div class="meta">
            {{ deadlineText }} · {{ task.estimated_minutes }} min · {{ level.label }} importance
        </div>
    </div>
</template>

<style scoped>
.card {
    background: var(--card);
    border: 1px solid var(--border);
    border-left: 5px solid;
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 10px;
}
.title {
    font-weight: 600;
    color: var(--text);
}
.meta {
    font-size: 13px;
    color: var(--text-secondary);
    margin-top: 2px;
}
</style>