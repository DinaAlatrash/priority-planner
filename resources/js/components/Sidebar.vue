<script setup>
import { computed } from 'vue';

const props = defineProps({
    userName: String,
    tasksUrl: String,
    boardUrl: String,
    createUrl: String,
    logoutUrl: String,
    csrfToken: String,
});

const path = window.location.pathname;

const links = computed(() => [
    {
        label: 'Tasks',
        href: props.tasksUrl,
        icon: 'M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01',
        active: path === '/tasks' || /^\/tasks\/\d+/.test(path),
    },
    {
        label: 'Board',
        href: props.boardUrl,
        icon: 'M6 4v16M12 4v9M18 4v12',
        active: path === '/board',
    },
    {
        label: 'Add task',
        href: props.createUrl,
        icon: 'M12 5v14M5 12h14',
        active: path === '/tasks/create',
    },
]);
</script>

<template>
    <aside class="sidebar">
       <div class="brand">Priority <br />Planner</div>
        <div class="body">
            <div class="label">MENU</div>

            <nav>
                <a
                    v-for="link in links"
                    :key="link.label"
                    :href="link.href"
                    :class="{ active: link.active }"
                >
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path :d="link.icon" />
                    </svg>
                    {{ link.label }}
                </a>
            </nav>

            <div class="tip">
                <strong>Tip</strong>
                <span>Break big tasks into small steps.</span>
            </div>

            <div class="footer">
                <div class="user">
                    <span class="avatar" aria-hidden="true">
                        <svg class="icon small" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 21c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                    </span>
                    <span class="name">{{ userName }}</span>
                </div>

                <form :action="logoutUrl" method="POST">
                    <input type="hidden" name="_token" :value="csrfToken" />
                    <button type="submit">Log out</button>
                </form>
            </div>
        </div>
    </aside>
</template>

<style scoped>
.sidebar {
    width: 220px;
    min-height: 100vh;
    box-sizing: border-box;
    background: var(--pink-bg);
    border-right: 1px solid var(--pink-line);
    display: flex;
    flex-direction: column;
}
.brand {
    background: var(--pink);
    color: #fff;
    font-weight: 700;
    font-size: 20px;
    line-height: 1.2;
    padding: 24px 18px 20px;
    border-radius: 0 0 22px 0;
}
.body {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 16px 14px 18px;
}
.label {
    font-size: 11px;
    letter-spacing: 0.08em;
    font-weight: 600;
    color: var(--pink-label);
    padding: 6px 8px 2px;
}
nav {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
nav a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 12px;
    color: #4a3a3f;
    text-decoration: none;
}
nav a:hover {
    background: rgba(194, 69, 111, 0.1);
}
nav a.active {
    background: var(--pink-soft);
    color: var(--pink-dark);
    font-weight: 600;
    box-shadow: inset 3px 0 0 var(--pink);
}
.icon {
    width: 18px;
    height: 18px;
    flex: 0 0 auto;
    fill: none;
    stroke: currentColor;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.icon.small {
    width: 16px;
    height: 16px;
}
.tip {
    background: var(--pink-soft);
    color: #6b3a4a;
    border-radius: 14px;
    padding: 12px 14px;
    margin-top: auto;
    font-size: 13px;
    line-height: 1.4;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.footer {
    margin-top: 12px;
}
.user {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 4px;
    border-top: 1px solid var(--pink-line);
}
.avatar {
    width: 32px;
    height: 32px;
    flex: 0 0 auto;
    border-radius: 50%;
    background: var(--pink);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
}
.name {
    font-size: 15px;
    font-weight: 600;
    color: #3d2e33;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
button {
    width: 100%;
    background: var(--pink-dark);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 10px 12px;
    font-weight: 600;
    cursor: pointer;
}
button:hover {
    filter: brightness(0.92);
}
@media (max-width: 720px) {
    .sidebar {
        width: 100%;
        min-height: 0;
        display: grid;
        grid-template-columns: 1fr auto;
        grid-template-areas:
            "brand footer"
            "nav nav";
        border-right: none;
        border-bottom: 1px solid var(--pink-line);
    }
    .brand {
        grid-area: brand;
        display: flex;
        align-items: center;
        font-size: 16px;
        padding: 12px 14px;
        border-radius: 0;
    }
    .brand br {
        display: none;
    }
    .body {
        display: contents;
    }
    .label,
    .tip {
        display: none;
    }
    nav {
        grid-area: nav;
        flex-direction: row;
        gap: 6px;
        padding: 8px;
    }
    nav a {
        flex: 1;
        justify-content: center;
        padding: 8px 6px;
        font-size: 13px;
    }
    nav a.active {
        box-shadow: inset 0 -3px 0 var(--pink);
    }
    .footer {
        grid-area: footer;
        margin-top: 0;
        background: var(--pink);
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 14px;
    }
    .user {
        border-top: none;
        padding: 0;
    }
    .name {
        display: none;
    }
    .avatar {
        background: rgba(255, 255, 255, 0.22);
    }
    button {
        width: auto;
        padding: 6px 10px;
        font-size: 12px;
    }
}
</style>