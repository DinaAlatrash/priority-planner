import { createApp } from 'vue';
import App from './App.vue';
import TaskIndex from './pages/TaskIndex.vue';
import '../css/theme.css';

const el = document.getElementById('app');

if (el.dataset.page === 'tasks-index') {
    createApp(TaskIndex, {
        tasks: JSON.parse(el.dataset.tasks),
        createUrl: el.dataset.createUrl,
    }).mount(el);
} else {
    createApp(App).mount(el);
}
