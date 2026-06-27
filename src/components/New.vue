<template>  
    <div class="choice">
        <section>
            <router-link to="/newSdt"><img src="/src/assets/icons8-levez-la-main-pour-répondre-48.png" alt=""><br>Elève</router-link>
        </section>
        <section>
            <router-link to="/newProf"><img src="/src/assets/icons8-prof-48.png" alt="">Professeur</router-link>
        </section>
    </div>
</template>
<script setup>
    import { useRoute } from 'vue-router';

    const route = useRoute()
</script>
<style scoped>
    .choice{
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        text-align: center;
        justify-content: center;
        align-items: center;
        margin-top: 3rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    a{
        padding: 4rem;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        color: white;
        height: 15rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    section{
        background-color: rgba(0, 0, 0, 0.904);
        border-radius: 12px;
    }

    section:hover{
        box-shadow: 0 5px 10px #00e676;
       transform: translateY(6px);
    }
    
</style>