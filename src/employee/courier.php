<?php 
session_start(); 
if (empty($_SESSION['Empl'])) {
    header("Location: login.html");
    exit();
}

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
<body class="h-full relative">
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
                <img onclick='profile()'  loading="lazy" class="h-8 w-8 rounded-full" src="../../img/er1.png" alt="profile">
                   </div>
              
            </div>
            <button onclick="add()" class="ml-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:ring-blue-500">Envoyer Message</button>
          </div>
        </div>
      </div>


      
    </header>
        
    <div class="flex py-5 ml-8 w-auto">
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
            
              <a href="congee.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
              <img loading="lazy" src="../../img/calendar(1).png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                <span class="text-white">Congee</span>
              </a>
            
              <a href="analyse.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
              <img loading="lazy" src="../../img/chat-arrow-grow.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                <span class="text-white">Analyse</span>
              </a>
                 

              <a href="courier.php" class="bg-blue-700 text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
                <img loading="lazy" src="../../img/envelope.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                  <span class="text-white text-nowrap">Courier</span>
                </a>

                <a href="logout.php" class="text-gray-700 hover:bg-blue-700 flex items-center px-3 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-200 text-gray-900&quot;, undefined: &quot;text-gray-700 hover:bg-blue-700&quot;">
                
                <img loading="lazy" src="../../img/exit.png" class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-7 w-7"></img>
                  <span class="text-white text-nowrap">logout</span>
                </a>


            
    </nav>
    <div class="ml-9 w-full">

    <form id='delete-form' action="action.php" method='post'>
   <input type="hidden" name="form_type" value="deletemess">
   <input type="hidden" id="idDelete" name="idDelete">

  </form>
  
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
    

    <div id='details' class="mt-6 bg-white p-6 rounded-lg shadow-lg" style="display:none;">
    <div id="message_get"></div>
</div>
<div id='add' class="mt-6 bg-white p-6 rounded-lg shadow-lg" style="display:none;">
    <span class='close' onclick='closeadd()'>&times;</span><br>
    <h1 class='text-2xl font-bold mb-6'>Courier</h1>
    <form action="action.php" method="post"> 
        <input type="hidden" name="form_type" value="send_email">
        <?php 
        echo "<input type='hidden' name='idSender' value=".$_SESSION['idE'].">";
        ?>

        <?php
        $selct = $pdo->prepare("SELECT e.name AS employee_name, e.id AS employee_id, r.name AS responsable_name, r.id AS responsable_id FROM employee e INNER JOIN responsable r ON e.idservice = r.idservice WHERE e.idservice = ?");
        //$selct = $pdo->prepare("SELECT r.name AS responsable_name, r.id AS responsable_id FROM responsable r  WHERE r.idservice = ?");
        
        $selct->execute([$_SESSION['IDService']]);
        $datas = $selct->fetchAll();

        echo 'A : <select name="idDist" class="w-36 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 sm:text-sm">';
        $displayResponsable = true;
        foreach($datas as $row) {
            echo '<option value="' . htmlspecialchars($row['employee_id']) . '">' . htmlspecialchars($row['employee_name']) . ' (Employee)</option>';
            if ($displayResponsable) {
              echo '<option value="' . htmlspecialchars($row['responsable_id']) . '">' . htmlspecialchars($row['responsable_name']) . ' (Responsable)</option>';
              $displayResponsable = false;
          }   
        }
        echo '</select>';
        ?>
        <textarea placeholder='Reply here' name='mess' class='border w-full' style='margin-top:1.5rem; resize: none; height:15rem;'></textarea>
        <button class='ml-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:ring-blue-500' type='submit'>Envoyer</button>
    </form>
</div>

