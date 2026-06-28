<template>

    <div class="item1">
        <div class="pt1">
            <label for="search"></label>
            <input type="search" id="search" placeholder=" Rechercher nom/matricule">
        </div>

        <div class="pt2">
            <label for="sort">Niveau :</label>
            <select name="sortSdt" id="sort">
            <option value="L1">L1</option>
            <option value="L2">L2</option>
            <option value="L3">L3</option>
            <option value="M1">M1</option>
            <option value="M2">M2</option>
        </select>
        </div>

        <div class="pt3">
            <label for="course">Parcours :</label>
            <select name="course" id="course">
                <option value="GB">GB</option>
                <option value="SR">SR</option>
                <option value="IG">IG</option>
            </select>
         </div>

        <div class=" pt4">
            <label for="success">trier par:</label>
            <select name="suceess" id="success">
                <option value="opt1">soutenance reussi</option>
                <option value="opt2">soutenance en attente</option>
            </select>
        </div>

        <div class="pt5">
           <h4>Total effectif par Niveau</h4>
        </div>
    </div>

    <div class="item3">
        <table>
        <tr>
            <th>Matricule</th>
            <th>Nom</th>
            <th>prenom</th>
            <th>Niveau</th>
            <th>parcours</th>
            <th>Email</th>
            <th>anne_univ</th>
            <th>note</th>
            <th>design</th>
            
           
        </tr>
        <tr>
            <td>3333</td>
            <td>John</td>
            <td>Doe</td>
            <td>L3</td>
            <td>GB</td>
            <td>JohnDoe@gmail.com</td>
            <td>2025-2026</td>
            <td>18</td>
            <td>Validé</td>
            <td class="btnEvent">
                <button class="update"><img src="/src/assets/icons8-modifier-24.png"></button>
                <button class="delete"><img src="/src/assets/icons8-supprimer-24.png"></button>
            </td> 
        </tr>
    </table>
    </div>

</template>

<script setup>
import { ref } from 'vue';

const show = ref(false)
</script>
<style scoped>

    .item2{
        display: flex;
        gap: 2rem;
    }

    button{
        margin-top: 1.2rem;
        padding: 0.5rem;
        height: 5px;
        display: flex;
        justify-content: center;
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
        padding-left:1.2rem;
        padding-right: 1.2rem;
    }

    /*.stdTotal{
        background-color: rgb(188, 189, 189);
        width: 100px;
        padding: 0.3rem;
        border-radius: 5px;
    }*/

    .item1{
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.1rem;
        height: 6rem;
        text-align: center;
        justify-content: center;
        align-items: center;
    }

    .btnEvent{
        border: 0;
        display: flex;
        padding-left:0.5rem ;
        padding-bottom: 1rem;
        gap: 0.5rem;
    }

    .nivClass {
        display: flex;
        gap: 2rem;
    }

    #submit{
        margin-left: 8rem;
    }

    #search{
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