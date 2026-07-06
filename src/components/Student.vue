<template>

    <div class="item1">
        <div class="pt1">
            <label for="search"></label>
            <input type="search" id="search" v-model="search" placeholder=" Rechercher nom/matricule">
        </div>

        <div class="pt2">
            <label for="sortSdt">Niveau :</label>
            <select name="sortSdt" id="sort" v-model="selectedLevel">
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
            <select name="class" id="course" v-model="selectedClass">
                <option value="">Tous les parcours</option>
                <option value="GB">GB</option>
                <option value="SR">SR</option>
                <option value="IG">IG</option>
            </select>
         </div>

        <div class=" pt4">
            <label for="success">trier par:</label>
            <select name="success" id="success" v-model="selectedStat">
                <option value="">Tous les statuts</option>
                <option value="reussi">soutenance reussi</option>
                <option value="en attente">soutenance en attente</option>
            </select>
        </div>

        <div class="pt5">
           <h4 v-if="selectedClass || selectedLevel || selectedStat">{{ totalStudents }}</h4>
           <p v-else class="total">{{ totalStudents }} elèves</p>
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
        </tr>

        <tr v-for="student in filteredStudents" :key="student.matricule">
            <td>
                <span>{{ student.matricule }}</span>
            </td>
            <td>
                <span>{{ student.nom }}</span>
            </td>
            <td>
                <span>{{ student.prenom }}</span>
            </td>
            <td>
                <span>{{ student.niveau }}</span>
            </td>
            <td>
                <span>{{ student.parcours }}</span>
            </td>
            <td>
                <span>{{ student.adr_email }}</span>
            </td>
            <td>
                <span>{{ student.annee_univ ? student.annee_univ : ''}}</span>
            </td>
            <td>
                <span v-if="student.note !==  null">{{ student.note }}</span>
            </td>
            <td class="btnEvent">
                <button @click="update(student)" class="update"><img src="@/assets/icons8-modifier-24.png"></button>
                <button @click="remove(student.matricule)" class="delete"><img src="@/assets/icons8-supprimer-24.png"></button>
            </td> 
        </tr>
    </table>
    <p v-if="msg">{{ msg }}</p>
    </div>

</template>

<script setup>
import { onMounted, ref, computed } from 'vue';

const students = ref([])
const msg = ref('')
const search = ref('')
const selectedLevel = ref('')
const selectedClass = ref('')
const selectedStat = ref('')

const fetchStudents = async () => {
    try {
        const response = await fetch('http://localhost:8000/filter.php');
        students.value = await response.json();
    } catch (error) {
        console.error("Erreur lors de la récupération des données :", error);
    }
}

onMounted(() => {
    fetchStudents();
})

const filteredStudents = computed(() => {
    return students.value.filter(student => {

        const matchesSearch = !search.value || 
            (student.nom && student.nom.toLowerCase().includes(search.value.toLowerCase())) ||
            (student.matricule && student.matricule.toLowerCase().includes(search.value.toLowerCase()));

        const matchesLevel = !selectedLevel.value || student.niveau === selectedLevel.value;


        const matchesClass = !selectedClass.value || student.parcours === selectedClass.value;


        const intNote = student.note !== null ? parseFloat(student.note) : null; // <--- CORRIGÉ ICI (const ajouté)
        let matchesStat = true;
        if (selectedStat.value === 'reussi') {
            matchesStat = intNote !== null && intNote >= 10;
        } else if (selectedStat.value === 'en attente') {
            matchesStat = intNote === null || intNote < 10;
        }

        return matchesSearch && matchesLevel && matchesClass && matchesStat;
    });
});

const totalStudents = computed(() => filteredStudents.value.length);

const update = async (student) => {
  const nom = prompt("Modifier le nom :", student.nom || '');
  const prenom = prompt("Modifier le prenom :", student.prenom || '');
  const niveau = prompt("Modifier le niveau: ", student.niveau || '');
  const parcours = prompt("Modifier le parcours: ", student.parcours || '');
  const email = prompt("Modifier l'email :", student.adr_email || '');
  const annee = prompt("Modifier l'année universitaire :", student.annee_univ || '');
  const note = prompt("Modifier la note :", student.note !== null ? student.note : '');

  if (nom !== null && prenom !== null && niveau !== null && parcours !== null && email !== null && annee !== null && note !== null) {
    await fetch('http://localhost:8000/updateStudent.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        matricule: student.matricule,
        nom,
        prenom,
        niveau,
        parcours,
        adr_email: email,
        annee_univ: annee,
        note: note === "" ? null : note
      })
    });
    fetchStudents();
  }
}

const remove = async (matricule) => {
  if (confirm("Supprimer définitivement cet étudiant et ses notes ?")) {
    try {
      const response = await fetch('http://localhost:8000/removeStudent.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ matricule: matricule })
      });
      
      const result = await response.json();
      
      if (result.success) {
        fetchStudents(); 
      } else {
        alert("Erreur retournée par le serveur PHP : " + result.error);
      }
    } catch (error) {
      alert("Erreur de connexion avec deleteStudent.php : " + error);
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
        width: 2rem;
        border: 0;
        background-color: #f4f6f9;
        padding: 0.5rem;
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

    p.total{
        font-size: large;
        padding: 1rem;
    }
</style>