<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Keygame</title>
        <script src='<?php echo base_url("static/js/jquery-2.2.0.js"); ?>'></script>
        <link href='<?php echo base_url("static/custom/css/keygame.css"); ?>' rel="stylesheet">
    </head>
    <body>
        <h3>Welcome to my keygame</h3>
        <p>Start entering a word, I will attempt to guess the word before you are finished typing it. 
        Hit space if you are done entering the word or click the word if you see it in the guessed list.</p>
        <small>I may lose now, but I will win definitely</small>
        <?php 
            /* This game aims to implement a very crude level of machine learning
            alongwith me trying to learn how the routing works in codeigniter ( the later part of the 
            introduction is useless ). So in this game, as the user starts to enter the word, we will
            start throwing guesses from the database. The html displays the guesses as clickable tags,
            the user can either select a tag (making it green) or continue to type. If we can not guess
            the word, the user hits the spacebar to indicate he is done entering the word.
            
            If the user agrees with one of our guesses he will click a tag, and so we will increase the   
            frequency value by 1, this will enable us to predict words with other users more accurately
            and quickly. If however, we can not guess the word and the user hits the spacebar we will add 
            the word to our database and initialize the frequency with 1. 
            
            In the database the words are all initialised with a frequency value of 1. The words with higher 
            frequency values are preferred when throwing the guesses.
            
            This game can be furthered developed into a game where the user enters a sentence and we 
            will return the word that describes the sentence closest, kinda like jeopardy.*/ 
        
        ?>
        <form id="form">
            <input type="text" id="word" name="word" size="60">
        </form>
        <div id="result">
        
        </div>
        <div id="overlay" class="overlay"></div>
        <div id="modal"></div>
        <script src='<?php echo base_url("static/custom/js/tags.js") ; ?>'></script>
        <script src='<?php echo base_url("static/custom/js/ajax.js") ?>'></script>
    </body>
</html>