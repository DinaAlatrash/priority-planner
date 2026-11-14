<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    task: { type: Object, required: true },
    indexUrl: String,
    editUrl: String,
    deleteUrl: String,
    csrfToken: String,
});

const showConfirm = ref(false);
const deleteForm = ref(null);

const deadlineText = computed(() =>
    props.task.deadline
        ? new Date(props.task.deadline).toLocaleString()
        : 'No deadline'
);

const statusLabels = { todo: 'To Do', doing: 'Doing', done: 'Done' };
const statusText = computed(() => statusLabels[props.task.status] ?? props.task.status);

function submitDelete() {
    deleteForm.value.submit();
}
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
            <dd>{{ statusText }}</dd>
        </dl>

        <div class="actions">
            <a :href="editUrl" class="edit">Edit</a>
            <button type="button" class="delete" @click="showConfirm = true">Delete</button>
        </div>

        <form ref="deleteForm" :action="deleteUrl" method="POST" class="hidden-form">
            <input type="hidden" name="_token" :value="csrfToken" />
            <input type="hidden" name="_method" value="DELETE" />
        </form>

        <div v-if="showConfirm" class="overlay" @click.self="showConfirm = false">
            <div class="modal" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
                <h2 id="confirm-title">Delete this task?</h2>
                <p>"{{ task.title }}" will be removed. This cannot be undone.</p>

                <div class="modal-actions">
                    <button type="button" class="cancel" @click="showConfirm = false">Cancel</button>
                    <button type="button" class="confirm" @click="submitDelete">Yes, delete</button>
                </div>
            </div>
        </div>
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
.actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}
.edit {
    background: var(--primary);
    color: #fff;
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
}
.edit:hover {
    background: var(--primary-hover);
}
.delete {
    background: transparent;
    color: var(--level-high);
    border: 1px solid var(--level-high);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
}
.delete:hover {
    background: var(--level-high);
    color: #fff;
}
.hidden-form {
    display: none;
}
.overlay {
    position: fixed;
    inset: 0;
    background: rgba(47, 42, 36, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.modal {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 22px;
    width: 100%;
    max-width: 380px;
}
.modal h2 {
    font-size: 18px;
    margin: 0 0 8px;
}
.modal p {
    color: var(--text-secondary);
    margin: 0 0 18px;
}
.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
.cancel {
    background: transparent;
    color: var(--text);
    border: 1px solid var(--border);
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
}
.cancel:hover {
    background: var(--bg);
}
.confirm {
    background: var(--level-high);
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
}
</style>