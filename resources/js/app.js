import { createApp } from 'vue';
import App from './App.vue';
import TaskIndex from './pages/TaskIndex.vue';
import '../css/theme.css';
import TaskShow from './pages/TaskShow.vue';

const el = document.getElementById('app');

if (el.dataset.page === 'tasks-index') {
    createApp(TaskIndex, {
        tasks: JSON.parse(el.dataset.tasks),
        createUrl: el.dataset.createUrl,
    }).mount(el);
}  else if (el.dataset.page === 'tasks-show') {
    createApp(TaskShow, {
        task: JSON.parse(el.dataset.task),
        indexUrl: el.dataset.indexUrl,
    }).mount(el);
}else {
    createApp(App).mount(el);
}


