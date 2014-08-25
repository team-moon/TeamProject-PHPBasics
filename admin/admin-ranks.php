<form method="POST" action="" role="form">
    <label for="text">Rank title:</label>
    <label for="text">Min posts:</label><br>
    <input type="text" id="text" name="rank[]">
    <input type="number" id="rng" name="range[]">
    <input type="button" onclick="addBut()" id="addRank" value="+">
    <input type="button" onclick="remBut()" id="remRank" value="-">
    <div id="output"></div>
    <input type="submit"  id="remRank" name="submit-ranks">

    <script>
        var output = document.getElementById('output');
        output.style.width = '350px';

        var input = [];
        var num = [];
        var elems = 0;

        function addBut() {
            input[elems] = document.createElement('input');
            num[elems] = document.createElement('input');
            input[elems].type = 'text';
            num[elems].type = 'number';

            input[elems].name = "rank[]";
            num[elems].name = "range[]";
            input[elems].style.marginTop = "5px";
            num[elems].style.marginLeft = "4px";

            output.appendChild(input[elems]);
            output.appendChild(num[elems++]);

        }
        function remBut() {
            if (elems > 0){
            output.removeChild(input[elems - 1]);
            output.removeChild(num[--elems]);
            }
        }
    </script>
<?php

if(isset($_POST['rank'])){
    class ranks
    {
        public $title = "";
        public $range = "";
    }
$ranks = new ranks();
    $ranks->title = $_POST['rank'];
    $ranks->range = $_POST['range'];



}