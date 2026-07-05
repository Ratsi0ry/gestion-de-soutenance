<template>
   
        <div class="section1">

            <div>
                <label for="searchProf">Rechercher :</label>
                <input type="search"  id="searchProf" placeholder="nom/id">
            </div>

            <div>
                <h3>Nombre de proffeuseurs</h3>
            </div>
        </div>

    <div v-if="show" class="section2">
        <form>
            <!--nom-->
            <label for="nameProf" style="margin-left:1rem;">Nom :</label>
            <input type="text" id="nameProf"><br><br>

            <!--prenom-->
            <label for="fstNameProf">Prénom :</label>
               <input type="text" id="fstNameProf"><br><br>

            <!--civilité-->
            <label for="gender" style="margin-left: 0.5rem;">Civilité :</label>
            <select name="gender" id="gender">
                <option value="Mr">Mr</option>
                <option value="Mlle">Mlle</option>
                <option value="Mme">Mme</option>
            </select><br><br>

            <!--grade-->
            <label for="status">Grade : </label>
            <select name="status" id="status">
                <option value="Assistant d'Enseignement Supérieur et de recherche">Assistant d'Enseignement Supérieur et de recherche</option>
                <option value="Proffeseur titulaire">Proffeseur titulaire</option>
                <option value="Maître de Conférences">Maître de Conférences</option>
                <option value="Docteur HDR">Docteur HDR</option>
                <option value="Docteur en Informatique">Docteur en Informatique</option>
                <option value="Doctorant en Informatique">Doctorant en Informatique</option>
            </select><br><br>
     
            <button type="submit" id="submit">Valider</button> 
        </form> 
    </div><br>
    
    <div class="section3">
        <table>
            <tr>
               <th>id</th>
               <th>civilité</th>
               <th>nom</th>
               <th>prenom</th>
               <th>grade</th>
            </tr>
            <tr v-for="prof in profs" :key="prof.idprof">
                <td>
                    <span v-if="!edit[prof.idprof]">{{ prof.idprof }}</span>
                    <input type="text" v-else v-model="prof.idprof">
                </td>
                <td>
                    <span v-if="!edit[prof.civilite]">{{ prof.civilite }}</span>
                    <input type="text" v-else v-model="prof.civilite">
                </td>
                <td>
                    <span v-if="!edit[prof.nom]">{{ prof.nom }}</span>
                    <input type="text" v-else v-model="prof.nom">
                </td>
                <td>
                    <span v-if="!edit[prof.prenom]">{{ prof.prenom }}</span>
                    <input type="text" v-else v-model="prof.prenom">
                </td>
                <td>
                    <span v-if="!edit[prof.grade]">{{ prof.grade }}</span>
                    <input type="text" v-else v-model="prof.grade">
                </td>
                <td class="btnEvent">
                    <button @click="update(prof)" class="update"><img src="@/assets/icons8-modifier-24.png"></button>
                    <button @click="remove(prof.idprof)" class="delete"><img src="@/assets/icons8-supprimer-24.png"></button>
                </td>
            </tr>   
             
        </table>
    </div>
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    const profs = ref([]);
    const show = ref(false);
    const edit = ref({});

    const get_professors = async () => {
        try {
            const response = await fetch(`http://localhost:8000/profs.php`, {
                method: 'GET'
            });
            const prof_list = await response.json();
            profs.value = prof_list;
            
        } catch (error) {
            console.error("error");
        }
    }
    onMounted(() => {
        get_professors();
    });

    const remove = async (idprof) => {
        try {
            const response = await fetch(`http://localhost:8000/profs.php?idprof=${idprof}`, {
                method: 'DELETE'
            });
            const result = await response.json();
            if (result.status === 'success') {
                alert('Professeur supprimé avec succès!');
                get_professors();
            } else {
                alert("Erreur lors de la suppression du professeur.");
            }
        } catch (error) {
            alert("Erreur lors de la suppression du professeur!");
        }
    }

    const update = async (prof) => {
        try {
            const response = await fetch(`http://localhost:8000/profs.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(prof)
            });
            const result = await response.json();
            if (result.status === 'success') {
                alert('Professeur mis à jour avec succès!');
                get_professors();
            } else {
                alert("Erreur lors de la mise à jour du professeur.");
            }
        } catch (error) {
            alert("Erreur lors de la mise à jour du professeur!");
        }
    }



</script>
<style scoped>
    .section1{
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    table{
        border-collapse: collapse;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
    }

    td,th {
        border: 1px solid black;
        text-align: center;
        padding-left:1.5rem;
        padding-right: 1.5rem;
    }

    .btnEvent{
        border: 0;
        display: flex;
        padding-left:0.5rem ;
        padding-bottom: 1rem;
        gap: 0.5rem;
    }

    .item1{
        display: flex;
        align-items: center; 
        gap: 2rem;
    }

    .section1{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.1rem;
        height: 6rem;
        text-align: center;
        justify-content: center;
        align-items: center;
    }

    .section3{
        margin-left: 3.4rem;
    }

    #searchProf{
        border-radius: 8px;
        padding: 0.3rem;
        border: 1px solid #a7a8aa;
    }

    .update, .delete{
        border: 0;
        margin-top: 1rem;
        background-color:#f4f6f9;
    }
</style>