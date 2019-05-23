<template>
    <Layout :user="user">
        <main>
            <h1>Robotin ohjaus</h1>
            <div class="list-container">
                <div class="list from">
                    <h2>Mahdolliset toiminnot</h2>
                    <draggable v-model="items" class="content" :group="{ name: 'from', pull: 'clone' }" :sort="false">
                        <div class="item" v-for="fn of items" :key="fn.id">
                            <span class="value">{{ fn.title }}</span>
                            <span class="remove" @click="removeItem(fn)">X</span>
                        </div>
                    </draggable>
                    <input type="text" class="new-item" placeholder="Kirjoita uusi toiminto ja paina enter" @keydown="onKeyDownNewItem">
                </div>
                <div class="list to">
                    <h2>Suoritettavat toiminnot</h2>
                    <draggable v-model="log" class="content" :group="{ name: 'to', put: ['from'] }">
                        <div class="item" v-for="(fn, index) of log" :key="index">
                            <span class="value">{{ fn.title }}</span>
                            <span class="remove" @click="removeLog(index)">X</span>
                        </div>
                    </draggable>
                    <div class="actions">
                        <button @click="clearLog()" :disabled="log.length == 0">Tyhjennä</button>
                        <button @click="execute()" :disabled="log.length == 0">Siirrä toiminnot</button>
                    </div>
                </div>
            </div>
        </main>
    </Layout>
</template>

<style>
    main {
        width: calc(100% - 30px);
        max-width: 1100px;
        background-color: #ffffff;
        margin: 20px auto;
        padding: 15px;
    }

    .list-container {
        display: flex;
    }

    .list {
        width: 100%;
        border: solid 1px #797979;
    }

    .list h2 {
        text-align: center;
    }

    .list .content {
        min-height: 200px;
        padding: 10px;
    }

    .list .item {
        background-color: #e1e1e1;
        padding: 5px 20px;
        margin: 5px 0;
    }

    .list .new-item {
        width: calc(100% - 4px);
        height: 30px;
    }

    .list.from .item {
        cursor: move;
    }

    .list .item .remove {
        float: right;
        color: #ff0000;
        cursor: pointer;
    }

    .actions {
        display: flex;
        justify-content: space-between;
    }

    .actions button {
        width: calc(50% - 2px);
        height: 35px;
    }
</style>

<script>
    import Layout from "../components/layout.vue";
    import draggable from 'vuedraggable';

    export default {
        data: function () {
            return {
                items: this.functions,
                log: [],
            };
        },
        components: { Layout, draggable },
        props: ['user', 'functions'],
        head: {
            title: {
                inner: 'Robotin ohjaus',
                separator: '-',
                complement: 'RoboBisnes-hanke',
            },
        },
        methods: {
            onKeyDownNewItem(event) {
                if (event.key == 'Enter' && event.target.value.trim() != '') {
                    var title = event.target.value.trim();
                    var data = new FormData();
                    data.append('function', title);
                    fetch('/robotin-ohjaus/lisaa-toiminto', {
                        method: 'POST',
                        body: data,
                    }).then(response => response.text()).then((id) => {
                        this.items.push({ id, title });
                        event.target.value = '';
                    });
                }
            },
            removeItem(fn) {
                this.items.splice(this.items.indexOf(fn), 1);

                var data = new FormData();
                data.append('function', fn.id);
                fetch('/robotin-ohjaus/poista-toiminto', {
                    method: 'POST',
                    body: data,
                });
            },
            removeLog(index) {
                this.log.splice(index, 1);
            },
            clearLog() {
                this.log = [];
            },
            async execute() {
                while (this.log.length > 0) {
                    let fn = this.log[0];
                    let data = new FormData();
                    data.append('function', fn.id);
                    await fetch('/robotin-ohjaus/suorita', {
                        method: 'POST',
                        body: data,
                    });
                    this.removeLog(0);
                }
                setTimeout(() => alert('Toiminnot tallennettu tietokantaan onnistuneesti'));
            },
        },
    };
</script>