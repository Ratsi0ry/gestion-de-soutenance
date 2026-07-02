<template>
    <div id="contain">

        <h4 class="putCenter">PROCES VERBAL</h4>
        <h4 class="putCenter">SOUTENANCE DE FIN D'ETUDES POUR L'OBTENTION DU DIPLOME DE LICENCE</h4>
        <h4 class="putCenter">PROFESSIONNELE</h4>
        <h4 class="putCenter"><b>Mention :</b>{{ info.mention }}</h4>
        <h4 class="putCenter"><b>Parcours :</b>{{ info.parcours }}</h4><br>

        
        <div class="text">
            <h4>{{ info.civilite }} {{ info.nom }} </h4>

            <p> a soutenu publiquement son mémoire de fin d'études pour l'obtention du diplôme de 
            Licence professionnelle.</p>

            <p>Après déliberation, la commission des membres du Jury a attribué la note de
            {{ info.note }}</p><br>

            <p><u>Membres du Jury</u></p>

            <p><b>Président :</b>{{ info.president }}</p>   

            <p><b>Examinateur :</b>{{ info.examinateur }}</p>

            <p><b>Rapporteurs :</b>{{ info.rappoteur1 }}</p>
            <p>{{ info.rappoteur2 }}</p><br><br>

            <div class="btn">
                <button @click="downloadPdf" id="download" class="no-print"><img src="/src/assets/icons8-télécharger-48.png" alt=""></button>
            </div>
        </div>

        </div>
</template>

<script setup>
import { ref } from 'vue'
import html2pdf from 'html2pdf.js'

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
const downloadPdf = ()=> {
    const element = document.getElementById('contain');
    const opt = {
        margin:       1,
        filename:     'ProcesVerbal.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2,
                        ignoreElements: (el) => el.classList.contains('no-print')
                    },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save();
}
</script>

<style scoped>

    .putCenter{
        text-align: center;
    }

    .text{
        margin-left: 15% ;
        margin-right: 15%;
        font-size: large;
    }

    #download{
        border: 0;
        background-color: #f4f6f9;
    }

    .btn{
        display: flex;
        justify-content: center;
    }

    .btn:hover{
        transform: scale(1.1);
        transition: 0.3s ease-in-out;
    }
</style>