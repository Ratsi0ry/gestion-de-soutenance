<template>
    <div class="contain">

        <h4 class="putCenter">PROCES VERBAL</h4>
        <h4 class="putCenter">SOUTENANCE DE FIN D'ETUDES POUR L'OBTENTION DU DIPLOME DE LICENCE</h4>
        <h4 class="putCenter">PROFESSIONNELE</h4>
        <h4 class="putCenter"><b>Mention :</b>{{ info.mention }}</h4>
        <h4 class="putCenter"><b>Parcours :</b>{{ info.parcours }}</h4><br>

        
        <h4>{{ info.civilite }} {{ info.nom }} </h4>

        <p> a soutenu publiquement son mémoire de fin d'études pour l'obtention du diplôme de 
        Licence professionnelle.</p>

        <p>Après déliberation, la commission des membres du Jury a attribué la note de
        {{ info.note }}</p><br>

        <p><u>Membres du Jury</u></p>

        <p><b>Président :</b>{{ info.president }}</p>   

        <p><b>Examinateur :</b>{{ info.examinateur }}</p>

        <p><b>Rapporteurs :</b>{{ info.rappoteur1 }}</p>
        <p>{{ info.rappoteur2 }}</p>
    
    </div>
</template>

<script setup>
import { ref } from 'vue';

const info = ref({
    mention : 'Informatique',
    parcours: 'Informatique général',
    civilite: 'Mr',
    nom: 'Rakoto Gilbert',
    note: '18/20',
    president: 'Mr RATIARISON Venot, Maître de Conférences',
    examinateur: 'Mr RALAIVAO Jean Christian, Assistant d\'Enseignement Supérieur de Recherche',
    rappoteur1: 'Mme RATIANANTITRA Volatiana Marielle, Maître de Conférences',
    rappoteur2: 'Mr HARIJAONA José'
    
})
</script>

<style scoped>
    .element{
        padding: 0;
    }

    .putCenter{
        display: flex;
        justify-content: center;
    }

    .contain{
        padding: 7rem;
        font-size: large;
    }

    h4.putCenter{
        display: flex;
        text-align: center;
    }
</style>