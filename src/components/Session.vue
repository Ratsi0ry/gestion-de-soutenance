<template>

    <form>

        <div class="sessionContent">
            <div class="container">
                <label for="matr">Matricule :</label>
                <input type="number" id="matr"><br><br>

                <label for="org">idorg :</label><br>
                <input type="int" id="org"><br><br>

                <label for="design">Design :</label><br>
                <input type="text" id="design"><br><br>

                <label for="room">Lieu :</label><br>
                <input type="text" id="room"><br><br>

                <label for="year">Annee univ :</label>
                <input type="text" id="year" placeholder="de type 2022-2023"><br><br>

                <label for="score">Note :</label>
                <input type="int" id="score" placeholder="/20"><br><br>

    
                <label for="chief">id President :</label>
                <select name="chief" id="chief">
                    <option value="c1">01</option>
                    <option value="c2">02</option>
                    <option value="c3">03</option>
                </select><br><br>

                <div class="auditors">
                    <div>
                        <label for="auditor-multiple">id Examinateur :</label>
                        <select name="auditor[]" id="auditor">
                            <option value="a1">01</option>
                            <option value="a2">02</option>
                            <option value="a3">03</option>
                        </select>
                    </div>
                    <div>
                        <button>add</button><br><br>
                    </div>
                </div>

                <div class="reporters">
                    <div>
                        <label for="reporter">Rapporteur :</label>
                        <select name="reporter" id="reporter">
                            <option value="r1">01</option>
                            <option value="r2">02</option>
                            <option value="r3">03</option>
                        </select>
                    </div>
                    <div>
                        <button>add</button><br><br>
                    </div>
                </div><br>

                <div class="finalBtn">
                    <button type="submit">Valider</button>
                    <button> telecharger le pdf</button>
                </div>

            </div>
        </div>
            
    </form>

</template>

<script setup></script>
<style scoped>
    .sessionContent{
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }

    .container{
        padding: 2rem; 
        border-radius: 8px;
        font-size: large;
        /*font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;*/
        background-color: #f1f5f9;
        border: 1px solid #a7a8aa;
    }

    input#matr{
        width: 6rem;
    }

    input#year, input#score{
        width: 8rem;
    }

    input{
        width: 20rem;
        font-size: medium;
        border-radius: 5px;
        border: 1px solid  rgba(0, 0, 0, 0.466);
    }

    .auditors, .reporters{
        display: flex;
        gap: 0.5rem;
    }

    .finalBtn{
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
</style>