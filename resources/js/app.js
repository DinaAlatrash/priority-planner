import '../css/theme.css';
import { createApp } from 'vue';
import App from './App.vue';
import Sidebar from './components/Sidebar.vue';
import TaskIndex from './pages/TaskIndex.vue';
import TaskShow from './pages/TaskShow.vue';
import TaskBoard from './pages/TaskBoard.vue';
import SettingsPage from './pages/SettingsPage.vue';
import TodayPage from './pages/TodayPage.vue';

const sidebarEl = document.getElementById('sidebar');

if (sidebarEl) {
    createApp(Sidebar, {
        userName: sidebarEl.dataset.userName,
        todayUrl: sidebarEl.dataset.todayUrl,
        tasksUrl: sidebarEl.dataset.tasksUrl,
        boardUrl: sidebarEl.dataset.boardUrl,
        createUrl: sidebarEl.dataset.createUrl,
        settingsUrl: sidebarEl.dataset.settingsUrl,
        logoutUrl: sidebarEl.dataset.logoutUrl,
        csrfToken: sidebarEl.dataset.csrf,
    }).mount(sidebarEl);
}

const el = document.getElementById('app');

if (el) {
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
            subtaskStoreUrl: el.dataset.subtaskStoreUrl,
            csrfToken: el.dataset.csrf,
        }).mount(el);
    } else if (el.dataset.page === 'tasks-board') {
        createApp(TaskBoard, {
            tasks: JSON.parse(el.dataset.tasks),
            indexUrl: el.dataset.indexUrl,
            csrfToken: el.dataset.csrf,
        }).mount(el);
         } else if (el.dataset.page === 'settings') {
        createApp(SettingsPage, {
            availableHours: Number(el.dataset.availableHours),
            updateUrl: el.dataset.updateUrl,
            csrfToken: el.dataset.csrf,
        }).mount(el);
            } else if (el.dataset.page === 'today') {
        createApp(TodayPage, {
            planned: JSON.parse(el.dataset.planned),
            skipped: JSON.parse(el.dataset.skipped),
            availableMinutes: Number(el.dataset.availableMinutes),
            plannedMinutes: Number(el.dataset.plannedMinutes),
            leftMinutes: Number(el.dataset.leftMinutes),
            settingsUrl: el.dataset.settingsUrl,
            createUrl: el.dataset.createUrl,
        }).mount(el);
    } else {
        createApp(App).mount(el);
    }
}