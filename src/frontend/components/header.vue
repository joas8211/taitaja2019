<template>
    <header>
        <a href="/">
            <img src="/assets/robobisnes-logo.png" alt="RoboBisnes logo">
        </a>
        <nav>
            <ul>
                <li><a href="/">Hanke</a></li>
                <li><a href="/pepper">Pepper-robotti</a></li>
                <li><a href="/#yhteystiedot">Yhteydenotto</a></li>
                <template v-if="user">
                    <li><a href="/robotin-ohjaus">Robotin ohjaus</a></li>
                    <li><a href="/robotin-tiedot">Robotin tiedot</a></li>
                    <li id="login-link"><a href="/kirjaudu-ulos">Kirjaudu ulos</a></li>
                </template>
                <li id="login-link" v-else><a href="/kirjaudu">Kirjautuminen</a></li>
            </ul>
        </nav>
    </header>
</template>

<style>
    header {
        display: flex;
        align-items: center;
        width: 100%;
        height: 70px;
        background-color: #ffffff;
    }

    header img {
        width: 50px;
        height: 50px;
        margin: 10px;
    }

    header nav {
        width: 100%;
    }

    header nav ul {
        list-style: none;
    }

    header nav ul li {
        display: inline-block;
        margin: 0 20px;
    }

    header nav ul li#login-link {
        float: right;
    }

    header nav ul li a {
        font-family: "MoonHouse";
        font-size: 25px;
        color: #000000;
        text-decoration: none;
    }

    @media screen and (max-width: 985px) {
        header {
            height: auto;
        }

        header nav ul li {
            display: block;
            margin: 20px;
        }

        header nav ul li#login-link {
            float: none;
        }
    }
</style>

<script>
    export default {
        props: ['user'],
    };
</script>