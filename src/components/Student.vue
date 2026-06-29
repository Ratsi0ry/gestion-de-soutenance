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
        <tr v-for="student in students" :key="student.matr">
            <td>
                <span v-if="!edit[student.matr]">{{ student.matr }}</span>
                <input type="text" v-else v-model="student.matr">
            </td>
            <td>
                <span v-if="!edit[student.name]">{{student.name }}</span>
                <input type="text" v-else v-model="student.name">
            </td>
            <td>
                <span v-if="!edit[student.fstName]">{{ student.fstName }}</span>
                <input type="text" v-else v-model="student.fstName">
            </td>
            <td>
                <span v-if="!edit[student.level]">{{ student.level }}</span>
                <input type="text" v-else v-model="student.level">
            </td>
            <td>
                <span v-if="!edit[student.class]">{{ student.class }}</span>
                <input type="text" v-else v-model="student.class">
            </td>
            <td>
                <span v-if="!edit[student.email]">{{ student.email }}</span>
                <input type="text" v-else v-model="student.email">
            </td>
            <td>
                <span v-if="!edit[student.years]">{{ student.years }}</span>
                <input type="text" v-else v-model="student.years">
            </td>
            <td>
                <span v-if="edit[student.score]">{{ student.score }}</span>
                <input type="text" v-else v-model="student.score">
            </td>
            <td>
                <span v-if="status[student.status]">{{ student.status }}</span>
                <input type="text" v-else v-model="student.status">
            </td>
            <td class="btnEvent">
                <button @click="update(client)" class="update"><img src="/src/assets/icons8-modifier-24.png">{{ edit[student.id] ? 'sauvegarder' : ''}}</button>
                <button @click="remove(client.matr)" class="delete"><img src="/src/assets/icons8-supprimer-24.png"></button>
            </td> 
        </tr>
    </table>
    <p v-if="msg">{{ msg }}</p>
    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue';
const students = ref([])
const edit = ref({})
const msg = ref('')

const fetchStudents = async()=>{
    try{
        const response = await fetch('http://localhost:8000/student.php')
        const result = await response.json()

        if(result.status == 'success'){
            students.value = result.data1
            infos.value = result.data2
            console.log("Affichages des etudiants reussie")
        }else{
            console.error('Erreur: ', result.msg)
        }
    }catch(error){
        console.error(  "Impossible de recupérer les données")
    };
}

onMounted(()=>{
    fetchStudents()
})

const update = async(student)=>{
    if(!edit[student.matr]){
        edit[student.matr].value = true
    }else{
        try{
            const response = await fetch('http://localhost:8000/student.php?action=update',{
                method: 'POST',
                headers: {
                    'Content-Type' : 'application/json'
                },
                body: JSON.stringify({
                    matr: student.matr,
                    name: student.name,
                    fstName: student.fstName,
                    level: student.level,
                    class: student.class,
                    email: student.email,
                    years: student.years,
                    score: student.score,
                    status: student.status
                })
            })

            const result = await response.json()
            msg.value = result.message

            if(result.status == 'success'){
                edit[student.value] = false
            }else{
                alert("erreur" + result.message)
            }

        }catch(error){
            console.error()
        }
    }
}

const remove = async(matr)=>{
    if(confirm("Cette ligne va être supprimé")){
        try{
            const response = await fetch('http://localhost:8000/student.php?action=delete', {
                method: 'POST',
                headers: {
                    'Content-Type' : 'application/json'
                },
                body: JSON.stringify({matr: matr})
            })

            const result = await response.json();
            msg.value = result.message

            if(result.status == success){
                const index = students.value.findIndex(c=> c.matr == matr) //finIndex: trouvé l'id corresponant dans le tableau
                if(index >-1){
                students.value.splice(index, 1)}
                msg.value="Client supprimé de la base de donnéé"
            }

        }catch(error){
            console.error('Erreur de suppression')
            msg.value = 'Impossible de supprimer la ligne'
        }
    }
}
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