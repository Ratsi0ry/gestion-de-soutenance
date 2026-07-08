<template>

    <!--<h3>Etudiant</h3>-->

    <form @submit.prevent="fetch_create_prof">

        <div class="item2">

            <div class="item1">
            <div>
                <label for="idProf">id prof :</label>
                <input type="text" id="idProf" required v-model="idprof">
            </div>

            <div>
                <label for="gender">Civilité:</label>
                    <select name="gender" id="gender" v-model="civilite">
                    <option value="Mr">Mr</option>
                    <option value="Mlle">Mlle</option>
                    <option value="Mme">Mme</option>
                </select>
            </div>
            </div><br>

            <label for="name">Nom :</label><br>
            <input type="text" id="name" required v-model="nom"><br><br>

            <label for="fstName">Prénom :</label><br>
            <input type="text" id="fstName" required v-model="prenom"><br><br>

            <label for="status">Grade : </label><br>
            <select name="status" id="status" v-model="grade">
                <option value="Assistant d'Enseignement Supérieur et de recherche">Assistant d'Enseignement Supérieur et de recherche</option>
                <option value="Proffeseur titulaire">Proffeseur titulaire</option>
                <option value="Maître de Conférences">Maître de Conférences</option>
                <option value="Docteur HDR">Docteur HDR</option>
                <option value="Docteur en Informatique">Docteur en Informatique</option>
                <option value="Doctorant en Informatique">Doctorant en Informatique</option>
            </select><br><br>

            <div class="ok">
                <button type="reset" class="btnReset"><img src="@/assets/icons8-rendez-vous-périodique-24-black.png" alt=""></button>
                <button type="submit" class="btnSubmit">Valider</button>
            </div>
        </div>

    </form>
</template>

<script>

    import { ref } from 'vue';
    const idprof = ref('');
    const nom = ref('');
    const prenom = ref('');
    const civilite = ref('');
    const grade = ref('');

    const fetch_create_prof = async() => {
        try {
            const reponse = await fetch('http://localhost:8000/addProf.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    idprof:idprof.value,
                    nom:nom.value,
                    prenom:prenom.value,
                    civilite:civilite.value,
                    grade:grade.value
                })
            });

            const request = await reponse.json();

            if (request.status === 'success') {
                alert('Professeur ajouté avec succès !');
                idprof.value = '';
                nom.value = '';
                prenom.value = '';
                civilite.value = '';
                grade.value = '';
            } 
            else if (request.status === 'error') {
                alert("Erreur lors de l'ajout du professeur.");
            } 
            else if (request.status === 'exist') {
                alert("L'id existe déjà.");
            }
        } catch (error) {
            console.error('Erreur lors de la requête');
        }
    }

    export default {
        setup() {
            return {
                idprof,
                nom,
                prenom,
                civilite,
                grade,
                fetch_create_prof
            };
        }
    }

</script>

<style scoped>
    .item1{
        display: flex;
        gap: 2rem;
        color: white;
        background-color: rgba(0, 0, 0, 0.904);
        justify-content: center;
        align-items: center;
        align-content: center;
        padding: 1rem;
        border-radius: 10px;
    }

    form{
        display: flex;
        justify-content: center;
        margin-top: 3rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    input{
        width: 18rem;
        font-size: medium;
        border-radius: 5px;
        border: 1px solid  rgba(0, 0, 0, 0.466);
    }

    input#idProf{   
        width: 5rem;
    }

    .item2{
        padding: 2rem; 
        border-radius: 8px;
        font-size: large;
        /*font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;*/
        background-color: #f1f5f9;
        border: 1px solid #a7a8aa;
    }

    .ok{
        display: flex;
        justify-content: flex-end;
        gap: 0.3rem;
    }

    .btnReset{
        border: 0;
    }

    .btnSubmit{
        color: white;
        background-color: green;
        border: green;
        border-radius: 8px;
        padding: 0.5rem;
    }
</style>