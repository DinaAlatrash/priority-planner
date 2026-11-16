<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    initialSubtasks: { type: Array, default: () => [] },
    storeUrl: String,
    csrfToken: String,
});

const subtasks = ref([...props.initialSubtasks]);
const newTitle = ref('');
const errorMessage = ref('');

const doneCount = computed(() => subtasks.value.filter((s) => s.is_done).length);
const percent = computed(() =>
    subtasks.value.length === 0
        ? 0
        : Math.round((doneCount.value / subtasks.value.length) * 100)
);

const headers = {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    'X-CSRF-TOKEN': props.csrfToken,
};

async function addSubtask() {
    errorMessage.value = '';

    const title = newTitle.value.trim();
    if (title === '') {
        errorMessage.value = 'Write a step first.';
        return;
    }

    try {
        const response = await fetch(props.storeUrl, {
            method: 'POST',
            headers,
            body: JSON.stringify({ title }),
        });

        if (response.status === 422) {
            const body = await response.json();
            errorMessage.value = body.errors?.title?.[0] ?? 'Invalid step.';
            return;
        }
        if (!response.ok) throw new Error('Request failed');

        subtasks.value.push(await response.json());
        newTitle.value = '';
    } catch (error) {
        errorMessage.value = 'Could not add the step. Please try again.';
    }
}

async function toggle(subtask) {
    errorMessage.value = '';

    const previous = subtask.is_done;
    subtask.is_done = !previous;

    try {
        const response = await fetch(`/subtasks/${subtask.id}`, {
            method: 'PATCH',
            headers,
            body: JSON.stringify({ is_done: subtask.is_done }),
        });
        if (!response.ok) throw new Error('Request failed');
    } catch (error) {
        subtask.is_done = previous;
        errorMessage.value = 'Could not update the step. Please try again.';
    }
}

async function remove(subtask) {
    errorMessage.value = '';

    try {
        const response = await fetch(`/subtasks/${subtask.id}`, {
            method: 'DELETE',
            headers,
        });
        if (!response.ok) throw new Error('Request failed');

        subtasks.value = subtasks.value.filter((s) => s.id !== subtask.id);
    } catch (error) {
        errorMessage.value = 'Could not delete the step. Please try again.';
    }
}
</script>

<template>
    <section class="subtasks">
        <h2>Steps</h2>

        <div v-if="subtasks.length > 0" class="progress">
            <div class="track">
                <div class="fill" :style="{ width: percent + '%' }"></div>
            </div>
            <span class="progress-text">{{ doneCount }} of {{ subtasks.length }} done</span>
        </div>
        <p v-else class="empty">No steps yet. Break this task into small steps.</p>

        <ul>
            <li v-for="subtask in subtasks" :key="subtask.id">
                <label :class="{ done: subtask.is_done }">
                    <input type="checkbox" :checked="subtask.is_done" @change="toggle(subtask)" />
                    <span>{{ subtask.title }}</span>
                </label>
                <button type="button" class="remove" aria-label="Delete step" @click="remove(subtask)">&times;</button>
            </li>
        </ul>

        <form class="add" @submit.prevent="addSubtask">
            <input v-model="newTitle" type="text" placeholder="Add a step" maxlength="255" />
            <button type="submit">Add</button>
        </form>

        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </section>
</template>

<style scoped>
.subtasks {
    margin-top: 24px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 14px 16px;
}
h2 {
    font-size: 16px;
    margin: 0 0 12px;
}
.progress {
    margin-bottom: 12px;
}
.track {
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
.progress-text {
    display: block;
    font-size: 13px;
    color: var(--text-secondary);
    margin-top: 4px;
}
.empty {
    color: var(--text-secondary);
    font-size: 14px;
    margin: 0 0 12px;
}
ul {
    list-style: none;
    margin: 0 0 12px;
    padding: 0;
}
li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    border-bottom: 1px solid var(--border);
}
label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}
label.done span {
    text-decoration: line-through;
    color: var(--text-secondary);
}
.remove {
    background: transparent;
    border: none;
    color: var(--text-secondary);
    font-size: 18px;
    cursor: pointer;
}
.remove:hover {
    color: var(--level-high);
}
.add {
    display: flex;
    gap: 8px;
}
.add input {
    flex: 1;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 8px 10px;
    font-size: 14px;
}
.add button {
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    cursor: pointer;
}
.add button:hover {
    background: var(--primary-hover);
}
.error {
    color: var(--level-high);
    font-size: 13px;
    margin: 8px 0 0;
}
</style>