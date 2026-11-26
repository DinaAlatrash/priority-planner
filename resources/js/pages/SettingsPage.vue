<script setup>
import { ref } from 'vue';

const props = defineProps({
    availableHours: { type: Number, default: 6 },
    updateUrl: String,
    csrfToken: String,
});

const hours = ref(props.availableHours);
const saving = ref(false);
const message = ref('');
const errorMessage = ref('');

async function save() {
    message.value = '';
    errorMessage.value = '';
    saving.value = true;

    try {
        const response = await fetch(props.updateUrl, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-CSRF-TOKEN': props.csrfToken,
            },
            body: JSON.stringify({ available_hours: hours.value }),
        });

        if (response.status === 422) {
            const body = await response.json();
            errorMessage.value = body.errors?.available_hours?.[0] ?? 'Invalid value.';
            return;
        }
        if (!response.ok) throw new Error('Request failed');

        const data = await response.json();
        hours.value = data.available_hours;
        message.value = 'Saved.';
    } catch (error) {
        errorMessage.value = 'Could not save. Please try again.';
    } finally {
        saving.value = false;
    }
}
</script>

<template>
    <div class="page">
        <h1>Settings</h1>

        <form class="card" @submit.prevent="save">
            <label for="hours">How many hours can you work each day?</label>
            <p class="hint">Your daily plan uses this to decide which tasks fit in your day.</p>

            <div class="row">
                <input id="hours" v-model.number="hours" type="number" step="0.5" min="0.5" max="24" required />
                <span class="unit">hours</span>
            </div>

            <button type="submit" :disabled="saving">{{ saving ? 'Saving...' : 'Save' }}</button>

            <p v-if="message" class="ok">{{ message }}</p>
            <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        </form>
    </div>
</template>

<style scoped>
.page {
    max-width: 520px;
    margin: 40px auto;
    padding: 0 16px;
}
h1 {
    font-size: 22px;
    margin: 0 0 20px;
}
.card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
}
label {
    font-weight: 600;
    display: block;
}
.hint {
    color: var(--text-secondary);
    font-size: 14px;
    margin: 4px 0 16px;
}
.row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}
input {
    width: 110px;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 8px 10px;
    font-size: 16px;
}
input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(91, 123, 78, 0.25);
}
.unit {
    color: var(--text-secondary);
}
button {
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 9px 20px;
    font-weight: 600;
    cursor: pointer;
}
button:hover {
    background: var(--primary-hover);
}
button:disabled {
    opacity: 0.6;
    cursor: default;
}
.ok {
    color: var(--priority-low);
    font-size: 14px;
    margin: 12px 0 0;
}
.error {
    color: var(--level-high);
    font-size: 14px;
    margin: 12px 0 0;
}
</style>