<?php 
session_start(); 
if (empty($_SESSION['Empl'])) {
    header("Location: ../login.html");
    exit();
}
require_once("../connection.php");

$missionsQuery = "SELECT 
    (SELECT COUNT(*) AS active FROM missions WHERE status = 'Active' AND ide = ?) AS active,
    (SELECT COUNT(*) AS pending FROM missions WHERE status = 'En attente' AND ide = ?) AS pending;
";
$congesQuery = "SELECT 
    (SELECT COUNT(*) AS active FROM congees WHERE statut = 'Approuvé' AND ide = ?) AS accept,
    (SELECT COUNT(*) AS pending FROM congees WHERE statut = 'En Attente' AND ide = ?) AS pending;
";

$missions = $pdo->prepare($missionsQuery);
$missions->execute([$_SESSION['idE'],$_SESSION['idE']]);
$missionsData = $missions->fetch(PDO::FETCH_ASSOC);

$conges = $pdo->prepare($congesQuery);
$conges->execute([$_SESSION['idE'],$_SESSION['idE']]);
$congesData = $conges->fetch(PDO::FETCH_ASSOC);

$requet = $pdo->prepare("SELECT COUNT(*) AS recu FROM courier WHERE idDistinateur = ? AND seen = ?");
$requet->execute([$_SESSION['idE'],0]);
$courierData=$requet->fetch(PDO::FETCH_ASSOC);


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

  nav a{
    display: flex;
    align-items: center;
    justify-content: flex-start;
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
            echo "<h1 class='text-sm font-medium text-gray-900 hover:underline'>".$_SESSION['Empl']."</h1>";    
            ?>

            <div x-data="Components.menu({ open: false })" x-init="init()" @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative ml-5 flex-shrink-0">
              <div>
                  <img loading="lazy" class="h-8 w-8 rounded-full" src="../../img/er1.png" alt="profile">
              </div>
              
                <div style="display: none;" x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state." x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()" @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()" @keyup.space.prevent="open = false; focusButton()">
                  
                    <a href="#" class="block py-2 px-4 text-sm text-white" x-state:on="Active" x-state:off="Not Active" :class="{ 'bg-gray-100': activeIndex === 0 }" role="menuitem" tabindex="-1" id="user-menu-item-0" @mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, 0)" @mouseleave="onMouseLeave($event)" @click="open = false; focusButton()">Mon compte</a>
                  
                    <a href="#" class="block py-2 px-4 text-sm text-white" :class="{ 'bg-gray-100': activeIndex === 1 }" role="menuitem" tabindex="-1" id="user-menu-item-1" @mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, 1)" @mouseleave="onMouseLeave($event)" @click="open = false; focusButton()">Paramètres</a>
                  
                    <a href="#" class="block py-2 px-4 text-sm text-white" :class="{ 'bg-gray-100': activeIndex === 2 }" role="menuitem" tabindex="-1" id="user-menu-item-2" @mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, 2)" @mouseleave="onMouseLeave($event)" @click="open = false; focusButton()">se déconnecter</a>
                  
                </div>
              
            </div>

            <button onclick="showadd()" class="ml-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:ring-blue-500">Ajouter des Notes</button>
          </div>
        </div>
      </div>


      
    </header>
        
    <div class="flex py-5 ml-8 w-auto">
      <nav class="bg-gray-900 rounded-t-lX px-14 py-11 flex flex-col sticky top-4 text-white shadow-lg">
    <img loading="lazy" class="h-24 w-24 rounded-full" src="../../img/er1.png" alt="profile" />
    <br>
    <a href="home.php" class="bg-blue-700 text-gray-900 flex items-center px-3 py-2 text-sm font-bold rounded-md" aria-current="page" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-200 text-gray-900&quot;, Default: &quot;text-gray-700 hover:bg-blue-700&quot;">
                <img loading="lazy" src="../../img/home(2).png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7 "></img>
                <span class="text-white">Home</span>
              </a>
              
              <a href="missions.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-3 text-sm font-bold rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
              <img loading="lazy" src="../../img/briefcase.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                <span class="text-white">Mission</span>
              </a>
            
              <a href="congee.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-bold rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
              <img loading="lazy" src="../../img/calendar(1).png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                <span class="text-white">Congee</span>
              </a>
            
              <a href="analyse.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-bold rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
              <img loading="lazy" src="../../img/chat-arrow-grow.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                <span class="text-white">Analyse</span>
              </a>
                 

              <a href="courier.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-bold rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
                <img loading="lazy" src="../../img/envelope.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                  <span class="text-white text-nowrap">Courier</span>
                </a>

                <a href="logout.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-bold rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
                <img loading="lazy" src="../../img/exit.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                  <span class="text-white text-nowrap">logout</span>
                </a>


            
    </nav>
    <div class="ml-9 w-full">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div style="background-color: #1d4ed8;" class=" p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-2 text-white">Missions</h2>
        <p class="text-white">Active: <?= $missionsData['active'] ?? 0 ?></p>
        <p class="text-white">En Attente: <?= $missionsData['pending'] ?? 0 ?></p>
    </div>
    <div style="background-color: #1d4ed8;" class=" p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-2 text-white">Congés</h2>
        <p class="text-white">Accept: <?= $congesData['accept'] ?? 0 ?></p>
        <p class="text-white">En Attente: <?= $congesData['pending'] ?? 0 ?></p>
    </div>
    <div style="background-color: #1d4ed8;" class=" p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-2 text-white">Courier</h2>
        <p class="text-white">Recu : <?= $courierData['recu'] ?? 0 ?></p>
        
    </div>
