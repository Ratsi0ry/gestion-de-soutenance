<template>

    <div class="item1">
        <div class="pt1">
            <label for="search"></label>
            <input type="search" id="search" v-model="search" placeholder=" Rechercher nom/matricule">
        </div>

        <div class="pt2">
            <label for="sortSdt">Niveau :</label>
            <select name="sortSdt" id="sort" v-model="selectedLevel" @change="fetchSelectedValue">
                <option value="">Tous les niveaux</option>
                <option value="L1">L1</option>
                <option value="L2">L2</option>
                <option value="L3">L3</option>
                <option value="M1">M1</option>
                <option value="M2">M2</option>
        </select>
        </div>

        <div class="pt3">
            <label for="class">Parcours :</label>
            <select name="class" id="course" v-model="selectedClass" @change="fetchSelectedValue">
                <option value="">Tous les parcours</option>
                <option value="GB">GB</option>
                <option value="SR">SR</option>
                <option value="IG">IG</option>
            </select>
         </div>

        <div class=" pt4">
            <label for="success">trier par:</label>
            <select name="success" id="success" v-model="selectedStat" @change="fetchSelectedValue">
                <option value="">Tous les statuts</option>
                <option value="reussi">soutenance reussi</option>
                <option value="en attente">soutenance en attente</option>
            </select>
        </div>

        <div class="pt5">
           <h4 v-if="selectedClass || selectedLevel || selectedStat">{{ totalStudents }}</h4>
           <h4 v-else>{{ totalStudents }}</h4>
        </div>
    </div>

    <div class="item3">
        <table>
        <tr>
            <th class="start">Matricule</th>
            <th>Nom</th>
            <th>prenom</th>
            <th>Niveau</th>
            <th>parcours</th>
            <th>Email</th>
            <th>anne_univ</th>
            <th>note</th>
            <th class="end">design</th>     
        </tr>

        <tr v-for="(student, index) in students" :key="student.matr">
            <td>
                <span v-if="!edit[index]">{{ student.matr }}</span>
                <input type="text" v-else v-model="student.matr" class="put">
            </td>
            <td>
                <span v-if="!edit[index]">{{ student.name }}</span>
                <input type="text" v-else v-model="student.name" class="put">
            </td>
            <td>
                <span v-if="!edit[index]">{{ student.fstName }}</span>
                <input type="text" v-else v-model="student.fstName" class="put">
            </td>
            <td>
                <span v-if="!edit[index]">{{ student.level }}</span>
                <input type="text" v-else v-model="student.level" class="put">
            </td>
            <td>
                <span v-if="!edit[index]">{{ student.class }}</span>
                <input type="text" v-else v-model="student.class" class="put">
            </td>
            <td>
                <span v-if="!edit[index]">{{ student.email }}</span>
                <input type="text" v-else v-model="student.email" class="put">
            </td>
            <td>
                <span v-if="!edit[index]">{{ student.years }}</span>
                <input type="text" v-else v-model="student.years" class="put">
            </td>
            <td>
                <span v-if="!edit[index]">{{ student.score }}</span>
                <input type="text" v-else v-model="student.score" class="put">
            </td>
            <td>
                <span v-if="!edit[index]">{{ student.design }}</span>
                <input type="text" v-else v-model="student.design" class="put">
            </td>
            <td class="btnEvent">
                <button @click="update(student, index)" class="update"><img src="@/assets/icons8-modifier-24.png">{{ edit[index] ? 'sauvegarder' : 'modifier'}}</button>
                <button @click="remove(student.matr)" class="delete"><img src="@/assets/icons8-supprimer-24.png"></button>
            </td> 
        </tr>
    </table>
    <p v-if="msg">{{ msg }}</p>
    </div>

</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
const students = ref([])
const edit = ref({})
const msg = ref('')
const search= ref('')
const selectedLevel = ref('')
const selectedClass = ref('')
const selectedStat = ref('')
const totalStudents = ref(0)

const fetchSelectedValue = async() => {
    const hasFilters = selectedLevel.value || selectedClass.value || selectedStat.value;

    if (!hasFilters && !search.value.trim()) {
        await fetchStudents();
        return;
    }

    try{
        const response = await fetch(`http://localhost:8000/filter.php?level=${selectedLevel.value}&class=${selectedClass.value}&stat=${selectedStat.value}`)
        const result = await response.json()

        if(result.status == 'success'){
            students.value = result.data.map(student => ({
                ...student,
                years: student.years ?? '',
                score: student.score ?? '',
                design: student.design ?? ''
            }))
            totalStudents.value = result.totalCount || students.value.length
        } else{
            console.error("Erreur", result.message)
        }
    }catch(error){
        console.error("Impossible de filtrer par niveau", error)
    }
}

onMounted(()=>{
    fetchStudents()
})

const fetchStudents = async(query = '') => {
    try{
        const url = query 
        ? `http://localhost:8000/search.php?q=${encodeURIComponent(query)}`
        : 'http://localhost:8000/search.php';

        const response  = await fetch(url)
        const result = await response.json()

        if(result.status == 'success'){
            students.value = result.data.map(student => ({
                ...student,
                years: student.years ?? '',
                score: student.score ?? '',
                design: student.design ?? ''
            }))
            totalStudents.value = students.value.length
        } else {
            console.error("Erreur", result.message);
        }
    } catch(error){
        console.error("Impossible de récupérer les données", error)
    }
}

watch(search, (newValue) => {
    fetchStudents(newValue.trim());
});

const update = async(student, index)=>{
    if(!edit.value[index]){
        edit.value[index] = true
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
                    design: student.design,
                    status: student.status
                })
            })

            const result = await response.json()
            msg.value = result.message

            if(result.status == 'success'){
                edit.value[index] = false
            }else{
                alert("erreur" + result.message)
            }

        }catch(error){
            console.error("Impossible de modifier les données", error)
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

            if(result.status == 'success'){
                const index = students.value.findIndex(c=> c.matr == matr) //finIndex: trouvé l'id corresponant dans le tableau
                if(index >-1){
                students.value.splice(index, 1)}
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

    td {
        border: 1px solid black;
        text-align: center;
        padding-left:1.2rem;
        padding-right: 1.2rem;
    }

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

    input.put{
        width: 4rem;
        border: 0;
        background-color: #f4f6f9;
        padding: 0.5rem;
    }

    th{
        padding: 0.5rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: rgba(0, 0, 0, 0.87);
        color: white;
    }

    input.put:hover{
        background-color: #00e676;
        border-radius: 5px;
        font-weight: bold;
    }

    th.start{
        background-color: rgba(0, 0, 0, 0.87);
        border-top-left-radius: 7px;
        color: white;
    }

    .end{
        background-color: rgba(0, 0, 0, 0.87);
        border-top-right-radius: 7px;
        color: white;
    }


</style>