<div id='tab' class="inline-block min-w-full shadow-md rounded-lg overflow-hidden" style="display: block;">
    <?php
    $select = $pdo->prepare("SELECT id, idsender, date, message, seen FROM courier WHERE idDistinateur = ? ORDER BY seen ASC, date DESC"); 
    $select->execute([$_SESSION['idE']]);
    $data = $select->fetchAll();
    ?>

    <table class="min-w-full leading-normal border-collapse border bg-gray-900">
        <thead>
            <tr>
              
                <th class="px-5 py-3 border-b-2 bg-gray-900 text-left text-xs font-semibold text-white uppercase tracking-wider">
                    Expéditeur
                </th>
                <th class="px-5 py-3 border-b-2 bg-gray-900 text-left text-xs font-semibold text-white uppercase tracking-wider">
                    Message
                </th>
                <th class="px-5 py-3 border-b-2 bg-gray-900 text-left text-xs font-semibold text-white uppercase tracking-wider">
                    Date
                </th>
                <th class="px-5 py-3 border-b-2 bg-gray-900 text-left text-xs font-semibold text-white uppercase tracking-wider">
                   Action
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            function js_escape($str) {
                return str_replace(
                    ["\\", "\"", "'", "\n", "\r", "\t"],
                    ["\\\\", "\\\"", "\\'", "\\n", "\\r", "\\t"],
                    $str
                );
            } 
            ?>
            <?php
            if($data){

            
            
            foreach ($data as $row): 
            $rowColor = ($row['seen'] == 1) ? 'bg-gray-200' : 'bg-white'; ?>
            <tr class="<?php echo $rowColor; ?>">

                    <td style="background-color: transparent;" class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <?php 
                        $selectid = $pdo->prepare("SELECT name FROM responsable WHERE id = ?");
                        $selectid->execute([$row['idsender']]);
                        $nom = $selectid->fetch(); 
                        if (!$nom) {
                          $selectid = $pdo->prepare("SELECT name FROM employee WHERE id = ?");
                          $selectid->execute([$row['idsender']]);
                          $nom = $selectid->fetch();
                      } 
                        echo "<p class='text-gray-900 whitespace-no-wrap'>".htmlspecialchars($nom['name'])."</p>";
                        ?>
                    </td>
                    <td style="background-color: transparent;" class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <?php 
                        $shortMessage = strlen($row['message']) > 20 ? substr($row['message'], 0, 20) . "..." : $row['message'];
                        $escapedMessage = js_escape($row['message']);
                        echo "<button onclick='Details(\"" . htmlspecialchars($escapedMessage) . "\",\"" .htmlspecialchars($nom['name'])."\",\"" .htmlspecialchars($row['id'])."\",\"" . htmlspecialchars($row['idsender']) . "\",\"" .$_SESSION['idE']. "\")' class='text-gray-900 whitespace-no-wrap'>".$shortMessage."</button>";?>
                      
                    </td>
                    <td style="background-color: transparent;" class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($row['date']); ?></p>
                    </td>
                    <td style="background-color: transparent;" class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <button onclick="deleteMission(<?php echo $row['id'];?>)"><img src="../../img/delete(1).png" style="width:1.5rem;">
                    </td>

                </tr>
            <?php endforeach;}
            else{
                echo "<div class='p-4 bg-gray-100 text-gray-500 text-center rounded-lg mt-4'>
               Il n'y a pas de messages pour l'instant.
            </div>";
            } ?>
        </tbody>
    </table>
</div>

</div>
    </div></div>
  
  <script>
    function Details(mess,name,id,idSender,idDist) {
    document.getElementById('tab').style.display = 'none';
    document.getElementById('details').style.display = 'block';
    document.getElementById("message_get").innerHTML = "<span class='close' onclick='closeedit()'>&times;</span><br>" +"De :  <strong>" + name + " </strong><br><hr> " +"<br>"+ mess + "<br><br><form action='action.php' method='post'><input type='hidden' name='idSender' value='"+idSender+"'><input type='hidden' name='idDist' value='"+idDist+"'><input type='hidden' name='form_type' value='reply'><input type='hidden' name='id' value='"+id+"'><hr><br><textarea placeholder='reply here' name='replay-mess' class='w-full' style='resize: none; height:15rem;'></textarea><button class='ml-6 inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:ring-blue-500' type='submit'>Envoyer</button></form>";}

     function edit(id) {
            document.getElementById("id_empl").value = id;
            document.getElementById("editForm").submit();
        }
        function closeedit() {
         
         document.getElementById('tab').style.display = 'block';
         document.getElementById('details').style.display='none';
        
         
         
     }
     function add(){
      document.getElementById('add').style.display='block';
      document.getElementById('tab').style.display = 'none';
     }
     function closeadd(){
      document.getElementById('add').style.display='none';
      document.getElementById('tab').style.display = 'block';
     }

    //document.getElementById('tab').style.display = 'none';
    function closemess() {
        document.getElementById('alert').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
     setTimeout(function() {
        closemess();
    }, 3000);

    function deleteMission(id){
          document.getElementById("idDelete").value=id;
          document.getElementById("delete-form").submit();
        }


      


  </script>

  

  </body>