<template>
   
        <div class="section1">

            <div>
                <label for="searchProf">Rechercher :</label>
                <input 
                    type="search"
                    id="searchProf"
                    v-model="$look_for"
                    @input="search"
                    placeholder="nom/id
                    "
                    class="search">
            </div>

            <div>
                <h3>{{ profs.length }} professeurs</h3>
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
               <th class="border-left">id</th>
               <th>civilité</th>
               <th>nom</th>
               <th>prenom</th>
               <th class="border-right">grade</th>
            </tr>
            <tr v-for="(prof, index) in profs" :key="index">
                <td>
                    <span v-if="!edit[index]">{{ prof.idprof }}</span>
                    <input type="text" v-else v-model="prof.idprof">
                </td>
                <td class="column">
                    <span v-if="!edit[index]">{{ prof.civilite }}</span>
                    <input type="text" v-else v-model="prof.civilite">
                </td>
                <td class="column">
                    <span v-if="!edit[index]">{{ prof.nom }}</span>
                    <input type="text" v-else v-model="prof.nom">
                </td>
                <td class="column">
                    <span v-if="!edit[index]">{{ prof.prenom }}</span>
                    <input type="text" v-else v-model="prof.prenom">
                </td>
                <td>
                    <span v-if="!edit[index]">{{ prof.grade }}</span>
                    <input type="text" v-else v-model="prof.grade">
                </td>
                <td class="btnEvent">
                    <button v-if="!edit[index]" @click="startEdit(index, prof.idprof)" class="update"><img src="@/assets/icons8-modifier-24.png">{{ edit[index] ? 'sauvegarder' : ''}}</button>
                    <div v-else class="buttonGroup">
                        <button @click="update(prof, condition, index)" class="update">Sauvegarder</button>
                        <button @click="edit[index] = false" class="cancel">Annuler</button>
                    </div>
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
    const condition = ref('');
    const $look_for = ref('');

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
        const confirmation = window.confirm("Êtes-vous sûr de vouloir supprimer ce professeur ?");
        if (!confirmation) {
            return;
        }
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

    const update = async (prof, condition, index) => {
        try {
            const response = await fetch(`http://localhost:8000/profs.php?condition=${condition}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(prof)
            });
            const result = await response.json();
            if (result.status === 'success') {
                alert('Professeur mis à jour avec succès!');
                edit.value[index] = false;
                get_professors();
            } else {
                alert("Erreur lors de la mise à jour du professeur.");
            }
        } catch (error) {
            alert("Erreur lors de la mise à jour du professeur!");
        }
    }

    const search = async () => {
        try {
            const response = await fetch(`http://localhost:8000/profs.php?look=${$look_for.value}`, {
                method: 'SEARCH'
            });
            const prof_list = await response.json();
            profs.value = prof_list;
        } catch (error) {
            alert("Erreur lors de la recherche des professeurs.");
        }
    }
    
    const startEdit = (index, i) => {
        condition.value = i;
        edit.value[index] = true;
    }

</script>
<style scoped>

    label{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
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
        text-align: center;
        padding-left:1.5rem;
        padding-right: 1.5rem;
    }

     th{
        padding: 0.5rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: rgba(20, 20, 20, 0.87);
        color: white;
    }

    .btnEvent{
        border: 0;
        display: flex;
        padding-left:0.5rem ;
        padding-bottom: 1rem;
        gap: 0.5rem;
        background-color: #f4f6f9;
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

    .update, .delete{
        border: 0;
        margin-top: 1rem;
        background-color:#f4f6f9;
    }

    .border-left{
        border-top-left-radius: 7px;
    }

    .border-right{
        border-top-right-radius: 7px;
    }

    td.column{
        border-left: 0.5px solid rgb(199, 199, 199);
        border-right: 0.5px solid rgb(199, 199, 199);;
    }

    select{
        border-radius: 5px;
    }

    td {
        background-color: #dee4e1;
        text-align: center;
        padding-left:1.2rem;
        padding-right: 1.2rem;
    }

    h3{
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        color: #161616;
    }

    input{
        width: 5rem;
        background-color: #d3d6dd;
        border: 0;
        font-weight: bold;
        text-align: center;
        color: #161616;
        border-radius: 5px;
    }

    input.search{
        background-color: #f2f3f3;
        text-align: center;
        border: 0.5px solid #b6aeae;
    }
</style>