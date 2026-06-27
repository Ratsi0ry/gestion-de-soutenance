<template>

  <div class="app-container">
  <aside class="sidebar">
    <nav>
      <section class="navWelcome"><img src="./assets/icons8-chapeau-de-diplôme-64.png"></section>
      <ul>
        <li><img src="./assets/icons8-ajouter-24.png"><router-link to="/new"><b>Nouveau</b></router-link></li>
        <li><img src="./assets/icons8-conférencier-24.png"><router-link to="/prof"><b>Professeurs</b></router-link></li>
        <li><img src="./assets/icons8-liste-24.png"><router-link to="/sdt"><b>Etudiants</b></router-link></li>
        <li><img src="./assets/icons8-diplôme-2-24.png"><router-link to="/session"><b>Session</b></router-link></li>
      </ul>
    </nav>
  </aside>
  
  <main class="content">
    <header>
      <h1>
        <router-view><img src="./assets/icons8-onglet-28.png">{{ title }}</router-view>
      </h1>
      <router-link to="/" @mouseenter="hover=true" @mouseleave="hover=false" class="logOut">
        <img src="./assets/icons8-déconnexion-24.png" class="logOut_btn">
        <span v-show="hover">se déconnecter</span>
      </router-link>
    </header>
    <section class="dashboard-grid">
      <router-view></router-view>
      </section>
  </main>
    </div>

</template>

<script setup>
  import {ref, watch} from 'vue'
  import { useRoute } from 'vue-router'

  //path vers la destination
  const route = useRoute()
  console.log(route)
  const title = ref('')

  watch(
    ()=> route.path,
    (newPath)=> {
      if(newPath == '/sdt' || '/') title.value = 'Etudiants'
      if(newPath == '/prof') title.value = 'Professeurs'
      if(newPath == '/session') title.value = 'Session'
      if(newPath == '/new') title.value = 'Nouveau'
    },
    {immediate:true}
    )

    const hover = ref(false)
</script>

<style scoped>
html {
  scroll-behavior: smooth;
}

body {
  margin: 0;
  padding: 0;
  width: 100vh;
}

header {
  display: flex; 
  height: 60px;
  position: sticky  ;
  background-color: #f1f5f9;
  justify-content: space-between;
  border-bottom: 1px solid #e5e7eb;
}

main.content{
    padding-top: 0;
    background-color:#f4f6f9;
}

.app-container {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 160px;
  padding: 1rem;
  color: white;
  position: sticky;
  background-color: rgba(0, 0, 0, 0.904);
}

.content {
  flex: 1;
}

.logOut {
    display: flex;
    align-items: center;
    padding: 0.3rem;
    transition: 2s ease-in-out;
}

nav li {
    margin-bottom: 0.3rem;
    margin-top: 6rem;
    list-style: none;
}

li {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.3rem;
    transition: 0.1s ease-in;
}

li:hover {
  border-left: 5px solid #00e676;
  border-radius: 4px;
  transform: scale(1.1);
}

a {
  text-decoration: none;
  color: white;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin-right: 1rem;
}

h1  {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 22px;
}

.navWelcome {
  display: flex;
  justify-content: center;
}


h1 {
  font-size: 22px;
  padding: 1rem;
  align-items: center;
  display: flex;
  gap: 0.2rem;
}

.logOut_btn {
  align-items: center; 
  display: flex;
  padding: 0.5rem;
}

.dashboard-grid {
  padding: 1rem;
}

.logOut {
    display: flex;
    align-items: center;
    padding: 0.3rem;
    transition: 2s ease-in-out;
}

aside.sidebar{
  display: flex;
  justify-content: center;
}

span{
  color: black;
}

</style>