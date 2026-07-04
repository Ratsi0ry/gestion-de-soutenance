<template>

    <form @submit.prevent="submitSession">

        <div class="sessionContent">
            <div class="container">
                <p  class="logo"><img src="@/assets/icons8-salle-de-réunion-38.png" alt=""></p>
                <label for="matr">Matricule</label><br>
                <input type="text" id="matr" v-model="matr"><br><br>

                <label for="org">idorg</label><br>
                <input type="number" id="org" v-model="idorg"><br><br>

                <label for="room">Lieu</label><br>
                <input type="text" id="room" v-model="room"><br><br>

                <div class="years">
                    <div>
                        <label for="year">Année univ :</label>
                    </div>
                    <div>
                        <input type="text" id="year" placeholder="2025-2026 " v-model="years">
                    </div>
                </div><br>

                <div class="score">
                    <div>
                        <label for="score">Note attribuéé:</label>
                    </div>
                    <div>
                        <input type="number" id="score" placeholder="note/20" v-model="score">
                    </div>
                </div><br>

                <div class="chxFlex">
                    <div>
                        <p>Examinateurs :</p>
                    </div>
                    <div>
                        <input type="checkbox" id="auditors" class="chx" value="01" v-model="a1">
                        <label for="auditors">01</label>
                        <input type="checkbox" id="auditors" class="chx" value="02" v-model="a2">
                        <label for="auditors">02</label>
                        <input type="checkbox" id="auditors" class="chx" value="03" v-model="a3">
                        <label for="auditors">03</label>
                    </div>
                </div>

                <div class="chxFlex">
                    <div>
                        <p>Rapporteurs :</p>
                    </div>
                    <div>
                        <input type="checkbox" id="reporters" class="chx" value="01" v-model="r1">
                        <label for="reporters">01</label>
                        <input type="checkbox" id="reporters" class="chx" value="02" v-model="r2">
                        <label for="reporters">02</label>
                        <input type="checkbox" id="reporters" class="chx" value="03" v-model="r3">
                        <label for="reporters">03</label>
                    </div>
                </div>

               

                <div class="finalBtn">
                    <button type="reset" class="btnReset"><img src="@/assets/icons8-rendez-vous-périodique-24.png" alt=""></button>
                    <button type="submit" class="btnSubmit">Valider</button>
                    <button @click="printPdf" id="downloadPdf"><img src="@/assets/icons8-pdf-2-36.png" alt=""></button>
                </div>

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
    const a1 = ref('')
    const a2 = ref('')
    const a3 = ref('')
    const r1 = ref('')
    const r2 = ref('')
    const r3 = ref('')

    const submitSession = async()=>{
        await fetch('http://localhost:8000/session.php',{
            method: 'POST',
            headers:{'Content-Type':'application/json'},
            body:JSON.stringify({
                matr: matr.value,
                idorg: idorg.value,
                room: room.value,
                years: years.value,
                score: score.value,
            })
        })
    }

    const printPdf = ()=> {
        router.push({
            path: '/pagePdf',
            query: { matr: matr.value }
        })
    }
</script>

<style scoped>
    .sessionContent{
        display: flex;
        justify-content: center;
        margin-top: 1rem;
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