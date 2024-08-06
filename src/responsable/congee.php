<?php 
session_start(); 
if (empty($_SESSION['Direct'])) {
    header("Location: login.html");
    exit();
}
$responable = $_SESSION['Direct'];
require_once("../connection.php");

?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100"> 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GestONEE</title>
  <link href="../output.css" rel="stylesheet">
  <link href="../style2.css" rel="stylesheet">
  <style>
    .center {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
}

.menu-card{
  border: 1px solid #d3d3d3; 
  border-radius: 12px;
  padding: 20px; 
  width: calc(25% - 20px); 
  box-sizing: border-box;
  transition: transform 0.3s ease; 
}

.menu-card:hover {
  transform: translateY(-10px);
}

.menu-card .info {
  display: flex;
  gap: 1rem;

}

.info span {
  font-weight: bold;
}

.add-modal{
            display: block;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
      
  .addmodal-content {
            margin: 5% auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }


  </style>
  
  
</head>
<body class="h-full">
<div class="min-h-full">
   
    <header class="bg-white shadow-sm lg:static lg:overflow-y-visible" x-state:on="Menu open" x-state:off="Menu closed" :class="{ 'fixed inset-0 z-40 overflow-y-auto': open }" x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex justify-between lg:gap-8 xl:grid xl:grid-cols-12">
          <div class="flex md:absolute md:inset-y-0 md:left-0 lg:static xl:col-span-2">
            <div class="flex flex-shrink-0 items-center">
              <a href="#">
                <h1 class="font1 block h-8 w-auto">GestONEE</h1>
                </a>
            </div>
          </div>
          <div class="min-w-0 flex-1 md:px-8 lg:px-0 xl:col-span-6">
            <div class="flex items-center px-6 py-4 md:mx-auto md:max-w-3xl lg:mx-0 lg:max-w-none xl:px-0">
              <div class="w-full">
                <label for="search" class="sr-only">Search</label>
                <div class="relative">
                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" x-description="Heroicon name: mini/magnifying-glass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
  <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"></path>
</svg>
                  </div>
                  <input id="search" name="search" class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 text-sm placeholder-gray-500 focus:border-blue-900 focus:text-gray-900 focus:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-900 sm:text-sm" placeholder="Search" type="search">
                </div>
              </div>
            </div>
          </div>
          <div class="hidden lg:flex lg:items-center lg:justify-end xl:col-span-4">
            <?php 
            echo "<h1 class='text-sm font-medium text-gray-900 hover:underline'>".$_SESSION['Direct']."</h1>";    
            ?>

            <div x-data="Components.menu({ open: false })" x-init="init()" @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative ml-5 flex-shrink-0">
              <div>
                  <img loading="lazy" class="h-8 w-8 rounded-full" src="../../img/er1.png" alt="profile">
              </div>
              
                <div style="display: none;" x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state." x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" @keydown.ardata-up.prevent="onArdataUp()" @keydown.ardata-down.prevent="onArdataDown()" @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()" @keyup.space.prevent="open = false; focusButton()">
                  
                    <a href="#" class="block py-2 px-4 text-sm text-gray-700" x-state:on="Active" x-state:off="Not Active" :class="{ 'bg-gray-100': activeIndex === 0 }" role="menuitem" tabindex="-1" id="user-menu-item-0" @mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, 0)" @mouseleave="onMouseLeave($event)" @click="open = false; focusButton()">Mon compte</a>
                  
                    <a href="#" class="block py-2 px-4 text-sm text-gray-700" :class="{ 'bg-gray-100': activeIndex === 1 }" role="menuitem" tabindex="-1" id="user-menu-item-1" @mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, 1)" @mouseleave="onMouseLeave($event)" @click="open = false; focusButton()">Paramètres</a>
                  
                    <a href="#" class="block py-2 px-4 text-sm text-gray-700" :class="{ 'bg-gray-100': activeIndex === 2 }" role="menuitem" tabindex="-1" id="user-menu-item-2" @mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, 2)" @mouseleave="onMouseLeave($event)" @click="open = false; focusButton()">se déconnecter</a>
                  
                </div>
            </div>

            
         </div>
        </div>
      </div>


      
    </header>
        
    <div class="flex py-5 ml-8">
      <nav class="bg-gray-900 rounded-t-lX px-14 py-11 flex flex-col sticky top-4 text-white shadow-lg">
    <img loading="lazy" class="h-24 w-24 rounded-full" src="../../img/er1.png" alt="profile" />
    <br>
    <a href="home.php" class="text-gray-900 flex items-center px-3 py-2 text-sm font-medium rounded-md" aria-current="page" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-200 text-gray-900&quot;, Default: &quot;text-gray-700 hover:bg-blue-700&quot;">
                <img loading="lazy" src="../../img/home(2).png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7 "></img>
                <span class="text-white">Home</span>
              </a>
              
              <a href="missions.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-3 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
              <img loading="lazy" src="../../img/briefcase.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                <span class="text-white">Mission</span>
              </a>
            
              <a href="congee.php" class="bg-blue-700 text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
              <img loading="lazy" src="../../img/calendar(1).png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                <span class="text-white">Congee</span>
              </a>
            
              <a href="analyse.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
              <img loading="lazy" src="../../img/chat-arrow-grow.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                <span class="text-white">Analyse</span>
              </a>
                 

              <a href="courier.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
                <img loading="lazy" src="../../img/envelope.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                  <span class="text-white text-nowrap">Courier</span>
                </a>

                <a href="logout.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
                <img loading="lazy" src="../../img/exit.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                  <span class="text-white text-nowrap">logout</span>
                </a>
    </nav>
    <div class="ml-9 w-full">
    <?php if (isset($_SESSION['succes'])): ?>
    <div class="overlay" style="display: block;" id="overlay"></div>
    <div id="alert" class="bg-white p-6 rounded-lg shadow-lg w-80">
        <span class="absolute close" onclick="closemess()">&times;</span>
        <!-- <span class="absolute top-2 right-2 text-2xl cursor-pointer" onclick="closemess()">&times;</span> -->
        <div class='flex flex-col items-center justify-center mb-4'>
            <img class="w-24 h-24 mb-3" src="../../img/check.png" alt="checked">
            <span class="text-xl font-bold text-green-600">Succès !</span>
            <p class='text-black text-sm leading-relaxed mt-4'>
            Votre opération a été réalisée avec succès.
        </p>
        </div>
       
    </div>
