<template>

    <!--<h3>Etudiant</h3>-->

    <form>

        <div class="item2">

            <div class="item1">
            <div>
                <label for="idProf">id prof :</label>
                <input type="text" id="idProf" required>
            </div>

            <div>
                <label for="gender">Civilité:</label>
                    <select name="gender" id="gender">
                    <option value="Mr">Mr</option>
                    <option value="Mlle">Mlle</option>
                    <option value="Mme">Mme</option>
                </select>
            </div>
        </div><br>

            <label for="name">Nom :</label><br>
            <input type="text" id="name" required><br><br>

            <label for="fstName">Prénom :</label><br>
            <input type="text" id="fstName" required><br><br>

            <label for="status">Grade : </label><br>
            <select name="status" id="status">
                <option value="val1">Assistant d'Enseignement Supérieur et de recherche</option>
                <option value="val2">Proffeseur titulaire</option>
                <option value="val3">Maître de Conférences</option>
                <option value="val4">Docteur HDR</option>
                <option value="val5">Docteur en Informatique</option>
                <option value="val6">Doctorant en Informatique</option>
            </select><br><br>

            <div class="ok">
                <button type="reset" class="btnReset"><img src="/src/assets/icons8-rendez-vous-périodique-24.png" alt=""></button>
                <button type="submit" class="btnSubmit">Valider</button>
            </div>
        </div>

    </form>
</template>

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