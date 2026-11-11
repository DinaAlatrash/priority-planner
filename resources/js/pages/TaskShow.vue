<script setup>
import { computed } from 'vue';

const props = defineProps({
    task: { type: Object, required: true },
    indexUrl: String,
});

const deadlineText = computed(() =>
    props.task.deadline
        ? new Date(props.task.deadline).toLocaleString()
        : 'No deadline'
);
</script>

<template>
    <div class="page">
        <a :href="indexUrl" class="back">&larr; Back to tasks</a>

        <h1>{{ task.title }}</h1>

        <p v-if="task.description" class="description">{{ task.description }}</p>

        <dl>
            <dt>Deadline</dt>
            <dd>{{ deadlineText }}</dd>
            <dt>Estimated time</dt>
            <dd>{{ task.estimated_minutes }} min</dd>
            <dt>Importance</dt>
            <dd>{{ task.importance }}</dd>
            <dt>Status</dt>
            <dd>{{ task.status }}</dd>
        </dl>
    </div>
</template>

<style scoped>
.page {
    max-width: 640px;
    margin: 40px auto;
    padding: 0 16px;
}
.back {
    color: var(--primary);
    text-decoration: none;
    font-size: 14px;
}
h1 {
    font-size: 22px;
    margin: 16px 0;
}
.description {
    color: var(--text-secondary);
}
dl {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 14px 16px;
}
dt {
    font-size: 13px;
    color: var(--text-secondary);
}
dd {
    margin: 0 0 12px;
}
</style>