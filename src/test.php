
<?php if (isset($_SESSION['error'])): ?>
    <div class="overlay" style="display: block;" id="overlay"></div>
    <div id="alert" class="bg-white p-6 rounded-lg shadow-lg w-80">
        <span class="absolute close" onclick="closemess()">&times;</span>
        <div class='flex flex-col items-center justify-center mb-4'>
            <img class="w-24 h-24 mb-3" src="../img/error.png" alt="error">
            <span class="text-xl font-bold text-red-600">Erreur !</span>
            <p class='text-black text-sm leading-relaxed mt-4'>
                <?php echo $_SESSION['error']; ?>
            </p>
        </div>
    </div>
<?php endif; 
unset($_SESSION['error']);?>


function closemess() {
        document.getElementById('alert').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
     setTimeout(function() {
        closemess();
    }, 3000);





    