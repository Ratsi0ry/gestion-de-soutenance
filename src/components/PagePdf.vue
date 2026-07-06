<template>
    <div id="contain" v-if="info">

        <h3 class="putCenter">PROCÈS-VERBAL</h3>
        <h4 class="putCenter">SOUTENANCE DE FIN D'ÉTUDES POUR L'OBTENTION DU {{ diplome}}</h4>
        <h4 class="putCenter"><b>Mention :</b> Informatique</h4>
        <h4 class="putCenter"><b>Parcours :</b> {{ info.class }}</h4><br><br>

        <div class="text">
            <h4>{{ info.civilite }} {{ info.name }} {{ info.fstName }}</h4>

            <p>a soutenu publiquement son mémoire de fin d'études pour l'obtention du {{ diplome.toLowerCase() }}.</p>

            <p>Après délibération, la commission des membres du Jury a attribué la note de : 
            <strong>{{ info.score }}/20</strong></p><br>

            <p><u>Membres du Jury :</u></p>
            <p><b>Président :</b> {{ info.president }}</p>   
            <p><b>Examinateur :</b> {{ info.examinateur }}</p>
            <p><b>Rapporteurs :</b> {{ info.rapporteur_int }} <span v-if="info.rapporteur_ext">et {{ info.rapporteur_ext }}</span></p>

            <div class="btn">
                <button @click="downloadPdf" id="download" class="no-print"><img src="@/assets/icons8-télécharger-48.png" alt=""></button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import html2pdf from 'html2pdf.js'

const diplome = computed(() => {
    if (!info.value || !info.value.niveau) return 'DIPLÔME';
    
    const niv = info.value.niveau.toUpperCase();
    
    if (niv.includes('M')) { 
        return 'DIPLÔME DE MASTER PROFESSIONNEL';
    } 

    else {
        return "DIPLÔME DE LICENCE PROFESSIONNELLE";
    }
});

const route = useRoute()
const info = ref(null)

const fetchSession = async()=>{
    const matricule = route.query.matr?.toString() || ''
    const response = await fetch(`http://localhost:8000/pagePdf.php?matr=${encodeURIComponent(matricule)}`)
    const result = await response.json()
    if (result.status === 'success') info.value = result.data
}

onMounted(()=>{
    fetchSession()
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