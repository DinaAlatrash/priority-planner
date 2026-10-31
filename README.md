# Priority Planner Website

A website that ranks your tasks, explains why, and plans your day.

## Problem
Many people don't know how to organize their time or which task is more important. They do easy tasks first and miss deadlines.

## Solution
Priority Planner ranks your tasks by importance, shows a short reason for each ranking, and fits your top tasks into the hours you have available each day.

## Features
1. Add tasks with a deadline, time estimate, and an importance level
2. Priority score with a short reason, shown in colors
3. To Do / Doing / Done board
4. Calendar week view
5. Subtasks with a progress bar
6. Daily plan that fits your top tasks into your available hours and warns you if it's too much
7. Dashboard home with today's top tasks and a simple chart of tasks completed this week
8. AI helper that suggests subtasks and time estimates, which the user can edit before saving

## How it looks
A public landing page, then a dashboard with a sidebar: Today, Board, Calendar, Settings.

## Technical skills
- PHP, Laravel, MVC, Eloquent
- CRUD operations, migrations and seeders
- Authentication, middleware, form validation
- Vue.js 
- Blade, HTML, CSS, Bootstrap, JavaScript, jQuery
- MySQL
- Git and GitHub

## Project management
The work is planned in Jira as one initiative, epics, and tasks, and built in Scrum sprints.

## Status
In progress. Sprint 1 started: project setup is done.

## Git workflow

1. `main` is the stable branch. We never push to it directly.
2. `develop` is where finished features are combined.
3. Each Jira task gets its own branch from `develop`, named like `feature/PP-12-create-task-form`.
4. Commit messages start with the Jira key.
5. Pull requests go into `develop` and are reviewed before merging.
6. Never commit secrets. `.env` stays on your own computer.
