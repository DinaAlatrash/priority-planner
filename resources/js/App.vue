<script setup>
const el = document.getElementById('app');
const userName = el?.dataset.userName ?? 'Guest';
</script>

<template>
    <div>
        <h1>Welcome, {{ userName }}</h1>
        <p>Vue is connected to the dashboard.</p>
    </div>
</template>
