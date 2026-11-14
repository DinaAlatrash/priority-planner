import '../css/theme.css';
import { createApp } from 'vue';
import App from './App.vue';
import TaskIndex from './pages/TaskIndex.vue';
import TaskShow from './pages/TaskShow.vue';
import TaskBoard from './pages/TaskBoard.vue';

const el = document.getElementById('app');

if (el.dataset.page === 'tasks-index') {
    createApp(TaskIndex, {
        tasks: JSON.parse(el.dataset.tasks),
        createUrl: el.dataset.createUrl,
    }).mount(el);
} else if (el.dataset.page === 'tasks-show') {
    createApp(TaskShow, {
        task: JSON.parse(el.dataset.task),
        indexUrl: el.dataset.indexUrl,
        editUrl: el.dataset.editUrl,
        deleteUrl: el.dataset.deleteUrl,
        csrfToken: el.dataset.csrf,
    }).mount(el);
} else if (el.dataset.page === 'tasks-board') {
    createApp(TaskBoard, {
        tasks: JSON.parse(el.dataset.tasks),
        indexUrl: el.dataset.indexUrl,
        csrfToken: el.dataset.csrf,
    }).mount(el);
} else {
    createApp(App).mount(el);
}
