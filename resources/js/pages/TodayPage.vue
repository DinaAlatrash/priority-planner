<script setup>
import { computed } from 'vue';
import TaskCard from '../components/TaskCard.vue';

const props = defineProps({
    planned: { type: Array, default: () => [] },
    skipped: { type: Array, default: () => [] },
    availableMinutes: { type: Number, default: 0 },
    plannedMinutes: { type: Number, default: 0 },
    leftMinutes: { type: Number, default: 0 },
    settingsUrl: String,
    createUrl: String,
});

function formatMinutes(total) {
    const minutes = Math.max(0, Math.round(total));
    const h = Math.floor(minutes / 60);
    const m = minutes % 60;
    if (h === 0) return `${m}m`;
    if (m === 0) return `${h}h`;
    return `${h}h ${m}m`;
}

const today = new Date().toLocaleDateString(undefined, {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
});

const percent = computed(() =>
    props.availableMinutes > 0
        ? Math.min(100, Math.round((props.plannedMinutes / props.availableMinutes) * 100))
        : 0
);

const hasTasks = computed(() => props.planned.length + props.skipped.length > 0);

function skipNote(task) {
    return `Needs ${formatMinutes(task.estimated_minutes)}, but only ${formatMinutes(props.leftMinutes)} left`;
}
</script>

<template>
    <div class="page">
        <h1>Today</h1>
        <p class="date">{{ today }}</p>

        <section class="summary">
            <div class="stats">
                <div class="stat">
                    <small>AVAILABLE</small>
                    <strong>{{ formatMinutes(availableMinutes) }}</strong>
                </div>
                <div class="stat">
                    <small>PLANNED</small>
                    <strong>{{ formatMinutes(plannedMinutes) }}</strong>
                </div>
                <div class="stat">
                    <small>LEFT</small>
                    <strong>{{ formatMinutes(leftMinutes) }}</strong>
                </div>
            </div>

            <div class="bar">
                <div class="fill" :style="{ width: percent + '%' }"></div>
            </div>

            <a :href="settingsUrl" class="change">Change available hours</a>
        </section>

        <p v-if="!hasTasks" class="empty">
            You have no open tasks. <a :href="createUrl">Add one</a> to build your plan.
        </p>

        <template v-else>
            <h2>YOUR PLAN</h2>

            <p v-if="planned.length === 0" class="empty">No task fits in your available hours today.</p>

            <div v-for="(task, index) in planned" :key="task.id" class="item">
                <span class="no">{{ index + 1 }}</span>
                <div class="cardwrap">
                    <TaskCard :task="task" />
                </div>
            </div>

            <section v-if="skipped.length > 0" class="skip">
                <h2>DOESN'T FIT TODAY</h2>

                <div v-for="task in skipped" :key="task.id" class="skipitem">
                    <TaskCard :task="task" />
                    <p class="note">{{ skipNote(task) }}</p>
                </div>
            </section>
        </template>
    </div>
</template>

<style scoped>
.page {
    max-width: 680px;
    margin: 40px auto;
    padding: 0 16px;
}
h1 {
    font-size: 22px;
    margin: 0;
}
.date {
    color: var(--text-secondary);
    font-size: 14px;
    margin: 2px 0 16px;
}
h2 {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.04em;
    color: var(--text-secondary);
    margin: 0 0 10px;
}
.summary {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 16px 18px;
    margin-bottom: 20px;
}
.stats {
    display: flex;
    gap: 28px;
    margin-bottom: 12px;
}
.stat small {
    display: block;
    font-size: 11px;
    color: var(--text-secondary);
    letter-spacing: 0.04em;
}
.stat strong {
    font-size: 20px;
}
.bar {
    height: 8px;
    background: var(--border);
    border-radius: 999px;
    overflow: hidden;
}
.fill {
    height: 100%;
    background: var(--primary);
    transition: width 0.2s;
}
.change {
    display: inline-block;
    margin-top: 10px;
    font-size: 13px;
    color: var(--primary);
    text-decoration: none;
}
.empty {
    color: var(--text-secondary);
}
.empty a {
    color: var(--primary);
}
.item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
}
.no {
    flex: 0 0 auto;
    width: 24px;
    height: 24px;
    margin-top: 13px;
    border-radius: 50%;
    background: var(--primary);
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}
.cardwrap {
    flex: 1;
    min-width: 0;
}
.skip {
    margin-top: 24px;
    background: rgba(255, 255, 255, 0.5);
    border: 1px dashed var(--border);
    border-radius: 12px;
    padding: 14px;
}
.skipitem {
    opacity: 0.8;
}
.note {
    font-size: 12px;
    color: var(--level-medium);
    margin: -4px 0 12px;
}
</style>