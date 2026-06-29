<template>

    <!--<h3>Etudiant</h3>-->

    <form>

        <div class="item2">

            <div class="item1">
            <div>
                <label for="level">Niveau :</label>
                    <select name="level" id="level">
                    <option value="L1">L1</option>
                    <option value="L2">L2</option>
                    <option value="L3">L3</option>
                    <option value="M1">M1</option>
                    <option value="M2">M2</option>
                </select>
            </div>

            <div>
                <label for="class">Parcours :</label>
                    <select name="class" id="class">
                    <option value="GB">GB</option>
                    <option value="IG">IG</option>
                    <option value="SR">SR</option>
                </select>
            </div>
        </div><br>

            <label for="number">Matricule :</label>
            <input type="int" id="number" required><br><br>

            <label for="name">Nom :</label><br>
            <input type="text" id="name" required><br><br>

            <label for="fstName">Prénom :</label><br>
            <input type="text" id="fstName" required><br><br>

            <label for="email">Email :</label><br>
            <input type="email" id="email" required><br><br><br>

            <div class="ok">
                <button type="reset" class="btnReset"><img src="/src/assets/icons8-rendez-vous-périodique-24-black.png" alt=""></button>
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