</div>

            <div class="mt-6 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-2">Note : </h2>
            <?php
                $select=$pdo->prepare("select note from employee where id=?");
                $select->execute([$_SESSION['idE']]);
                $data=$select->fetch();
                if($data){
                  echo $data['note'];

                }
                else{
                  echo "no note";
                }
                

            ?>

            </div>
            <div class="mt-6 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-2">Dernières mises à jour</h2>
                <ul class="list-disc pl-5">
                    <br>
                    <?php
                  $sel = $pdo->prepare("SELECT name FROM missions WHERE ide = ? ORDER BY date DESC LIMIT 1;");
                  $sel->execute([$_SESSION['idE']]);
                  $dat = $sel->fetch(PDO::FETCH_ASSOC);

                  $congeesQuery = $pdo->prepare("SELECT datedebut FROM congees WHERE statut = 'En Attente' AND ide = ?");
                  $congeesQuery->execute([$_SESSION['idE']]);
                  $congees = $congeesQuery->fetch(PDO::FETCH_ASSOC);
                 
                  echo " <li class='text-gray-700'><span style='color:#e6220c'>Nouvelle mission :</span> <strong>".$dat['name']."</strong></li>
                  <br>";
                  if ($congees) {
          foreach ($congees as $congee) {
              $selec=$pdo->prepare("select name from employee where id=?");
              $selec->execute([$congee['ide']]);
              $name=$selec->fetch();
              echo "<li class='text-gray-700'><span style='color:#e6220c'>Congé à venir :</span><strong> " . htmlspecialchars($name['name']) . "</strong><span style='color:#e6220c'> à partir du</span> <strong>" . date('d/m/Y', strtotime($congee['datedebut'])) . "</strong></li>";
          }
      } else {
          echo "<li style='color:#e6220c'>Aucun congé à venir.</li>";
      }?>
                </ul>
            </div>
        </div>
    </div>
    <div id="add-Modal" class="add-modal" style="display: none;">
            <div class="addmodal-content" style="height: 100%;">
                <form id="patientForm" method='post' action='action.php' style="height: 70%;  margin: 20px auto;padding: 20px;border: 1px solid #ccc;border-radius: 5px;background-color: white;width: 40%;margin-left: 35%;">
                <span class="close" onclick="closeadd()">&times;</span>
                <h2 class="text-2xl font-bold mb-2">Note</h2>
                <br> 
                <input type="hidden" name="form_type" value="form-note">
              <textarea name="note" id="note" class="ml-6 rounded-sm" style="background-color:#f9f9f9;width: 29rem; height:16rem; resize:none;"></textarea>
              <br>
              <br>
              <button type="submit" class="ml-9 inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:ring-blue-500">Submit</button></td>
    </form>        
    </div>
    </div>

        

        

    <script>
      function showadd(){
        document.getElementById('add-Modal').style.display = 'block';
      }
       function closeadd() {
            document.getElementById('add-Modal').style.display = 'none';
        }
    </script>


</body>
       

</html>