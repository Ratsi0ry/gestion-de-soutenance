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
            <input type="text" id="nameProf" class="put"><br><br>

            <!--prenom-->
            <label for="fstNameProf">Prénom :</label>
               <input type="text" id="fstNameProf" class="put"><br><br>

            <!--civilité-->
            <label for="gender" style="margin-left: 0.5rem;">Civilité :</label>
            <input type="text" id="genderProf" class="put">
            <!--grade-->
            <label for="status">Grade : </label>
            <select name="status" id="status">
                <option value="val1">Assistant d'Enseignement Supérieur et de recherche</option>
                <option value="val2">Proffeseur titulaire</option>
                <option value="val3">Maître de Conférences</option>
                <option value="val4">Docteur HDR</option>
                <option value="val5">Docteur en Informatique</option>
                <option value="val6">Doctorant en Informatique</option>
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
            <tr>
                <td>01</td>
                <td>Mr</td>
                <td>RATIARISON</td>
                <td>Venot</td>
                <td>Maître de Conférences</td>
                <td class="btnEvent">
                    <button class="update"><img src="@/assets/icons8-modifier-24.png"></button>
                    <button class="delete"><img src="@/assets/icons8-supprimer-24.png"></button>
                </td>
            </tr>   
             
        </table>
    </div>
</template>

<script setup>
import {ref} from 'vue'

const show =ref(false)
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

    th{
        padding: 0.5rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: rgba(0, 0, 0, 0.87);
        color: white;
        border: 1px solid black;
    }

    input.put:hover{
        background-color: #00e676;
        border-radius: 5px;
        font-weight: bold;
    }

    input:active{
        background-color: #00e676;
        border: 0;
    }
</style>