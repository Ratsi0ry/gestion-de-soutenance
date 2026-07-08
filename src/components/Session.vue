<template>
    <form @submit.prevent="submitSession">
        <div class="sessionContent">
            <div class="container">
                <p class="logo"><img src="@/assets/icons8-salle-de-réunion-38.png" alt=""></p>
                
                <label for="matr">Matricule</label><br>
                <input type="text" id="matr" v-model="matr"><br><br>

                <label for="org">idorg</label><br>
                <input type="number" id="org" v-model="idorg"><br><br>

                <label for="design">Design</label><br>
                <input type="text" id="design" v-model="design"><br><br>

                <label for="room">Lieu</label><br>
                <input type="text" id="room" v-model="room"><br><br>

                <div class="years">
                    <label for="year">Année univ :</label>
                    <input type="text" id="year" placeholder="2025-2026" v-model="years">
                </div><br>

                <div class="score">
                    <label for="score">Note attribuée:</label>
                    <input type="number" id="score" placeholder="note/20" v-model="score">
                </div><br>

                <div class="jury-fields">
                    <div>
                        <label for="pres">Président du Jury :</label><br>
                        <input type="text" id="pres" v-model="president" placeholder="Ex: Mr RATIARISON Venot">
                    </div><br>
                    <div>
                        <label for="exam">Examinateur :</label><br>
                        <input type="text" id="exam" v-model="examinateur" placeholder="Ex: Mr RALAIVAO Jean Christian">
                    </div><br>
                    <div>
                        <label for="rap_int">Rapporteur Interne :</label><br>
                        <input type="text" id="rap_int" v-model="rapporteur_int" placeholder="Ex: Mme RATIANANTITRA Volatiana">
                    </div><br>
                    <div>
                        <label for="rap_ext">Rapporteur Externe :</label><br>
                        <input type="text" id="rap_ext" v-model="rapporteur_ext" placeholder="Ex: Mr HARIJAONA José">
                    </div><br>
                </div><br>

                <div class="finalBtn">
                    <button type="reset" class="btnReset"><img src="@/assets/icons8-rendez-vous-périodique-24.png" alt=""></button>
                    <button type="submit" class="btnSubmit">Valider</button>
                    <button @click="printPdf($event)" id="downloadPdf"><img src="@/assets/icons8-pdf-2-36.png" alt=""></button>
                </div>

                <p>hello world!</p>
            </div>
        </div>
    </form>
</template>

<script setup>
    import { useRouter } from 'vue-router'
    import { ref } from 'vue'

    const router = useRouter()

    const matr = ref('')
    const idorg = ref('')
    const room = ref('')
    const years = ref('')
    const score = ref('')
    const design = ref('')
    
    const president = ref('')
    const examinateur = ref('')
    const rapporteur_int = ref('')
    const rapporteur_ext = ref('')

   const submitSession = async () => {
    try {
        await fetch('http://localhost:8000/session.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                matr: matr.value,
                idorg: idorg.value,
                room: room.value,
                years: years.value,
                score: score.value,
                design: design.value,
                president: president.value,
                examinateur: examinateur.value,
                rapporteur_int: rapporteur_int.value,
                rapporteur_ext: rapporteur_ext.value
            })
        });
        alert("Enregistrement validé !");
        } catch (error) {
            console.error(error);
        }
    }

   const printPdf = (event) => {

        event.preventDefault(); 
        event.stopPropagation();

        if (!matr.value || matr.value.trim() === '') {
            alert("Veuillez saisir un matricule valide avant de générer le PV.");
            return;
        }


        router.push({
            path: '/pagePdf',
            query: { matr: matr.value.trim() }
        });
    }
</script>

<style scoped>
    .sessionContent{
        display: flex;
        justify-content: center;
        margin-top: 0;
    }

    .container{
        padding: 1rem; 
        border-radius: 12px;
        font-size: medium;
        /*font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;*/
        background-color: rgba(0, 0, 0, 0.904);
        border: 1px solid #a7a8aa;
        color: white;
    }

    .container:hover{
        box-shadow: 0 5px 10px #00e676;
        transform: translateY(6px);
    }

    input#year, input#score{
        width: 8rem;
        padding: 0;
        text-align: center;
    }

    input.chx{
        width: fit-content;
    }

    input{
        width: 20rem;
        font-size: medium;
        border-radius: 5px;
        border: 0;

    }

    .auditors, .reporters{
        display: flex;
        gap: 0.5rem;
    }

    .finalBtn{
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        align-items: center;
    }

    .chxFlex, .years, .score{
        display: flex;
        align-items: center;
    }

    .years{
        gap: 1.5rem;
    }

    .score{
        gap: 0.5rem;
    }

    .btnReset, button#downloadPdf{
        background-color: rgba(24, 24, 24, 0.637);
        border: 0;
    }

    .btnSubmit{
        color: white;
        background-color: green;
        border: green;
        border-radius: 8px;
        padding: 0.5rem;
    }
    .btnSubmit:active, .btnReset:active{
        transform: scale(0);
        transition: 0.2s ease-in-out;
    }

    .logo{
        display: flex;
        justify-content: center;
        align-items: center; 
        padding: 0.5rem; 
        text-align: center; 
    }

    label, p{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
</style>