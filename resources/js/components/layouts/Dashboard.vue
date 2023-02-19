<template>
    <div class="columns">
        <div class="column is-half is-offset-one-quarter task-list">
            <div class="box">
                <h2 class="title">My tasks</h2>
                <hr>
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <input class="input" type="text" placeholder="New task" v-model="task.body">
                    </div>
                    <div class="control">
                        <a class="button is-primary" @click="createTask()">
                            Add task
                        </a>
                    </div>
                </div>

                <div class="tabs is-centered">
                <h3 class="title">
                    <a href="#" v-on:click.prevent="fetchTaskList()">
                        Current task
                    </a>
                </h3>

                </div>
                <div class="card" v-for="task in list">
                    <header class="card-header">
                        <p class="card-header-title">
                            Task {{ task.id }}
                        </p>
                        <a href="#" class="card-header-icon" aria-label="more options"
                            v-on:click.prevent="archiveTask(task.id)">
                            <span class="icon">
                                <i class="fa " :class="{'fa-square-o': !task.archive,
                                                        check: !task.archive,
                                                        'fa-check-square-o': task.archive,
                                                        done: task.archive}" aria-hidden="true"></i>
                            </span>
                        </a>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <p v-if="task !== editingTask" @dblclick="editTask(task)" v-bind:title="message">
                                {{ task.body }}
                            </p>
                            <input class="input" v-if="task === editingTask" v-autofocus @keyup.enter="endEditing(task)" @blur="endEditing(task)" type="text" placeholder="New task" v-model="task.body">
                        </div>
                    </div>
                    <footer class="card-footer">
                        <a class="card-footer-item" v-on:click.prevent="deleteTask(task.id)">Delete</a>
                    </footer>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        directives: {
            'autofocus': {
                inserted(el) {
                    el.focus();
                }
            }
        },

        data() {
            return {
                message: 'Double click for editing.',
                list: [],
                task: {
                    id: '',
                    body: '',
                    archive: ''
                },
                editingTask: {},
                activeItem: 'current'
            }
        },

        created() {
            this.fetchTaskList();
        },

        methods: {
            fetchTaskList(archive = null) {

                axios.get('list').then(result => {
                    this.list = result.data
                });
            },

            isActive(menuItem) {
                return this.activeItem === menuItem;
            },

            setActive(menuItem) {
                this.activeItem = menuItem;
            },

            createTask() {
                axios.post('list', this.task).then(result => {
                    this.task.body = '';
                    this.fetchTaskList();
                }).catch(err => {
                    console.log(err);
                });
            },

            editTask(task) {
                this.editingTask = task;
            },

            endEditing(task) {
                this.editingTask = {};
                if (task.body.trim() === '') {
                    this.deleteTask(task.id);
                } else {
                    axios.put('listlist', task).then(result => {
                        console.log('success!')
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },

            deleteTask(id) {
                axios.delete('list/' + id).then(result => {
                    this.fetchTaskList();
                }).catch(err => {
                    console.log(err);
                });
            }
        }
    }
</script>