<?php endif; 
unset($_SESSION['succes']);?>
    <div id='tab' class="rounded-lg" >
    <div class="py-8">
                <div class="flex justify-between mb-6">
                    <h2 class="text-2xl font-semibold leading-tight">Congees</h2>
                </div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
    <thead>
        <tr style="background-color: #111827;">
            <th style="background-color: transparent;" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-white uppercase tracking-wider">
                Picture
            </th>
            <th style="background-color: transparent;" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-white uppercase tracking-wider">
                Employee Name
            </th>
            <th style="background-color: transparent;" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-white uppercase tracking-wider">
                Demande Congés
            </th>
            <th style="background-color: transparent;" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-white uppercase tracking-wider">
                Date Début
            </th>
            <th style="background-color: transparent;" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-white uppercase tracking-wider">
                Date Fin
            </th>
            <th style="background-color: transparent;" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-white uppercase tracking-wider">
                Actions
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $selectEmployees = $pdo->prepare("SELECT id, picture, name FROM employee WHERE idservice = ?");
        $selectEmployees->execute(array($_SESSION['IDService']));
        $employees = $selectEmployees->fetchAll();
      
        
        foreach ($employees as $employee) {
          
          $selectLeaves = $pdo->prepare("SELECT id,datedebut, datefin, demande,statut,nbr_rest FROM congees WHERE ide = ?");
          $selectLeaves->execute(array($employee['id']));
          $leaveDatas = $selectLeaves->fetchAll();
          foreach($leaveDatas as $leaveData){
          if( $leaveData['demande'] === 'oui' && $leaveData['statut'] === 'En Attente'){

            echo "<tr class='text-center'>";
            echo "<td class='flex justify-center items-center'>";
            if (!empty($employee['picture'])) {
                echo "<img class='rounded-full' src='images/{$employee['picture']}' alt='Profile Picture'>";
            } else {
                echo "<img class='rounded-full' style='height: 3rem; width: 3rem' src='images/emp.png' alt='Profile Picture'>";
            }
            echo "</td>";
            echo "<td>{$employee['name']}</td>";
            echo "<td>{$leaveData['demande']}</td>";
            echo "<td>{$leaveData['datedebut']}</td>";
            echo "<td>{$leaveData['datefin']}</td>";
            echo "<td><form id='answer' action='action.php' method='post'>
             <input type='hidden' name='answer' id='resp'>
             <input type='hidden' name='idDemande' id='idDemande'>
             <input type='hidden' name='idEmp' value=".$employee['id'].">
             <input type='hidden' name='datdebut' id='datdebut' value=".$leaveData['datefin'].">
             <input type='hidden' name='datefin' id='datefin' value=".$leaveData['datefin'].">
             <input type='hidden' name='nbr_rest' id='nbr_rest' value=".$leaveData['nbr_rest'].">
             <input type='hidden' name='form_type' id='resp' value='answer_congee'></form>";
            echo "<button class='px-3 py-1 text-sm text-white font-bold inset-0 rounded-full' style='background-color:green;' onclick='accepter(".$leaveData['id'].")'>Accepter</button>";
           

            echo " ";
            echo "<button class='px-3 py-1 text-sm text-white font-bold inset-0 rounded-full' style='background-color:red;' onclick='refuser(".$leaveData['id'].")'>Refuser</button>";
            echo "</td>";
            echo "</tr>";
        }
      }
      }
        ?>
    </tbody>
</table>

                    </div>
                </div>
            </div>
    </div>

 
  
   
    </div>
    </div>
    
</div>

  

<script>
      
      function showadd(){
        document.getElementById('addmodel').style.display = 'block';
        document.getElementById('tab').style.display = 'none';
       
      }
       function closeadd() {
            document.getElementById('addmodel').style.display = 'none';
            document.getElementById('tab').style.display = 'block';
        }
        
        function refuser(id){
          document.getElementById('resp').value="Rejeté";
          document.getElementById("idDemande").value=id;
          document.getElementById('answer').submit();

        }

        function accepter(id){
          document.getElementById('resp').value="Approuvé";
          document.getElementById("idDemande").value=id;
          document.getElementById('answer').submit();

            
        }
        function closemess() {
        document.getElementById('alert').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
     setTimeout(function() {
        closemess();
    }, 3000);
    </script>



</body>
       

</html>