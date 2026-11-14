<script setup>
import { computed, ref } from 'vue';
import TaskCard from '../components/TaskCard.vue';

const props = defineProps({
    tasks: { type: Array, default: () => [] },
    indexUrl: String,
    csrfToken: String,
});

const items = ref([...props.tasks]);
const errorMessage = ref('');

const definitions = [
    { key: 'todo', label: 'To Do' },
    { key: 'doing', label: 'Doing' },
    { key: 'done', label: 'Done' },
];

const columns = computed(() =>
    definitions.map((column) => ({
        ...column,
        tasks: items.value.filter((task) => task.status === column.key),
    }))
);

function otherColumns(currentKey) {
    return definitions.filter((column) => column.key !== currentKey);
}

async function moveTask(task, newStatus) {
    if (task.status === newStatus) return;

    const previous = task.status;
    errorMessage.value = '';
    task.status = newStatus;

    try {
        const response = await fetch(`/tasks/${task.id}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-CSRF-TOKEN': props.csrfToken,
            },
            body: JSON.stringify({ status: newStatus }),
        });

        if (!response.ok) {
            throw new Error('Request failed');
        }
    } catch (error) {
        task.status = previous;
        errorMessage.value = 'Could not move the task. Please try again.';
    }
}
</script>

<template>
    <div class="page">
        <header>
            <h1>Board</h1>
            <a :href="indexUrl" class="back">&larr; Back to tasks</a>
        </header>

        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>

        <div class="columns">
            <section v-for="column in columns" :key="column.key" class="column">
                <h2>{{ column.label }} <span class="count">{{ column.tasks.length }}</span></h2>

                <p v-if="column.tasks.length === 0" class="empty">Nothing here.</p>

                <div v-for="task in column.tasks" :key="task.id" class="item">
                    <TaskCard :task="task" />

                    <div class="moves">
                        <button
                            v-for="target in otherColumns(column.key)"
                            :key="target.key"
                            type="button"
                            :class="target.key"
                            @click="moveTask(task, target.key)"
                        >
                            Move to {{ target.label }}
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<style scoped>
.page {
    max-width: 1000px;
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
.back {
    color: var(--primary);
    text-decoration: none;
    font-size: 14px;
}
.error {
    background: #f8e3e1;
    color: var(--level-high);
    border: 1px solid var(--level-high);
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 14px;
}
.columns {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    align-items: start;
}
.column {
    background: rgba(255, 255, 255, 0.5);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 14px;
}
h2 {
    font-size: 15px;
    margin: 0 0 12px;
    color: var(--text-secondary);
}
.count {
    background: var(--border);
    border-radius: 999px;
    padding: 1px 8px;
    font-size: 12px;
    margin-left: 6px;
}
.empty {
    color: var(--text-secondary);
    font-size: 13px;
    margin: 0;
}
.item {
    margin-bottom: 14px;
}
.moves {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-top: -4px;
}
.moves button {
    border: none;
    color: #fff;
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 12px;
    cursor: pointer;
}
.moves button.todo { background: var(--status-todo); }
.moves button.doing { background: var(--status-doing); }
.moves button.done { background: var(--status-done); }
.moves button:hover {
    filter: brightness(0.92);
}
@media (max-width: 720px) {
    .columns {
        grid-template-columns: 1fr;
    }
}
</style>