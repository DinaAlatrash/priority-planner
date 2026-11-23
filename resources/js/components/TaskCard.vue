<script setup>
import { computed } from 'vue';

const props = defineProps({
    task: { type: Object, required: true },
});

const labels = {
    urgent: 'Urgent',
    high: 'High',
    medium: 'Medium',
    low: 'Low',
    done: 'Done',
};

const level = computed(() =>
    labels[props.task.priority_level] ? props.task.priority_level : 'medium'
);

const meta = computed(() =>
    [props.task.priority_reason, `${props.task.estimated_minutes} min`]
        .filter(Boolean)
        .join(' · ')
);
</script>

<template>
    <a class="card" :class="`p-${level}`" :href="`/tasks/${task.id}`">
        <div class="top">
            <span class="title">{{ task.title }}</span>
            <span class="badge">{{ labels[level] }}</span>
        </div>
        <div class="meta">{{ meta }}</div>
    </a>
</template>

<style scoped>
.card {
    display: block;
    text-decoration: none;
    color: inherit;
    background: var(--card);
    border: 1px solid var(--border);
    border-left: 5px solid var(--edge);
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 10px;
}
.p-urgent {
    --edge: var(--priority-urgent);
}
.p-high {
    --edge: var(--priority-high);
}
.p-medium {
    --edge: var(--priority-medium);
}
.p-low {
    --edge: var(--priority-low);
}
.p-done {
    --edge: var(--priority-done);
}
.top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px 8px;
}
.title {
    font-weight: 600;
    color: var(--text);
}
.p-done .title {
    opacity: 0.65;
    text-decoration: line-through;
}
.badge {
    background: var(--edge);
    color: #fff;
    border-radius: 999px;
    padding: 2px 10px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}
.meta {
    font-size: 13px;
    color: var(--text-secondary);
    margin-top: 4px;
}
</style>