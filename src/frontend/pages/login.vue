<template>
    <Layout :user="user">
        <main>
            <h1>Kirjaudu sisään</h1>
            <p v-if="user">Kirjauduttu sisään onnistuneesti!</p>
            <p v-if="error">Kirjautuminen epäonnistui!</p>
            <form method="POST" v-if="!user">
                <div class="form-group">
                    <label for="username">Käyttäjätunnus</label><br>
                    <input type="text" name="username" id="username" class="form-control"><br>
                </div>

                <div class="form-group">
                    <label for="password">Salasana</label><br>
                    <input type="password" name="password" id="password" class="form-control"><br>
                </div>

                <button type="submit">Kirjaudu</button>
            </form>
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
        text-align: center;
    }

    form {
        display: inline-block;
        text-align: left;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        height: 25px;
        width: 300px;
    }

    form button {
        background-color: #ffffff;
        border: 1px solid #a9a9a9;
        width: 100px;
        height: 25px;
    }
</style>

<script>
    import Layout from "../components/layout.vue";

    export default {
        components: { Layout },
        props: ['user', 'error'],
        head: {
            title: {
                inner: 'Kirjautuminen',
                separator: '-',
                complement: 'RoboBisnes-hanke',
            },
        },
    };
</script>