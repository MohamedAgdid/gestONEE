<?php 
session_start(); 
if (empty($_SESSION['Empl'])) {
    header("Location: login.html");
    exit();
}
require_once("../connection.php");

?>
<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-100"> 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GestONEE</title>
  <link href="../output.css" rel="stylesheet">
  <link href="../style2.css" rel="stylesheet">
  <script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>
  
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
            echo "<h1 class='text-sm font-medium text-gray-900 hover:underline'>".$_SESSION['Empl']."</h1>";    
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

            
            <button onclick="showadd()" class="ml-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:ring-blue-500">Demande de Congé</button>
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

    <div id="addmodel" class="hidden mt-6 bg-white p-6 rounded-lg shadow-lg">
    <span class="close" onclick="closeadd()">&times;</span>
        <h2 class="text-2xl font-semibold leading-tight mb-6">Demande de Congé</h2> 
        <?php
        $select = $pdo->prepare("select datefin,effectue,nbr_rest from congees where ide=?");
        $select->execute([$_SESSION['idE']]);
        $data=$select->fetch();
        if(empty($data)){
          $Days_rest=22;
          
        }
        else{
          $Days_rest = json_encode($data['nbr_rest']);

        }
       
        if($data['effectue']== 'non' || empty($data)){
          echo " <form action='action.php' method='POST'>
        <input type='hidden' name='form_type' value='congee_demande'>
        <input type='hidden' name='idC' value=".$_SESSION['idE'].">
        <input type='hidden' name='idC' value=".$_SESSION['IDService'].">
        <input type='hidden' name='restday' value=".$Days_rest.">

          <div class='mb-4'>
             <label f class='block text-sm font-medium text-gray-700'>vous avez : $Days_rest j</label>
             <br>
          </div>
          <div class='mb-4'>
            <label for='start_date' class='block text-sm font-medium text-gray-700'>Date de début</label>
            <input type='date' id='start_date' name='start_date' required class='border mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50' onchange='setEndDate()' >
          </div>
          <div class='mb-4'>
            <label for='end_date' class='block text-sm font-medium text-gray-700'>Date de fin</label>
            <input type='date' id='end_date' name='end_date' required class='border mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50'>
          </div> 
          <div class='mb-4'>
            <label for='reason' class='block text-sm font-medium text-gray-700'>Motif</label>
            <textarea id='reason' name='reason' rows='4' required class='border mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50'></textarea>
          </div>
          <div class='text-right'>
            <button type='submit' class='inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2'>Soumettre</button>
          </div>
        </form>";
        

        }
        else{
         echo " <p>Congé déjà pris.</p>";
        }
        
        ?>
       
      </div>



      <div id='tab' class="rounded-lg">
        <h2 class="text-2xl font-semibold leading-tight mb-6">Historique des Congés</h2>
        <table class="min-w-full leading-normal">
          <thead>
            <tr style="background-color: #111827;">
              <th style="background-color: transparent;" class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-white uppercase tracking-wider">Date de début</th>
              <th style="background-color: transparent;" class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-white uppercase tracking-wider">Date de fin</th>
              <th style="background-color: transparent;" class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-white uppercase tracking-wider">Statut</th>
              <th style="background-color: transparent;" class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-white uppercase tracking-wider">Recu</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $select = $pdo->prepare("SELECT * FROM congees WHERE ide = ? ORDER BY datedebut DESC");
            $select->execute([$_SESSION['idE']]);
            $rows=$select->fetchAll();

            foreach($rows as $row) {
              echo "<tr>";
              echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>" . htmlspecialchars($row['datedebut']) . "</td>";
              echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>" . htmlspecialchars($row['datefin']) . "</td>";
              
              if($row['statut']==='Approuvé'){ 
                echo "<td class='px-5 py-5 border-b text-sm'><span class='px-3 py-1 text-white font-bold inset-0 rounded-full' style='background-color:green;'>" . htmlspecialchars($row['statut']) . "</span></td>";

                echo "<form id='Download' action='action.php' method='post' target='_blanck'>
                <input type='hidden' id='idD' name='idD'>
                <input type='hidden' name='form_type' value='downloadrecu'>
                </form>";
                echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'><button class='px-3 py-1 text-white font-bold border-b text-sm inset-0 rounded-full' style='background-color:blue;' onclick='generatePdf(".$row['id'].")'>Telecharger</button></td>";
              }
              else{
                if($row['statut'] === 'Rejeté'){
                  $col='red';
                }
                else{
                  $col='orange';
                }
                echo "<td class='px-5 py-5 border-b text-sm'><span class='px-3 py-1 text-white font-bold inset-0 rounded-full' style='background-color:$col;'>" . htmlspecialchars($row['statut']) . "</span></td>";
                echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'></td>";
              }
              
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>


   

    
           
    </div>
    </div>
</div>

  

<script>
      
      function showadd(){
        document.getElementById('addmodel').style.display = 'block';
        document.getElementById('tab').style.display = 'none';
       
      }
      function generatePdf(id){
        document.getElementById('idD').value=id;
        document.getElementById('Download').submit();
      }
       function closeadd() {
            document.getElementById('addmodel').style.display = 'none';
            document.getElementById('tab').style.display = 'block';
        }

        function setEndDate() {
  const startDateInput = document.getElementById('start_date');
  const endDateInput = document.getElementById('end_date');
  const startDate = new Date(startDateInput.value);
  
  if (isNaN(startDate.getTime())) {
    endDateInput.value = '';
    return;
  }

  const endDate = new Date(startDate);
  endDate.setDate(startDate.getDate() + <?php echo $Days_rest; ?>);

  endDateInput.value = endDate.toISOString().split('T')[0];
  endDateInput.setAttribute('max', endDate.toISOString().split('T')[0]);
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