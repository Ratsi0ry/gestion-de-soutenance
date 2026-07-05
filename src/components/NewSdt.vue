<template>

    <!--<h3>Etudiant</h3>-->

    <form @submit.prevent="fetch_create_student">

        <div class="item2">

            <div class="item1">
            <div>
                <label for="level">Niveau :</label>
                    <select name="level" id="level" v-model="niveau">
                    <option value="L1">L1</option>
                    <option value="L2">L2</option>
                    <option value="L3">L3</option>
                    <option value="M1">M1</option>
                    <option value="M2">M2</option>
                </select>
            </div>

            <div>
                <label for="class">Parcours :</label>
                    <select name="class" id="class" v-model="parcours">
                    <option value="GB">GB</option>
                    <option value="IG">IG</option>
                    <option value="SR">SR</option>
                </select>
            </div>
        </div><br>

            <div class="item3">
                <div>
                    <label for="gender">Civilité:</label>
                    <select name="gender" id="gender" v-model="civilite">
                        <option value="Mr">Mr</option>
                        <option value="Mlle">Mlle</option>
                        <option value="Mme">Mme</option>
                    </select>
                </div>

                <div>
                    <label for="number">Matricule :</label>
                    <input type="int" id="number" required v-model="matricule">
                </div>
            </div><br>

            <label for="name">Nom :</label><br>
            <input type="text" id="name" required v-model="nom"><br><br>

            <label for="fstName">Prénom :</label><br>
            <input type="text" id="fstName" required v-model="prenom"><br><br>

            <label for="email">Email :</label><br>
            <input type="email" id="email" required v-model="adr_email"><br><br><br>

            <div class="ok">
                <button type="reset" class="btnReset"><img src="@/assets/icons8-rendez-vous-périodique-24-black.png" alt=""></button>
                <button type="submit" class="btnSubmit">Valider</button>
            </div>
        </div>

    </form>
</template>

<script>
    import { ref } from 'vue';
    const matricule = ref('');
    const nom = ref('');
    const prenom = ref('');
    const niveau = ref('');
    const parcours = ref('');
    const adr_email = ref('');
    const civilite = ref('');

    const fetch_create_student = async() => {
        try {
            const reponse = await fetch('http://localhost:8000/createStudents.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body : JSON.stringify({
                    matricule:matricule.value,
                    nom:nom.value,
                    prenom:prenom.value,
                    niveau:niveau.value,
                    parcours:parcours.value,
                    adr_email:adr_email.value,
                    civilite:civilite.value
                })
            });
            
            const request = await reponse.json();
            
            if (request.status === 'success') {
                alert('Etudiant ajouté avec succès!');
                matricule.value = '';
                nom.value = '';
                prenom.value = '';
                niveau.value = '';
                parcours.value = '';
                adr_email.value = '';
                civilite.value = '';
            }
            else if (request.status === 'error') {
                alert("Erreur lors de l'ajout de l'etudiant " + request.message);
            } 
            else if (request.status === 'exist'){
                alert("Le matricule existe déjà!");
            }

        } catch (error) {
            console.error('Erreur lors de la requête');
        }
    }

    export default {
        setup() {
            return {
                matricule,
                nom,
                prenom,
                niveau,
                parcours,
                adr_email,
                civilite,
                fetch_create_student
            };
        }
    };
    
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

    input#number{   
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

    .item3{
        gap:0.5rem;
        display: flex; 
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